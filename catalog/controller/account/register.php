<?php 
class ControllerAccountRegister extends Controller {
	private $error = array();

	public function index() {
	
		if(isset($this->request->post['userid']))
		{
			$this->load->model('account/follow');
			echo $this->request->post['following_designers'];
                   
			$this->model_account_follow->saveUserFollows(explode(',', $this->request->post['following_designers']));
			unset($this->session->data['designers']);
			$this->language->load('account/success');
			$this->session->data['success']  = $this->language->get('text_message');

			$this->redirect($this->url->link('common/home'));
                        
		}
		
		
		if ($this->customer->isLogged()) {
			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}

		$this->language->load('account/register');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');

		$this->load->model('account/customer');

		//if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePopup()) {

			$data = array('lastname' => '', 'telephone' => '', 'fax' => '', 'biography' => '', 'company' => '', 'company_id' => '', 'tax_id' => '', 'address_1' => '', 'address_2' => '', 'city' => '', 'postcode' => '', 'country_id' => 0, 'zone_id' => 0);
			
			$data = array_merge($this->request->post, $data) ;
			
			$this->model_account_customer->addCustomer($data);
			
			$mail = new Mail();	
			$mail->sendNotificationEmail( $this->request->post['email'], '', file_get_contents('./emails/welcome_template.html', FILE_USE_INCLUDE_PATH), 'Welcome to ORMARY');
			
			$this->customer->login($this->request->post['email'], $this->request->post['password']);

			unset($this->session->data['guest']);
			$this->load->model('account/follow');
			
                        
                                                        $users_to_follow = explode(',', $this->request->post['following_designers']);

                                                        
                                                        if (count ($users_to_follow) < 3) {
                                                          
                                                            $this->load->model('catalog/manufacturer');
		
		
                                                            $auto_follow_users =  $this->model_catalog_manufacturer->getPopularManufacturersIds();
                                                            array_merge($users_to_follow, $auto_follow_users);
                                                                  
                                                        }
                        
			$this->model_account_follow->saveUserFollows($users_to_follow);

			unset($this->session->data['designers']);
/*			// Default Shipping Address
			if ($this->config->get('config_tax_customer') == 'shipping') {
				$this->session->data['shipping_country_id'] = $this->request->post['country_id'];
				$this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
				$this->session->data['shipping_postcode'] = $this->request->post['postcode'];				
			}

			// Default Payment Address
			if ($this->config->get('config_tax_customer') == 'payment') {
				$this->session->data['payment_country_id'] = $this->request->post['country_id'];
				$this->session->data['payment_zone_id'] = $this->request->post['zone_id'];			
			}*/
			$this->language->load('account/success');
			$this->session->data['success']  = $this->language->get('text_message');
			$this->redirect($this->url->link('common/feed'));
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),        	
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),      	
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_register'),
			'href'      => $this->url->link('account/register', '', 'SSL'),      	
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', 'SSL'));
		$this->data['text_your_details'] = $this->language->get('text_your_details');
		$this->data['text_your_address'] = $this->language->get('text_your_address');
		$this->data['text_your_password'] = $this->language->get('text_your_password');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');
		$this->data['entry_address_2'] = $this->language->get('entry_address_2');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_city'] = $this->language->get('entry_city');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_confirm'] = $this->language->get('entry_confirm');

		$this->data['button_continue'] = $this->language->get('button_continue');


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

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
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

		if (isset($this->error['company_id'])) {
			$this->data['error_company_id'] = $this->error['company_id'];
		} else {
			$this->data['error_company_id'] = '';
		}

		if (isset($this->error['tax_id'])) {
			$this->data['error_tax_id'] = $this->error['tax_id'];
		} else {
			$this->data['error_tax_id'] = '';
		}

		if (isset($this->error['address_1'])) {
			$this->data['error_address_1'] = $this->error['address_1'];
		} else {
			$this->data['error_address_1'] = '';
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

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} else {
			$this->data['fax'] = '';
		}

		if (isset($this->request->post['company'])) {
			$this->data['company'] = $this->request->post['company'];
		} else {
			$this->data['company'] = '';
		}

		$this->load->model('account/customer_group');

		$this->data['customer_groups'] = array();

		if (is_array($this->config->get('config_customer_group_display'))) {
			$customer_groups = $this->model_account_customer_group->getCustomerGroups();

			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$this->data['customer_groups'][] = $customer_group;
				}
			}
		}

		if (isset($this->request->post['customer_group_id'])) {
			$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} else {
			$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}

		// Company ID
		if (isset($this->request->post['company_id'])) {
			$this->data['company_id'] = $this->request->post['company_id'];
		} else {
			$this->data['company_id'] = '';
		}

		// Tax ID
		if (isset($this->request->post['tax_id'])) {
			$this->data['tax_id'] = $this->request->post['tax_id'];
		} else {
			$this->data['tax_id'] = '';
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
		} elseif (isset($this->session->data['shipping_postcode'])) {
			$this->data['postcode'] = $this->session->data['shipping_postcode'];		
		} else {
			$this->data['postcode'] = '';
		}

		if (isset($this->request->post['city'])) {
			$this->data['city'] = $this->request->post['city'];
		} else {
			$this->data['city'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$this->data['country_id'] = $this->request->post['country_id'];
		} elseif (isset($this->session->data['shipping_country_id'])) {
			$this->data['country_id'] = $this->session->data['shipping_country_id'];		
		} else {	
			$this->data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['zone_id'])) {
			$this->data['zone_id'] = $this->request->post['zone_id'];
		} elseif (isset($this->session->data['shipping_zone_id'])) {
			$this->data['zone_id'] = $this->session->data['shipping_zone_id'];			
		} else {
			$this->data['zone_id'] = '';
		}

		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();

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

		if (isset($this->request->post['newsletter'])) {
			$this->data['newsletter'] = $this->request->post['newsletter'];
		} else {
			$this->data['newsletter'] = '';
		}	

		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}

		if (isset($this->request->post['agree'])) {
			$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = false;
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/register.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/register.tpl';
		} else {
			$this->template = 'default/template/account/register.tpl';
		}

			

		/*$this->designersList();
		print_r($this->session->data['designers']);
		$this->data['first_designer'] = current($this->session->data['designers']);
		$this->session->data['designers_style_count'] = 0;
		$this->session->data['designers_liked_count'] = 0;
		$this->data['first_designer_order_id'] = 0;*/
		
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
	
	
	public function designersList()
	{
		$this->load->model('catalog/manufacturer');
		$this->session->data['designers'] = $this->model_catalog_manufacturer->getPopularManufacturersList();
		
		$first_designer = current($this->session->data['designers']);
		$this->session->data['designers_style_count'] = $first_designer['style'];
		$this->session->data['designers_liked_count'] = 0;
		$this->session->data['designers_liked_summary'] = 0;
		
		$this->data['first_designer_order_id'] = 0;
		
		
		$json = array();
		
		$json['designer']['id'] = 0;
		$json['designer']['mid'] = $first_designer['mid'];
		$json['designer']['name'] = $first_designer['name'];
		$json['designer']['image'] = $first_designer['image'];
		$json['designer']['image_list'] = '';
		foreach($first_designer['images'] as $img)
		{
			$json['designer']['image_list'] .= '<div class="swiper-slide"><img src="'.$img.'"></div>';
		}
		
		
		$this->response->setOutput(json_encode($json));	
		

	}
	
	public function getNextDesigner()
	{
		$designer = $json = array();
	
		$change_style = false;
		$new_des_id = -1;
		
		if(isset($this->request->post['designer_id']))
		{	
			if($this->request->post['like'] == "yes")
			{	
				$this->session->data['designers_liked_summary'] += 1;
				$this->session->data['designers'][$this->request->post['designer_id']]['liked'] = "yes";
				if($this->session->data['designers_style_count'] == $this->session->data['designers'][$this->request->post['designer_id']]['style'])
				{
					$this->session->data['designers_liked_count'] += 1;					
				}
				else
				{
					$this->session->data['designers_liked_count'] = 1;	
				}
				
				if($this->session->data['designers_liked_count'] >= 2)
				{
					$change_style = true;
					$this->session->data['designers_liked_count'] = 0;
				}
			}
			else
			{
				$this->session->data['designers'][$this->request->post['designer_id']]['liked'] = "no";
				$this->session->data['designers_liked_count'] = 0;	
				$change_style = true;	
			}
			
			$this->session->data['designers_style_count'] = $this->session->data['designers'][$this->request->post['designer_id']]['style'];
			
			
			if($this->request->post['designer_id'] < count($this->session->data['designers'])-1)
			{
				for($i=$this->request->post['designer_id']+1; $i < count($this->session->data['designers']); $i++)
				{
					if($this->session->data['designers'][$i]['liked'] == "yes" || $this->session->data['designers'][$i]['liked'] == "no")
					{
						continue;	
					}
					
					if($change_style == true)
					{
						if($this->session->data['designers'][$i]['style'] != $this->session->data['designers_style_count'])	
						{
							$new_des_id = $i;
							break;
						}
					}
					else
					{
						if($this->session->data['designers'][$i]['style'] == $this->session->data['designers_style_count'])	
						{
							$new_des_id = $i;
							break;
						}
					}
				}
			}
			else
			{
				for($i=0; $i < count($this->session->data['designers']); $i++)
				{
					if($this->session->data['designers'][$i]['liked'] == "yes" || $this->session->data['designers'][$i]['liked'] == "no")
					{
						continue;	
					}
					
					if($change_style == true)
					{
						if($this->session->data['designers'][$i]['style'] != $this->session->data['designers_style_count'])	
						{
							$new_des_id = $i;
							break;
						}
					}
					else
					{
						if($this->session->data['designers'][$i]['style'] == $this->session->data['designers_style_count'])	
						{
							$new_des_id = $i;
							break;
						}
					}
				}
			}			
			
			if($new_des_id == -1)
			{
				$change_style = true;	
				$this->session->data['designers_liked_count'] = 0;
				$this->session->data['designers_style_count'] = 0;
				
				for($i=0; $i < count($this->session->data['designers']); $i++)
				{
					if($this->session->data['designers'][$i]['liked'] == "yes" || $this->session->data['designers'][$i]['liked'] == "no")
					{
						continue;	
					}
					else
					{
						$new_des_id = $i;
						break;	
					}					
				}
			}			
		}
			
		if($new_des_id == -1)
		{
			$json['all_designers'] = true;
		}
		else
		{
			$designer = $this->session->data['designers'][$new_des_id];
			$json['all_designers'] = false;	
			$json['designers_style_count'] = $this->session->data['designers_style_count'];
		
			$json['designers_liked_count'] = $this->session->data['designers_liked_count'];
	
			$json['designer']['id'] = $new_des_id;
			$json['designer']['mid'] = $designer['mid'];
			$json['designer']['name'] = $designer['name'];
			$json['designer']['image'] = $designer['image'];
			$json['designer']['image_list'] = '';
			if(isset($designer['images']))
			{
				foreach($designer['images'] as $img)
				{
					$json['designer']['image_list'] .= '<div class="swiper-slide"><img src="'.$img.'"></div>';
				}
			}
		}
		$json['designers_liked_summary'] = $this->session->data['designers_liked_summary'];
		$this->response->setOutput(json_encode($json));		
	}
	
	
	

	public function ajaxValidate() 
	{
		$json = array();
		$error =array();
		$this->load->model('account/customer');
	/*	if(!$this->validate())
		{
			
		}*/
		//print_r($this->request->post);


		
		
		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$error['name']= $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$error['email'] = $this->language->get('error_email');
		}
		elseif($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email']) > 0)
		{
			$error['email_exist'] = $this->language->get('error_email');;	
		}
		
		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			$error['password'] = $this->language->get('error_password');
		}
		
		if ($this->request->post['terms'] == 0)
		{
			$error['terms']= $this->language->get('error_confirm');
		}
		
		if($error != '')
		{
			$json['error'] = $error;
		}
		
		
		$this->response->setOutput(json_encode($json));	
	}
	
	protected function validatePopup() {
		
		//print_r($this->request->post);
		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}
		
		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}
		
		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		}
		
		if (!$this->error) 
		{
			return true;
		} else {
			return false;
		}
	}


	protected function validate() {
		
		//print_r($this->request->post);
		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		// Customer Group
		$this->load->model('account/customer_group');

		if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

		if ($customer_group) {	
			// Company ID
			if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && empty($this->request->post['company_id'])) {
				$this->error['company_id'] = $this->language->get('error_company_id');
			}

			// Tax ID 
			if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && empty($this->request->post['tax_id'])) {
				$this->error['tax_id'] = $this->language->get('error_tax_id');
			}						
		}

		if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
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

		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$this->error['confirm'] = $this->language->get('error_confirm');
		}

		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

			if ($information_info && !isset($this->request->post['agree'])) {
				$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
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
}
?>