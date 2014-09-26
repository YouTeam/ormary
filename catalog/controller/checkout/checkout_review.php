<?php  
class ControllerCheckoutCheckoutReview extends Controller { 
	public function index() {
		if (!$this->cart->hasProducts()) 
		{
			$this->redirect($this->url->link('common/home'));
		}
		else
		{
			if (!$this->customer->isLogged()) 
			{
				$this->redirect($this->url->link('checkout/checkout_login'));
			}	
		}
		
		
		if(!isset($this->session->data['shipping_address_id'])) 
		{
			$this->redirect($this->url->link('checkout/checkout_shipping'));
		}
		elseif(!isset($this->session->data['payment_method'])) 
		{
			$this->redirect($this->url->link('checkout/checkout_payment'));
		}
	
		$this->load->model('tool/image');

		$this->data['products'] = array();

		$products = $this->cart->getProducts();

		$total_cart_price = 0;	
		$this->data['payment_error'] = false;	
			
		foreach ($products as $product) 
		{
			$product_total = 0;
			if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				} else {
					$image = '';
				}

				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['option_value'];
					} else {
						$filename = $this->encryption->decrypt($option['option_value']);

						$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));					
				} else {
					$price = false;
				}
				

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
				} else {
					$total = false;
				}
				
				$total_cart_price += $product['price']*$product['quantity'];
				
				$this->data['products'][] = array(
					'key'                 => $product['key'],
					'product_id'          => $product['product_id'],
					'thumb'               => $image,
					'name'                => $product['name'],
					'model'               => $product['model'],
					'option'              => $option_data,
					'quantity'            => $product['quantity'],
					'price'               => $price,
					'total'               => $total,
					'href'                => $this->url->link('product/product', 'product_id=' . $product['product_id']),
					'profile_name'        => $product['profile_name'],
					'manufacturer'        => $product['manufacturer'],
				);				
		}
		
		$shipping_price = $this->session->data['shipping_price'];
		$this->data['action_link'] = $this->url->link('checkout/checkout_review');
		
			
		
		$this->language->load('checkout/custom_checkout');
		$this->document->setTitle($this->language->get('checkout_payment_title'));
		
		$this->data['shipping_link'] = $this->url->link('checkout/checkout_shipping', '', 'SSL');
		$this->data['payment_link'] = $this->url->link('checkout/checkout_payment', '', 'SSL');

		

		$this->data['shipping_price'] = $this->currency->format($shipping_price, $product['tax_class_id'], $this->config->get('config_tax'));
		$this->data['shipping_cost'] = $shipping_price;
		
		$this->data['order_price'] = $this->currency->format($total_cart_price + $shipping_price , $product['tax_class_id'], $this->config->get('config_tax'));
							
		$this->load->model('account/address');
		$shipping_address =  $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
		
		
		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');			
		
		$shipping_country_name = $this->model_localisation_country->getCountry($shipping_address['country_id']); 
		$shipping_zone_name = $this->model_localisation_zone->getZone($shipping_address['zone_id']);	
		
		$this->data['shipping_firstname'] = $shipping_address['firstname'];
		$this->data['shipping_lastname'] = $shipping_address['lastname'];
		$this->data['shipping_country'] = $shipping_country_name['name'];
		$this->data['shipping_address_1'] = $shipping_address['address_1'];
		$this->data['shipping_address_2'] = $shipping_address['address_2'];
		$this->data['shipping_city'] = $shipping_address['city'];
		$this->data['shipping_zone'] = $shipping_zone_name['name'];
		$this->data['shipping_postcode'] = $shipping_address['postcode'];

		
		
		if($this->session->data['payment_method'] == 'paypal')
		{
			$this->data['payment_method'] = 'paypal';			
		}
		else
		{
			$this->data['payment_method'] = 'card';			

			$country_info = $this->model_localisation_country->getCountry($this->session->data['billing_address']['country']); 
			$zone_info = $this->model_localisation_zone->getZone($this->session->data['billing_address']['zone']); 
	
			$this->data['billing_firstname'] =$this->session->data['billing_address']['firstname'];
			$this->data['billing_lastname'] = $this->session->data['billing_address']['lastname'];	
			$this->data['billing_address_1'] = $this->session->data['billing_address']['address_1'];
			$this->data['billing_address_2'] = $this->session->data['billing_address']['address_2'];
			$this->data['billing_city'] = $this->session->data['billing_address']['city'];
			$this->data['billing_postcode'] = $this->session->data['billing_address']['postcode'];
			$this->data['billing_zone'] = $zone_info['name'];
			$this->data['billing_country'] = $country_info['name'];
		}


		/*-- Total data ????--*/
		
		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		$this->load->model('setting/extension');

		$sort_order = array(); 

		$results = $this->model_setting_extension->getExtensions('total');

		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}

		array_multisort($sort_order, SORT_ASC, $results);

		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);

				$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
			}
		}
		
/*		$total_data[] = array( 
			'code'       => 'shipping',
			'title'      => 'Flatrate Shipping',
			'text'       => $this->currency->format($this->session->data['shipping_price']),
			'value'      => $this->session->data['shipping_price'],
			'sort_order' => 3
		);*/
		
		//$total += $this->session->data['shipping_price'];

		$sort_order = array(); 

		foreach ($total_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $total_data);



		/*-------------------------Order data----------------------------------*/	
		
		$data = array();

		$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
		$data['store_id'] = $this->config->get('config_store_id');
		$data['store_name'] = $this->config->get('config_name');

		if ($data['store_id']) {
			$data['store_url'] = $this->config->get('config_url');		
		} else {
			$data['store_url'] = HTTP_SERVER;	
		}

		/*--User data --*/
		$data['customer_id'] = $this->customer->getId();
		$data['customer_group_id'] = $this->customer->getCustomerGroupId();
		$data['firstname'] = $this->customer->getFirstName();
		$data['lastname'] = $this->customer->getLastName();
		$data['email'] = $this->customer->getEmail();
		$data['telephone'] = $this->customer->getTelephone();
		$data['fax'] = $this->customer->getFax();


		/*-- Shipping data --*/

		$data['shipping_firstname'] = $shipping_address['firstname'];
		$data['shipping_lastname'] = $shipping_address['lastname'];	
		$data['shipping_company'] = "";	
		$data['shipping_address_1'] = $shipping_address['address_1'];
		$data['shipping_address_2'] = $shipping_address['address_2'];
		$data['shipping_city'] = $shipping_address['city'];
		$data['shipping_postcode'] = $shipping_address['postcode'];
		$data['shipping_zone'] = $shipping_zone_name['name'];
		$data['shipping_zone_id'] = $shipping_address['zone_id'];
		$data['shipping_country'] = $shipping_country_name['name'];
		$data['shipping_country_id'] = $shipping_address['country_id'];
		$data['shipping_address_format'] = "";

		if (isset($this->session->data['shipping_price'])) {
			$data['shipping_method'] = 'Fltarate shipping';
			$data['shipping_code'] = 'flatrate.flatrate';
		} else {
			$data['shipping_method'] = '';
			$data['shipping_code'] = '';
		}

		/*-- Payment data --*/


		
		if(isset( $this->session->data['billing_address']))
		{
			$this->load->model('localisation/country');
			$country_info = $this->model_localisation_country->getCountry($this->session->data['billing_address']['country']); 
			
			$this->load->model('localisation/zone');
			$zone_info = $this->model_localisation_zone->getZone($this->session->data['billing_address']['zone']); 

			$data['payment_firstname'] = $this->session->data['billing_address']['firstname'];
			$data['payment_lastname'] = $this->session->data['billing_address']['lastname'];	
			$data['payment_company'] = "";
			$data['payment_company_id'] = "";
			$data['payment_tax_id'] = "";
			$data['payment_address_1'] = $this->session->data['billing_address']['address_1'];
			$data['payment_address_2'] = $this->session->data['billing_address']['address_2'];
			$data['payment_city'] = $this->session->data['billing_address']['city'];
			$data['payment_postcode'] = $this->session->data['billing_address']['postcode'];
			$data['payment_zone'] = $zone_info['name'];
			$data['payment_zone_id'] = $this->session->data['billing_address']['zone'];
			$data['payment_country'] = $country_info['name'];
			$data['payment_country_id'] = $this->session->data['billing_address']['country'];
			$data['payment_address_format'] = "";
		}
		else
		{
			$data['payment_firstname'] = "";
			$data['payment_lastname'] = "";	
			$data['payment_company'] = "";
			$data['payment_company_id'] = "";
			$data['payment_tax_id'] = "";
			$data['payment_address_1'] = "";
			$data['payment_address_2'] = "";
			$data['payment_city'] = "";
			$data['payment_postcode'] = "";
			$data['payment_zone'] = "";
			$data['payment_zone_id'] = "";
			$data['payment_country'] = "";
			$data['payment_country_id'] = "";
			$data['payment_address_format'] = "";
			
		}
		
		if (isset($this->session->data['payment_method']['title'])) {
			$data['payment_method'] = $this->session->data['payment_method']['title'];
		} else {
			$data['payment_method'] = '';
		}

		if (isset($this->session->data['payment_method']['code'])) {
			$data['payment_code'] = $this->session->data['payment_method']['code'];
		} else {
			$data['payment_code'] = '';
		}


		/*-- Product data --*/

		$product_data = array();

		foreach ($this->cart->getProducts() as $product) 
		{
			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['option_value'];	
				} else {
					$value = $this->encryption->decrypt($option['option_value']);
				}	

				$option_data[] = array(
					'product_option_id'       => $option['product_option_id'],
					'product_option_value_id' => $option['product_option_value_id'],
					'option_id'               => $option['option_id'],
					'option_value_id'         => $option['option_value_id'],								   
					'name'                    => $option['name'],
					'value'                   => $value,
					'type'                    => $option['type']
				);					
			}

			$product_data[] = array(
				'product_id' => $product['product_id'],
				'name'       => $product['name'],
				'model'      => $product['model'],
				'option'     => $option_data,
				'download'   => $product['download'],
				'quantity'   => $product['quantity'],
				'subtract'   => $product['subtract'],
				'price'      => $product['price'],
				'total'      => $product['total'],
				'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
				'reward'     => $product['reward']
			); 
		}

		$voucher_data = array();

		$data['products'] = $product_data;
		$data['vouchers'] = $voucher_data;
		$data['totals'] = $total_data;
		$data['comment'] = "";
		$data['total'] = $total;

		if (isset($this->request->cookie['tracking'])) {
			$this->load->model('affiliate/affiliate');

			$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);
			$subtotal = $this->cart->getSubTotal();

			if ($affiliate_info) {
				$data['affiliate_id'] = $affiliate_info['affiliate_id']; 
				$data['commission'] = ($subtotal / 100) * $affiliate_info['commission']; 
			} else {
				$data['affiliate_id'] = 0;
				$data['commission'] = 0;
			}
		} else {
			$data['affiliate_id'] = 0;
			$data['commission'] = 0;
		}

		$data['language_id'] = $this->config->get('config_language_id');
		$data['currency_id'] = $this->currency->getId();
		$data['currency_code'] = $this->currency->getCode();
		$data['currency_value'] = $this->currency->getValue($this->currency->getCode());
		$data['ip'] = $this->request->server['REMOTE_ADDR'];

		if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
			$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];	
		} elseif(!empty($this->request->server['HTTP_CLIENT_IP'])) {
			$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];	
		} else {
			$data['forwarded_ip'] = '';
		}

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];	
		} else {
			$data['user_agent'] = '';
		}

		if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
			$data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];	
		} else {
			$data['accept_language'] = '';
		}	



		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->request->post['action'] == "process_checkout")
		{
			
			if(isset($this->session->data['card_info']['payment_method_nonce']))
			{		
			$this->load->model('account/order');
			//print_r($this->session->data['order_id']);
			//print_r($this->model_account_order->getOrder($this->session->data['order_id']));

				require_once('./braintree/Braintree.php');

				
				if($this->config->get('braintree_test'))
				{
					Braintree_Configuration::environment('sandbox');
				}
				else
				{
					Braintree_Configuration::environment('production');	
				}
				
				Braintree_Configuration::merchantId($this->config->get('braintree_merchantid'));
				Braintree_Configuration::publicKey($this->config->get('braintree_publickey'));
				Braintree_Configuration::privateKey($this->config->get('braintree_privatekey'));
				$result = Braintree_Transaction::sale(array(				
				  'amount' => $total_cart_price + $shipping_price,
				  'paymentMethodNonce' => $this->session->data['card_info']['payment_method_nonce'],
				  'orderId' => $this->session->data['order_id'],
				));				
				
				if ($result->success) 
				{
					$this->redirect($this->url->link('checkout/success', '', 'SSL'));
				} 
				else 
				{
					foreach($result->errors->deepAll() AS $error) 
					{
						$this->data['payment_error'] = true;		
						//echo($error->code . ": " . $error->message . "\n");
					}
				}
			}	
		}
		else
		{
			$this->load->model('checkout/order');
			$this->session->data['order_id'] = $this->model_checkout_order->addOrder($data);			
		}



						
		/*-- Save order --*/				
		

		if($this->session->data['payment_method'] == 'paypal')
		{
			//$this->data['payment_paypal_form'] = $this->getChild('payment/pp_standard');	
			$this->data['payment_paypal_form'] = $this->getChild('payment/pp_express');			
		}
		elseif($this->session->data['payment_method'] == 'card')
		{
			
		}	
		
		
		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout_review.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout_review.tpl';
		} else {
			$this->template = 'default/template/checkout/checkout_review.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);

		$this->response->setOutput($this->render());	
	}

	public function updateOrder()
	{
		$json = array();
		$this->load->model('checkout/order');

		$this->model_checkout_order->updateComment($this->session->data['order_id'], $this->request->post['comment']);	
		$json['success'] = 'Success!';
		
		$this->response->setOutput(json_encode($json));
	}
	
}