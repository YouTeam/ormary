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
				$this->request->post['telephone'] = "";
				$this->request->post['fax'] = "";
				$this->request->post['biography'] = "";
				$this->request->post['company_id'] = "";
				$this->request->post['tax_id'] = "";
					
				$this->model_account_customer->addCustomer($this->request->post);

				$this->customer->login($this->request->post['email'], $this->request->post['password']);
				
				$manufacturers = array();
				$products = $this->cart->getProducts();				
				
				$this->load->model('catalog/product');
				//print_r($products);
				foreach($products as $product)
				{
					$manufacturer_id = $this->model_catalog_product->getManufacturerId($product['product_id']);
					//print_r("--".$manufacturer_id."--");
					if($manufacturer_id)
					{
						$manufacturers[] = $manufacturer_id ;
					}
				}
				
				$this->load->model('account/follow');
				//print_r($manufacturers);
				$this->model_account_follow->saveUserFollows($manufacturers);
				
				unset($this->session->data['guest']);
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
						//print_r($shipping_address['country_id']);
						$this->redirect($this->url->link('checkout/checkout_payment', '', 'SSL'));
					}
				}
				else
				{
					$this->model_account_address->editAddress($this->request->get['address_id'], $this->request->post);	
				}	
			}
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
						
			if(count($addresses) <= 1)
			{
				$this->data['list_addresses'] = true;
				$this->data['addresses'] = $addresses;
				$this->data['address']['phone'] = "";
				 
				if($this->validate($this->data['address']))
				{
					
					//$this->data['next_step_link'] = $this->url->link('checkout/checkout_payment', '', 'SSL');		
				}
				else
				{
					//$this->data['next_step_link'] = $this->url->link('checkout/checkout_shipping', '', 'SSL');	
				}					
			}
			else
			{
				$this->data['list_addresses'] = true;
				$this->data['addresses'] = $addresses;
				//$this->data['next_step_link'] = $this->url->link('checkout/checkout_payment', '', 'SSL');
			}
			
		}
		else
		{
			if($this->request->server['REQUEST_METHOD'] == 'POST')
			{
				$this->data['registered'] = false;
				$this->data['list_addresses'] = false; 
				
				/*$this->data['address']['firstname'] = $this->request->post['firstname'];
				$this->data['address']['lastname'] = $this->request->post['lastname'];
				$this->data['address']['country'] = $this->request->post['country'];
				$this->data['address']['region'] = $this->request->post['region'];	
				$this->data['address']['city'] = $this->request->post['city'];
				$this->data['address']['address_1'] = $this->request->post['address_1'];
				$this->data['address']['address_2'] = $this->request->post['address_2'];
				$this->data['address']['postcode'] = $this->request->post['postcode'];				
				$this->data['address']['postcode'] = $this->request->post['postcode'];*/				
			}
			else
			{
				$this->data['registered'] = false;
				$this->data['list_addresses'] = false; 
				
/*				$this->data['address']['firstname'] = "";
				$this->data['address']['lastname'] = "";
				$this->data['address']['country'] = 0;
				$this->data['address']['region'] = 0;	
				$this->data['address']['city'] = "";
				$this->data['address']['address_1'] = "";
				$this->data['address']['address_2'] = "";
				$this->data['address']['postcode'] = "";*/
			}
			
			//$this->data['next_step_link'] = $this->url->link('checkout/checkout_payment', '', 'SSL');
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
		if(isset($this->request->post['new_user']))
		{
			$this->load->model('account/customer');
			$this->language->load('account/register');
				
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
		
				if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
					$this->error['password'] = $this->language->get('error_password');
				}
		
				if ($this->request->post['confirm'] != $this->request->post['password']) {
					$this->error['confirm'] = $this->language->get('error_confirm');
				}
		
				/*if ($this->config->get('config_account_id')) {
					$this->load->model('catalog/information');
		
					$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
		
					if ($information_info && !isset($this->request->post['agree'])) {
						$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
					}
				}*/
			}

			if (!$this->error) {
				return true;
			} else {
				return false;
			}
		}
		return true;
	}
}