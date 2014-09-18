<?php  
class ControllerCheckoutCheckoutPayment extends Controller { 
	private $error = array();
	
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

		$this->data['show_card_form'] = false;


		$this->data['payment_method'] = 'card';	
		
		$this->language->load('checkout/custom_checkout');
		
		$this->document->setTitle($this->language->get('checkout_payment_title'));

		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');			
		
		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->request->post['choose_payment'] == 'paypal')
		{
			$this->session->data['payment_method'] = 'paypal';
			$this->redirect($this->url->link('checkout/checkout_review', '', 'SSL'));
		}
		elseif(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->request->post['choose_payment'] == 'card')
		{	
			if($this->request->post['action'] == "save_billing_address")
			{	
				if($this->validate_billing_address())
				{
					$this->data['show_card_form'] = true;	
					
					$this->session->data['billing_address']['firstname'] = $this->request->post['firstname'];
					$this->session->data['billing_address']['lastname'] = $this->request->post['lastname'];
					$this->session->data['billing_address']['country'] = $this->request->post['country_id'];
					$this->session->data['billing_address']['address_1'] = $this->request->post['address_1'];
					$this->session->data['billing_address']['address_2'] = $this->request->post['address_2'];
					$this->session->data['billing_address']['city'] = $this->request->post['city'];
					$this->session->data['billing_address']['zone'] = $this->request->post['zone_id'];
					$this->session->data['billing_address']['postcode'] = $this->request->post['postcode'];
					$this->session->data['billing_address']['phone'] = $this->request->post['phone'];

				}
				else
				{
					$this->data['show_billing_form'] = true;						

				}			
			}
			elseif(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->request->post['action'] == "save_card_info")
			{				
				if(isset($_POST["payment_method_nonce"]))
				{
					$this->session->data['payment_method'] = 'card';
					$this->session->data['card_info']['payment_method_nonce'] = $_POST["payment_method_nonce"];
					$this->redirect($this->url->link('checkout/checkout_review', '', 'SSL'));
				}
				else
				{					
					$this->data['show_card_form'] = true;	
				}
			}
			elseif(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->request->post['action'] == "edit_billing_address")
			{
				$this->data['show_billing_form'] = true;
			}
			else
			{
				$this->data['show_billing_form'] = true;
			}
		}		
		else
		{
			if(isset($this->session->data['payment_method']) )
			{
				if($this->session->data['payment_method'] == 'paypal')
				{
					$this->data['payment_method'] = 'paypal';
				}
			}
		
			
			if(isset($this->session->data['billing_address']))	
			{
				$this->data['show_card_form'] = true;
			}
			else
			{
				$this->data['show_billing_form'] = true;	
			}
			
		}
		
		$this->data['error_card_name'] = '';
		$this->data['error_card_number'] = '';
		$this->data['error_card_type'] = '';
		$this->data['error_card_date'] = '';
		$this->data['error_card_code'] = '';
		
		$this->data['shipping_address_id'] = $this->session->data['shipping_address_id'];
		
		if($this->data['show_card_form'] == true)
		{
			require_once('./braintree/Braintree.php');
			
			Braintree_Configuration::environment('sandbox');
			Braintree_Configuration::merchantId('4jqpkqmgcxncdxpj');
			Braintree_Configuration::publicKey('qst446ds2nrxkg6f');
			Braintree_Configuration::privateKey('ef986f8470630f70273d95a27425e560');			
    
			$this->data['clientToken'] = Braintree_ClientToken::generate();	
		}

		$this->load->model('localisation/country');
		$this->data['countries'] = $this->model_localisation_country->getCountries();
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['form_action'] = $this->url->link('checkout/checkout_payment', '', 'SSL');
		$this->data['shipping_link'] = $this->url->link('checkout/checkout_shipping', '', 'SSL');


		if(isset($this->request->post['firstname']) && !isset($this->request->post['use_shipping_address'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		}
		elseif(isset($this->session->data['billing_address']['firstname'])) {
			$this->data['firstname'] = $this->session->data['billing_address']['firstname'];
		}
		else {
			$this->data['firstname'] = 	'';
		}
		
		if(isset($this->request->post['lastname']) && !isset($this->request->post['use_shipping_address'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		}
		elseif(isset($this->session->data['billing_address']['lastname'])) {
			$this->data['lastname'] = $this->session->data['billing_address']['lastname'];
		}
		else {
			$this->data['lastname'] = 	'';
		}
		
		if(isset($this->request->post['address_1']) && !isset($this->request->post['use_shipping_address'])) {
			$this->data['address_1'] = $this->request->post['address_1'];
		}
		elseif(isset($this->session->data['billing_address']['address_1'])) {
			$this->data['address_1'] = $this->session->data['billing_address']['address_1'];
		}
		else {
			$this->data['address_1'] = 	'';
		}
		
		if(isset($this->request->post['address_2']) && !isset($this->request->post['use_shipping_address'])) {
			$this->data['address_2'] = $this->request->post['address_2'];
		}
		elseif(isset($this->session->data['billing_address']['address_2'])) {
			$this->data['address_2'] = $this->session->data['billing_address']['address_2'];
		}
		else {
			$this->data['address_2'] = 	'';
		}
		
		if(isset($this->request->post['city']) && !isset($this->request->post['use_shipping_address'])) {
			$this->data['city'] = $this->request->post['city'];
		}
		elseif(isset($this->session->data['billing_address']['city'])) {
			$this->data['city'] = $this->session->data['billing_address']['city'];
		}
		else {
			$this->data['city'] = 	'';
		}
		
		if(isset($this->request->post['postcode']) && !isset($this->request->post['use_shipping_address'])) {
			$this->data['postcode'] = $this->request->post['postcode'];
		}
		elseif(isset($this->session->data['billing_address']['postcode'])) {
			$this->data['postcode'] = $this->session->data['billing_address']['postcode'];
		}
		else {
			$this->data['postcode'] = 	'';
		}
		
		if(isset($this->request->post['phone']) && !isset($this->request->post['use_shipping_address'])) {
			$this->data['phone'] = $this->request->post['phone'];
		}
		elseif(isset($this->session->data['billing_address']['phone'])) {
			$this->data['phone'] = $this->session->data['billing_address']['phone'];
		}
		else {
			$this->data['phone'] = 	'';
		}		
		
		if(isset($this->request->post['country_id']) && $this->request->post['country_id'] !="" && !isset($this->request->post['use_shipping_address'])) {
			$this->data['country'] = $this->request->post['country_id'];
			$country = $this->model_localisation_country->getCountry($this->request->post['country_id']);
			$this->data['country_name'] = $country['name'];
		}
		elseif(isset($this->session->data['billing_address']['country']) && $this->session->data['billing_address']['country'] != '') 
		{
			$this->data['country'] = $this->session->data['billing_address']['country'];
			$country = $this->model_localisation_country->getCountry($this->session->data['billing_address']['country']);
			$this->data['country_name'] = $country['name'];
		}
		else {
			$this->data['country'] = 	'';
			$this->data['country_name'] = '';
		}

		if(isset($this->request->post['zone_id']) && $this->request->post['zone_id'] !="" && !isset($this->request->post['use_shipping_address'])) {
			$this->data['zone'] = $this->request->post['zone_id'];
			$this->data['zone_id'] = $this->request->post['zone_id'];
			$zone = $this->model_localisation_zone->getZone($this->request->post['zone_id']);	
			$this->data['zone_name'] = $zone['name'];
		}
		elseif(isset($this->session->data['billing_address']['zone']) && $this->session->data['billing_address']['zone'] != '') {
			$this->data['zone'] = $this->session->data['billing_address']['zone'];
			$zone = $this->model_localisation_zone->getZone($this->session->data['billing_address']['zone']);	
			$this->data['zone_name'] = $zone['name'];
			$this->data['zone_id'] = $this->session->data['billing_address']['zone'];
		}
		else {
			$this->data['zone'] = '';
			$this->data['zone_id'] = '';
			$this->data['zone_name'] = '';
		}

		if(isset($this->data['show_billing_form']) && $this->data['show_billing_form'] == true)
		{
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
			
			if (isset($this->error['phone'])) {
				$this->data['error_phone'] = $this->error['phone'];
			} else {
				$this->data['error_phone'] = '';
			}
		}

		$this->data['card_types'] = array(1 => 'Visa', 2 => 'MasterCard', 3 => 'American Express', 4 => 'JCB', 5 => 'Discover', 6 => 'Maestro', 6 => 'Maestro', 7 => 'UnionPay');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout_payment.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout_payment.tpl';
		} else {
			$this->template = 'default/template/checkout/checkout_payment.tpl';
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
	
	protected function validate_billing_address()
	{
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
		
		if ((utf8_strlen($this->request->post['phone']) < 3) || (utf8_strlen($this->request->post['phone']) > 32)) {
				$this->error['phone'] = $this->language->get('error_telephone');
			}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
		
	}
	
	protected function validate_card()
	{
		if ((utf8_strlen($this->request->post['card_name']) < 1) || (utf8_strlen($this->request->post['card_name']) > 50)) {
			$this->error['card_name'] = "Wrong name on card";
		}

		if (!preg_match('/[0-9]{16}$/', $this->request->post['card_number'])) {
			$this->error['card_number'] = "Wrong cart number";
		}

		if ((utf8_strlen($this->request->post['card_date']) != 5)) {
			$this->error['card_date'] = "Wrong date";
		}

		if (utf8_strlen($this->request->post['card_code']) != 3) {
			$this->error['card_code'] = "Wrong code";
		}

		if ($this->request->post['card_type'] == '') {
			$this->error['card_type'] = "Please choose your card type";
		}
		
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}		
	}
}