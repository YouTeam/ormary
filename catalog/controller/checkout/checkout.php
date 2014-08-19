<?php  
class ControllerCheckoutCheckout extends Controller { 
	public function index() {
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			//$this->redirect($this->url->link('checkout/cart'));
		}

		// Validate minimum quantity requirments.			
		$products = $this->cart->getProducts();

		$this->data['products_total_price'] = 0;

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}		

			if ($product['minimum'] > $product_total) {
			//	$this->redirect($this->url->link('checkout/cart'));
			}	
			
			$this->data['products_total_price'] += $product['price']*	$product['quantity'];	
		}

		


		$this->language->load('checkout/checkout');

		$this->document->setTitle($this->language->get('heading_title')); 
		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addScript('catalog/view/javascript/jquery/jquery-1.7.1.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_cart'),
			'href'      => $this->url->link('checkout/cart'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);
		
		/*$this->data['shipping_firstname'] = $this->customer->getFirstName();
		$this->data['shipping_firstname'] = $this->customer->getLastName();
		*/
		$this->load->model('account/address');
		
		
		$addr_res = $this->model_account_address->getAddresses();

/*		foreach ($addr_res as $res) {
			$this->data['shipping_firstname'] = $res['firstname'];
			$this->data['shipping_lastname'] = $res['lastname'];
			$this->data['shipping_country'] = $res['country'];
			$this->data['shipping_region'] = $res['zone'];
			$this->data['shipping_postcode'] = $res['postcode'];
			$this->data['shipping_city'] = $res['city'];
			$this->data['shipping_address_1'] = $res['address_1'];
			$this->data['shipping_address_2'] = $res['address_2'];
		}

		$this->data['shipping_email'] = $this->customer->getEmail();
		$this->data['shipping_tel'] = $this->customer->getTelephone();*/
		//print_r($this->session->data['customer_address']);
		
		//print_r($this->session->data['customer_address']);
		
		if(isset($this->session->data['customer_address']))
		{
			$this->data['shipping_firstname'] = $this->session->data['customer_address']['firstname'];
			$this->data['shipping_lastname'] = $this->session->data['customer_address']['lastname'];
			$this->data['shipping_country'] = $this->model_account_address->getCountryName($this->session->data['customer_address']['country']);
			$this->data['shipping_region'] = $this->model_account_address->getZoneName($this->session->data['customer_address']['zone']);
			$this->data['shipping_postcode'] = $this->session->data['customer_address']['postcode'];
			$this->data['shipping_city'] = $this->session->data['customer_address']['city'];
			$this->data['shipping_address_1'] = $this->session->data['customer_address']['address_1'];
			$this->data['shipping_address_2'] = $this->session->data['customer_address']['address_2'];
			$this->data['shipping_email'] = $this->session->data['customer_address']['email'];
			$this->data['shipping_tel'] = $this->session->data['customer_address']['phone'];
		}		
/*		elseif ($this->customer->isLogged()) 
		{
			$this->load->model('account/address');
			$addr_res = $this->model_account_address->getAddresses();
			foreach ($addr_res as $res) {
				$this->data['shipping_firstname'] = $res['firstname'];
				$this->data['shipping_lastname'] = $res['lastname'];
				$$this->data['shipping_country'] = $res['country'];
				$this->data['shipping_region'] = $res['zone'];
				$this->data['shipping_postcode'] = $res['postcode'];
				$this->data['shipping_city'] = $res['city'];
				$this->data['shipping_address_1'] = $res['address_1'];
				$this->data['shipping_address_1'] = $res['address_2'];
			}

			$this->data['shipping_email'] = $this->customer->getEmail();
			$this->data['shipping_tel'] = $this->customer->getTelephone();
		}*/
		else
		{
			$this->data['address'] = array('firstname'=> "", 'lastname' =>"", 'country' => "", 'zone' => "", 'postcode' => "", 'city' => "", 'address_1' => "", 'address_2' => "", 'email' => "", 'phone' => "");	
			$this->session->data['customer_address'] = array('firstname'=> "", 'lastname' =>"", 'country' => "", 'zone' => "", 'postcode' => "", 'city' => "", 'address_1' => "", 'address_2' => "", 'email' => "", 'phone' => "");
		}
		
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$this->load->model('localisation/country');
		$this->data['countries'] = $this->model_localisation_country->getCountries();
		$this->data['text_select'] = "--- Please Select ---";
		$this->data['text_none'] = "";
		
		if($this->customer->isLogged())
		{
			$this->data['logged_in'] = true;		
		}
		else
		{
			$this->data['logged_in'] = false;	
		}

		
		$error = false;
		if($error)
		{
			$this->data['error_in_address'] = true;		
		}
		else
		{
			$eu_countries = array(14, 21, 33, 84, 57, 67, 103, 67, 105, 55, 117, 123, 124, 132, 150, 81, 170, 171, 175, 189, 190, 97, 72, 74, 53, 56, 203);
			
			$this->data['error_in_address'] = false;
			if($this->session->data['customer_address']['country'] == 222)
			{
				if($this->data['products_total_price'] >= 125)
				{
					$this->data['shipping_price'] = 0;
				}
				else
				{
					$this->data['shipping_price'] = 5;
				}
			}
			elseif($this->session->data['customer_address']['country'] == 223)
			{
				$this->data['shipping_price'] = 20;	
			}
			elseif(in_array($this->session->data['customer_address']['country'], $eu_countries))
			{
				$this->data['shipping_price'] = 10;	
			}
			else
			{
				$this->data['shipping_price'] = 30;	
			}				
		}
		
		$this->session->data['shipping_price'] = $this->data['shipping_price'] ;
		
		
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
			
			$total_data[] = array( 
				'code'       => 'shipping',
				'title'      => 'Shipping',
				'text'       => $this->currency->format($this->data['shipping_price']),
				'value'      => $this->data['shipping_price'],
				'sort_order' => 3
			);

			$total += $this->data['shipping_price'];

			$sort_order = array(); 

			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $total_data);

			$this->language->load('checkout/checkout');

			$data = array();

			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');

			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');		
			} else {
				$data['store_url'] = HTTP_SERVER;	
			}

			if ($this->customer->isLogged()) {
				$data['customer_id'] = $this->customer->getId();
				$data['customer_group_id'] = $this->customer->getCustomerGroupId();
				$data['firstname'] = $this->customer->getFirstName();
				$data['lastname'] = $this->customer->getLastName();
				$data['email'] = $this->customer->getEmail();
				$data['telephone'] = $this->customer->getTelephone();
				$data['fax'] = $this->customer->getFax();

				$this->load->model('account/address');

				$payment_address = $this->session->data['customer_address'];
			//} elseif (isset($this->session->data['guest'])) {
			  } elseif (isset($this->session->data['customer_address'])) {	
				$data['customer_id'] = 0;
				$data['customer_group_id'] = "";//$this->session->data['customer_address']['customer_group_id'];
				$data['firstname'] = $this->session->data['customer_address']['firstname'];
				$data['lastname'] = $this->session->data['customer_address']['lastname'];
				$data['email'] = $this->session->data['customer_address']['email'];
				$data['telephone'] = $this->session->data['customer_address']['phone'];
				$data['fax'] = "";//$this->session->data['customer_address']['fax'];

				$payment_address = $this->session->data['customer_address'];
			}
			
			$this->load->model('localisation/country');
		    $country_info = $this->model_localisation_country->getCountry($payment_address['country']); 
			
			$this->load->model('localisation/zone');
			$zone_info = $this->model_localisation_zone->getZone($payment_address['zone']); 

			$data['payment_firstname'] = $payment_address['firstname'];
			$data['payment_lastname'] = $payment_address['lastname'];	
			$data['payment_company'] = "";//$payment_address['company'];	
			$data['payment_company_id'] = "";//$payment_address['company_id'];	
			$data['payment_tax_id'] = "";//$payment_address['tax_id'];	
			$data['payment_address_1'] = $payment_address['address_1'];
			$data['payment_address_2'] = $payment_address['address_2'];
			$data['payment_city'] = $payment_address['city'];
			$data['payment_postcode'] = $payment_address['postcode'];
			$data['payment_zone'] = $zone_info['name'];
			$data['payment_zone_id'] = $payment_address['zone'];
			$data['payment_country'] = $country_info['name'];
			$data['payment_country_id'] = $payment_address['country'];
			$data['payment_address_format'] = "";//$payment_address['address_format'];

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

			if ($this->cart->hasShipping()) {
				if ($this->customer->isLogged()) {
					$this->load->model('account/address');

					//$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
					$shipping_address = $this->session->data['customer_address'];
						
				} elseif (isset($this->session->data['customer_address'])) {
					$shipping_address = $this->session->data['customer_address'];
				}			

//print_r($this->session->data['customer_address']);
/*		$this->data['shipping_firstname'] = $this->session->data['customer_address']['firstname'];
		$this->data['shipping_lastname'] = $this->session->data['customer_address']['lastname'];
		$this->data['shipping_country'] = $this->model_account_address->getCountryName($this->session->data['customer_address']['country']);
		$this->data['shipping_region'] = $this->model_account_address->getZoneName($this->session->data['customer_address']['zone']);
		$this->data['shipping_postcode'] = $this->session->data['customer_address']['postcode'];
		$this->data['shipping_city'] = $this->session->data['customer_address']['city'];
		$this->data['shipping_address_1'] = $this->session->data['customer_address']['address_1'];
		$this->data['shipping_address_2'] = $this->session->data['customer_address']['address_2'];
		$this->data['shipping_email'] = $this->session->data['customer_address']['email'];
		$this->data['shipping_tel'] = $this->session->data['customer_address']['phone'];
*/


				$data['shipping_firstname'] = $shipping_address['firstname'];
				$data['shipping_lastname'] = $shipping_address['lastname'];	
				$data['shipping_company'] = "";//$shipping_address['company'];	
				$data['shipping_address_1'] = $shipping_address['address_1'];
				$data['shipping_address_2'] = $shipping_address['address_2'];
				$data['shipping_city'] = $shipping_address['city'];
				$data['shipping_postcode'] = $shipping_address['postcode'];
				$data['shipping_zone'] = $shipping_address['zone'];
				$data['shipping_zone_id'] = $shipping_address['zone'];
				$data['shipping_country'] = $shipping_address['country'];
				$data['shipping_country_id'] = $shipping_address['country'];
				$data['shipping_address_format'] = "";//$shipping_address['address_format'];

				if (isset($this->session->data['shipping_method']['title'])) {
					$data['shipping_method'] = $this->session->data['shipping_method']['title'];
				} else {
					$data['shipping_method'] = '';
				}

				if (isset($this->session->data['shipping_method']['code'])) {
					$data['shipping_code'] = $this->session->data['shipping_method']['code'];
				} else {
					$data['shipping_code'] = '';
				}				
			} else {
				$data['shipping_firstname'] = '';
				$data['shipping_lastname'] = '';	
				$data['shipping_company'] = '';	
				$data['shipping_address_1'] = '';
				$data['shipping_address_2'] = '';
				$data['shipping_city'] = '';
				$data['shipping_postcode'] = '';
				$data['shipping_zone'] = '';
				$data['shipping_zone_id'] = '';
				$data['shipping_country'] = '';
				$data['shipping_country_id'] = '';
				$data['shipping_address_format'] = '';
				$data['shipping_method'] = '';
				$data['shipping_code'] = '';
			}

			$product_data = array();

			foreach ($this->cart->getProducts() as $product) {
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
			
			

			// Gift Voucher
			$voucher_data = array();
/*
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$voucher_data[] = array(
						'description'      => $voucher['description'],
						'code'             => substr(md5(mt_rand()), 0, 10),
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],						
						'amount'           => $voucher['amount']
					);
				}
			}  */

			$data['products'] = $product_data;
			$data['vouchers'] = $voucher_data;
			$data['totals'] = $total_data;
			$data['comment'] = "";//$this->session->data['comment'];
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

			$this->load->model('checkout/order');

			$this->session->data['order_id'] = $this->model_checkout_order->addOrder($data);
		
		
		
		
		$this->data['payment'] = $this->getChild('payment/pp_standard');
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$this->data['total_price'] = $this->currency->format($this->data['products_total_price'] + $this->data['shipping_price']);

		$this->data['shipping_price'] = $this->currency->format($this->data['shipping_price']);
		
		$this->data['products_total_price'] = $this->currency->format($this->data['products_total_price']);
		
		
		
		
			// Payment Methods
	/*		$method_data = array();
	
			$this->load->model('setting/extension');

			$results = $this->model_setting_extension->getExtensions('payment');

			$cart_has_recurring = $this->cart->hasRecurringProducts();

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('payment/' . $result['code']);

					$method = $this->{'model_payment_' . $result['code']}->getMethod($payment_address, $total);

					if ($method) {
						if($cart_has_recurring > 0){
							if (method_exists($this->{'model_payment_' . $result['code']},'recurringPayments')) {
								if($this->{'model_payment_' . $result['code']}->recurringPayments() == true){
									$method_data[$result['code']] = $method;
								}
							}
						} else {
							$method_data[$result['code']] = $method;
						}
					}
				}
			}

			$sort_order = array(); 

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);			

			$this->session->data['payment_methods'] = $method_data;	
		
		
		if (isset($this->session->data['payment_methods'])) {
			$this->data['payment_methods'] = $this->session->data['payment_methods']; 
		} else {
			$this->data['payment_methods'] = array();
		}*/
		
		
		
		
		
		
		

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_checkout_option'] = $this->language->get('text_checkout_option');
		$this->data['text_checkout_account'] = $this->language->get('text_checkout_account');
		$this->data['text_checkout_payment_address'] = $this->language->get('text_checkout_payment_address');
		$this->data['text_checkout_shipping_address'] = $this->language->get('text_checkout_shipping_address');
		$this->data['text_checkout_shipping_method'] = $this->language->get('text_checkout_shipping_method');
		$this->data['text_checkout_payment_method'] = $this->language->get('text_checkout_payment_method');		
		$this->data['text_checkout_confirm'] = $this->language->get('text_checkout_confirm');
		$this->data['text_modify'] = $this->language->get('text_modify');

		$this->data['logged'] = $this->customer->isLogged();
		$this->data['shipping_required'] = $this->cart->hasShipping();	

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout.tpl';
		} else {
			$this->template = 'default/template/checkout/checkout.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);

		if (isset($this->request->get['quickconfirm'])) {
			$this->data['quickconfirm'] = $this->request->get['quickconfirm'];
		}

		$this->response->setOutput($this->render());
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}

		$this->response->setOutput(json_encode($json));
	}
	
	
	public function saveAddressAjax()
	{
		$json = array('errors' => array());
		if(isset($this->request->post['firstname']))
		{
			$this->session->data['customer_address']['firstname'] = $this->request->post['firstname'];
		}
		else
		{
			$json['errors']['firstname'] = "Please enter firstname"; 
			$this->session->data['customer_address']['firstname'] = "";	
		}
		
		if(isset($this->request->post['lastname']))
		{
			$this->session->data['customer_address']['lastname'] = $this->request->post['lastname'];
		}
		else
		{
			$json['errors']['lastname'] = "Please enter lastname";
			$this->session->data['customer_address']['lastname'] = "";	
		}		
		
		if(isset($this->request->post['country_id']))
		{
			$this->session->data['customer_address']['country'] = $this->request->post['country_id'];
		}
		else
		{
			$json['errors']['country'] = "Please choose your country";
			$this->session->data['customer_address']['country'] = "";	
		}

		if(isset($this->request->post['zone_id']))
		{
			$this->session->data['customer_address']['zone'] = $this->request->post['zone_id'];
		}
		else
		{
			$this->session->data['customer_address']['zone'] = "";	
		}

		if(isset($this->request->post['postcode']))
		{
			$this->session->data['customer_address']['postcode'] = $this->request->post['postcode'];
		}
		else
		{
			$json['errors']['postcode'] = "Please enter postcode";
			$this->session->data['customer_address']['postcode'] = "";	
		}

		if(isset($this->request->post['city']))
		{
			$this->session->data['customer_address']['city'] = $this->request->post['city'];
		}
		else
		{
			$json['errors']['city'] = "Please enter city";
			$this->session->data['customer_address']['city'] = "";	
		}
		
		if(isset($this->request->post['address_1']))
		{
			$this->session->data['customer_address']['address_1'] = $this->request->post['address_1'];
		}
		else
		{
			$json['errors']['address_1'] = "Please enter address";
			$this->session->data['customer_address']['address_1'] = "";	
		}

		if(isset($this->request->post['address_2']))
		{
			$this->session->data['customer_address']['address_2'] = $this->request->post['address_2'];
		}
		else
		{
			$this->session->data['customer_address']['address_2'] = "";	
		}

		if(isset($this->request->post['email']))
		{
			$this->session->data['customer_address']['email'] = $this->request->post['email'];
		}
		else
		{
			$json['errors']['email'] = "Please enter email";
			$this->session->data['customer_address']['email'] = "";	
		}
		
		if(isset($this->request->post['phone']))
		{
			$this->session->data['customer_address']['phone'] = $this->request->post['phone'];
		}
		else
		{
			$json['errors']['phone'] = "Please enter phone";
			$this->session->data['customer_address']['phone'] = "";	
		}
		
		$this->response->setOutput(json_encode($json));
	}	
}
?>