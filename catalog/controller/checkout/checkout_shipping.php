<?php  
class ControllerCheckoutCheckoutShipping extends Controller { 
	private $error = array();

	public function index() {
		if (!$this->cart->hasProducts()) 
		{
			$this->redirect($this->url->link('common/home'));
		}
		elseif(!$this->customer->isLogged() && !isset($this->session->data['new_user_email'])) 
		{
			$this->redirect($this->url->link('checkout/checkout_login', '', 'SSL'));
		}
	
		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate())
		{
			$this->load->model('account/address');

			if(!$this->customer->isLogged())
			{
				$this->load->model('account/customer');
				$this->request->post['fax'] = "";
				$this->request->post['biography'] = "";
				$this->request->post['company_id'] = "";
				$this->request->post['tax_id'] = "";
					
				$this->model_account_customer->addCustomer($this->request->post);

				$this->customer->login($this->request->post['email'], $this->request->post['password']);
				
				$manufacturers = array();
				$products = $this->cart->getProducts();				
				
				$this->load->model('catalog/product');

				foreach($products as $product)
				{
					$manufacturer_id = $this->model_catalog_product->getManufacturerId($product['product_id']);

					if($manufacturer_id)
					{
						$manufacturers[] = $manufacturer_id ;
					}
				}
				
				$this->load->model('account/follow');

				$this->model_account_follow->saveUserFollows($manufacturers);
				
				unset($this->session->data['guest']);
				
				
				$address_id = $this->customer->getAddressId();
				
				$shipping_address =  $this->model_account_address->getAddress($address_id);
	
				$this->data['products_total_price'] = $this->cart->getTotal();
				
				$eu_countries = array(14, 21, 33, 84, 57, 67, 103, 67, 105, 55, 117, 123, 124, 132, 150, 81, 170, 171, 175, 189, 190, 97, 72, 74, 53, 56, 203);

				if($shipping_address['country_id'] == 222)
				{
					//GB
					if($this->data['products_total_price'] >= 125)
					{
						$this->data['shipping_price'] = 0;
					}
					else
					{
						$this->data['shipping_price'] = 5;
					}
				}
				elseif($shipping_address['country_id'] == 223 || $shipping_address['country_id'] == 38)
				{
					//USA and Canada
					$this->data['shipping_price'] = 20;	
				}
				elseif(in_array($shipping_address['country_id'], $eu_countries))
				{
					//EU
					$this->data['shipping_price'] = 10;	
				}
				else
				{
					//World
					$this->data['shipping_price'] = 30;	
				}				
				
				$this->session->data['shipping_price'] = $this->data['shipping_price'] ;
				
				$this->session->data['shipping_address_id'] = $address_id ;
				
				
				$this->redirect($this->url->link('checkout/checkout_payment', '', 'SSL'));
			}
			else
			{				
				if($this->request->post['type'] == "select_address")
				{
					if(isset($this->request->post['address_id']))
					{												
						$shipping_address =  $this->model_account_address->getAddress($this->request->post['address_id']);
						
						
						$this->data['products_total_price'] = $this->cart->getTotal();
						
						$eu_countries = array(14, 21, 33, 84, 57, 67, 103, 67, 105, 55, 117, 123, 124, 132, 150, 81, 170, 171, 175, 189, 190, 97, 72, 74, 53, 56, 203);

						if($shipping_address['country_id'] == 222)
						{
							//GB
							if($this->data['products_total_price'] >= 125)
							{
								$this->data['shipping_price'] = 0;
							}
							else
							{
								$this->data['shipping_price'] = 5;
							}
						}
						elseif($shipping_address['country_id'] == 223 || $shipping_address['country_id'] == 38)
						{
							//USA and Canada
							$this->data['shipping_price'] = 20;	
						}
						elseif(in_array($shipping_address['country_id'], $eu_countries))
						{
							//EU
							$this->data['shipping_price'] = 10;	
						}
						else
						{
							//World
							$this->data['shipping_price'] = 30;	
						}				
						
						$this->session->data['shipping_price'] = $this->data['shipping_price'] ;
						
						$this->session->data['shipping_address_id'] = $this->request->post['address_id'] ;

						$this->redirect($this->url->link('checkout/checkout_payment', '', 'SSL'));
					}
				}
				else
				{							
					$this->model_account_address->editAddress($this->customer->getAddressId(), $this->request->post);	
				}	
			}
		}
		else
		{
					
		}
		
		
		$this->language->load('checkout/custom_checkout');
		
		$this->document->setTitle($this->language->get('checkout_shipping_title'));
		
		$this->data['text_select'] = $this->language->get('text_select');
		
		if(isset($this->session->data['new_user_email']))
		{
			$this->data['new_user_email'] = $this->data['customer_email'] = $this->session->data['new_user_email'];			
		}
		else
		{
			if($this->customer->isLogged())
			{
				$this->data['customer_email'] = $this->customer->getEmail();
			}
		}		

		$this->load->model('localisation/country');
		$this->data['countries'] = $this->model_localisation_country->getCountries();
		$this->data['page_url'] = $this->url->link('checkout/checkout_shipping', '', 'SSL');
		
		$this->data['update_url'] =  $this->url->link('account/address/update', '', 'SSL');
		$this->data['add_url'] =  $this->url->link('account/address/insert', '', 'SSL');
		$this->data['delete_url'] =  $this->url->link('account/address/delete', '', 'SSL');
		
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}	

		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}		

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		}

		if (isset($this->error['address_1'])) {
			$this->data['error_address_1'] = $this->error['address_1'];
		} else {
			$this->data['error_address_1'] = '';
		}
		
		if (isset($this->error['address_2'])) {
			$this->data['error_address_2'] = $this->error['address_2'];
		} else {
			$this->data['error_address_2'] = '';
		}
		
		if (isset($this->error['city'])) {
			$this->data['error_city'] = $this->error['city'];
		} else {
			$this->data['error_city'] = '';
		}

		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$this->data['error_country'] = $this->error['country'];
		} else {
			$this->data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$this->data['error_zone'] = $this->error['zone'];
		} else {
			$this->data['error_zone'] = '';
		}
		
		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}
		
		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}
		
		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		}

		$this->data['action'] = $this->url->link('account/register', '', 'SSL');

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$this->data['country_id'] = $this->request->post['country_id'];
		} else {
			$this->data['country_id'] = '';
		}
		
		if (isset($this->request->post['zone_id'])) {
			$this->data['zone_id'] = $this->request->post['zone_id'];
		} else {
			$this->data['zone_id'] = '';
		}

		if (isset($this->request->post['city'])) {
			$this->data['city'] = $this->request->post['city'];
		} else {
			$this->data['city'] = '';
		}
		
		if (isset($this->request->post['address_1'])) {
			$this->data['address_1'] = $this->request->post['address_1'];
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$this->data['address_2'] = $this->request->post['address_2'];
		} else {
			$this->data['address_2'] = '';
		}
		
		if (isset($this->request->post['postcode'])) {
			$this->data['postcode'] = $this->request->post['postcode'];
		} else {
			$this->data['postcode'] = '';
		}
		
		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} else {
			$this->data['telephone'] = '';
		}
		
		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}
		
		if (isset($this->request->post['confirm'])) {
			$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}
		$this->data['looged_in'] = false;
		
		if($this->customer->isLogged()) 
		{
			
			
			
			$this->load->model('account/address');
			$addresses = $this->model_account_address->getAddresses();

			$this->data['registered'] = true;
						
			if(isset($this->session->data['shipping_address_id']))
			{
				$this->data['selected_address']	= $this->session->data['shipping_address_id'];
			}
			else
			{
				$first_address = current($addresses);
				$this->data['selected_address']	= $first_address['address_id'];
			}
			
			$this->data['looged_in'] = true;	
					
			if(count($addresses) <= 1)
			{
				
				$this->data['addresses'] = $addresses;
				$first_address = current($this->data['addresses']);
				 
				if($this->validate($first_address))
				{					
					$this->data['list_addresses'] = true;
				}
				else
				{
					$this->data['list_addresses'] = false;							
					if(!$this->request->server['REQUEST_METHOD'] == 'POST')
					{
						$this->data['firstname'] = $first_address['firstname'];
						$this->data['lastname'] = $first_address['lastname'];
						$this->data['country_id'] = $first_address['country_id'];
						$this->data['zone_id'] = $first_address['zone_id'];	
						$this->data['city'] = $first_address['city'];
						$this->data['address_1'] = $first_address['address_1'];
						$this->data['address_2'] = $first_address['address_2'];
						$this->data['postcode'] = $first_address['postcode'];				
					}
				}					
			}
			else
			{
				$this->data['list_addresses'] = true;
				$this->data['addresses'] = $addresses;
			}
			
		}
		else
		{
			if($this->request->server['REQUEST_METHOD'] == 'POST')
			{
				$this->data['registered'] = false;
				$this->data['list_addresses'] = false; 
			}
			else
			{
				$this->data['registered'] = false;
				$this->data['list_addresses'] = false; 
			}

		}
	
	
	
	
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout_shipping.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout_shipping.tpl';
		} else {
			$this->template = 'default/template/checkout/checkout_shipping.tpl';
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
	
	
	protected function validate($address = array())
	{	
		$this->load->model('account/customer');
		$this->language->load('account/register');
		
		
		if(isset($this->request->post['type']) && $this->request->post['type'] == "select_address")
		{
			return true;	
		}
		
		if(count($address) != 0)
		{
			$this->request->post = 	$address;	
		}
		
			
		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if (utf8_strlen($this->request->post['address_2']) > 128) {
			$this->error['address_2'] = $this->language->get('error_address_1');
		}

		if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

		if ($country_info) {
			if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
				$this->error['postcode'] = $this->language->get('error_postcode');
			}

			// VAT Validation
			$this->load->helper('vat');

			if ($this->config->get('config_vat') && $this->request->post['tax_id'] && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
				$this->error['tax_id'] = $this->language->get('error_vat');
			}
		}

		if ($this->request->post['country_id'] == '') {
			$this->error['country'] = $this->language->get('error_country');
		}

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
			$this->error['zone'] = $this->language->get('error_zone');
		}

		if(!$this->customer->isLogged())
		{
			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
				$this->error['email'] = $this->language->get('error_email');
			}
	
			if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
			
			if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
				$this->error['telephone'] = $this->language->get('error_telephone');
			}
	
			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$this->error['password'] = $this->language->get('error_password');
			}
	
			if ($this->request->post['confirm'] != $this->request->post['password']) {
				$this->error['confirm'] = $this->language->get('error_confirm');
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
}