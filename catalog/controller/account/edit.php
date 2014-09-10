<?php
class ControllerAccountEdit extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/edit');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) 
		{
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
			
			if (is_uploaded_file($this->request->files['ufile']['tmp_name'])) 
			{
	/*			$uploaddir = realpath($this->request->server['DOCUMENT_ROOT'].'/ormary/image/data/avatars/');*/
	//			$uploaddir = realpath($this->request->server['DOCUMENT_ROOT'].'image/data/avatars');
				$uploaddir = DIR_IMAGE.'data/avatars';
	
				$ext = substr(basename($this->request->files['ufile']['name']), strripos(basename($this->request->files['ufile']['name']), "."));
				$newName = uniqid().$ext;
				$uploadfile = $uploaddir ."/". $newName;

				if (move_uploaded_file($this->request->files['ufile']['tmp_name'], $uploadfile)) {
					$this->request->post['profile_img_url'] = 'image/data/avatars/'.$newName;
				} 
		
			} elseif (isset($customer_info)) {
				$this->request->post['profile_img_url'] = $customer_info['profile_img_url'];
			} else {
				$this->request->post['profile_img_url'] = '';
			}

		
			if(!isset($this->request->post['newsletter']))
			{
				$this->request->post['newsletter'] = 0;		
			}
		
			$this->model_account_customer->editCustomer($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('account/account', '', 'SSL'));
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
			'text'      => $this->language->get('text_edit'),
			'href'      => $this->url->link('account/edit', '', 'SSL'),       	
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_your_details'] = $this->language->get('text_your_details');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

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

		$this->data['action'] = $this->url->link('account/edit', '', 'SSL');
		
		$this->load->model('account/address');
		$results = $this->model_account_address->getAddresses();
		foreach($results as $res){
		$this->data['address_url'] = $this->url->link('account/address/update', 'address_id=' . $res['address_id'], 'SSL');
		}

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		}

	//	print_r($this->customer);

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (isset($customer_info)) {
			$this->data['firstname'] = $customer_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (isset($customer_info)) {
			$this->data['lastname'] = $customer_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (isset($customer_info)) {
			$this->data['email'] = $customer_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} elseif (isset($customer_info)) {
			$this->data['telephone'] = $customer_info['telephone'];
		} else {
			$this->data['telephone'] = '';
		}
	
		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif (isset($customer_info)) {
			$this->data['fax'] = $customer_info['fax'];
		} else {
			$this->data['fax'] = '';
		}
		
		if (isset($this->request->post['biography'])) {
			$this->data['biography'] = $this->request->post['biography'];
		} elseif (isset($customer_info)) {
			$this->data['biography'] = $customer_info['biography'];
		} else {
			$this->data['biography'] = '';
		}
		
		if (isset($this->request->post['profile_img_url'])) {
			$this->data['profile_img_url'] = $this->request->post['profile_img_url'];
		} elseif (isset($customer_info)) {
			$this->data['profile_img_url'] = $customer_info['profile_img_url'];
		} else {
			$this->data['profile_img_url'] = '';
		}

		if($this->data['profile_img_url'] == '')
		{
			$this->data['profile_img_url'] = 'image/data/avatars/no_image.png';	
		}
		
		
		if (isset($this->request->post['website'])) {
			$this->data['website'] = $this->request->post['website'];
		} elseif (isset($customer_info)) {
			$this->data['website'] = $customer_info['website'];
		} else {
			$this->data['website'] = '';
		}
		
		
		if (isset($this->request->post['user_link'])) {
			$this->data['user_link'] = $this->request->post['user_link'];
		} elseif (isset($customer_info)) {
			$this->data['user_link'] = $customer_info['user_link'];
		} else {
			$this->data['user_link'] = '';
		}
		//print_r($customer_info['interest']);
		$this->data['interest']['mens'] = $this->data['interest']['womens'] = '';
		if (isset($this->request->post['interest'])) {
			$this->request->post['interest'] == 1? $this->data['interest']['womens'] = 'checked="checked"': $this->data['interest']['mens'] = 'checked="checked"';	
			
		} elseif (isset($customer_info)) {
			//print_r("1234");
			$customer_info['interest'] == 1? $this->data['interest']['womens'] = 'checked="checked"': $this->data['interest']['mens'] = 'checked="checked"';
		} else {
			$this->data['interest']['womens'] = 'checked="checked"';
		}
		
		if (isset($this->request->post['newsletter'])) {
			$this->data['newsletter'] =  $this->request->post['newsletter'] == 1 ? 'checked="checked"':'';
		} elseif (isset($customer_info)) {
			$this->data['newsletter'] =  $customer_info['newsletter'] == 1 ? 'checked="checked"':'';
		} else {
			$this->data['newsletter'] = 0;
		}
		
		
		//print_r($customer_info);
		
		$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/edit.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/edit.tpl';
		} else {
			$this->template = 'default/template/account/edit.tpl';
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

	protected function validate() {
		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}
/*
		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}
*/
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>