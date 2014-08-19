<?php
class ControllerAccountDesignerInfo extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/edit');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/designer_info');

		$this->data['designer_bg_img_url'] = '';

		if ($this->request->server['REQUEST_METHOD'] != 'POST') 
		{
			$designer_info = $this->model_account_designer_info->getDesignerInfo($this->customer->getId());
			
			if(!empty($designer_info))
			{
				$this->data['designer_bg_img_url'] = $designer_info['background_img'];	
			}
		}
		elseif($this->validate()) 
		{
			if (is_uploaded_file($this->request->files['bfile']['tmp_name'])) 
			{
				$uploaddir = realpath($this->request->server['DOCUMENT_ROOT'].'/image/data/designers_backgrounds/');
				$ext = substr(basename($this->request->files['bfile']['name']), strripos(basename($this->request->files['bfile']['name']), "."));
				$newName = uniqid().$ext;
				$uploadfile = $uploaddir ."/". $newName;
				if (move_uploaded_file($this->request->files['bfile']['tmp_name'], $uploadfile)) 
				{
					$this->request->post['designer_bg_img_url'] = '/image/data/designers_backgrounds/'.$newName;
				} 
			}
			elseif (isset($customer_info)) 
			{
				$this->request->post['designer_bg_img_url'] = $customer_info['designer_bg_img_url'];
			} 
			else 
			{
				$this->request->post['designer_bg_img_url'] = '';
			}
	
			$designer_info = $this->model_account_designer_info->getDesignerInfo($this->customer->getId());			
			if(!empty($designer_info))
			{
				$this->model_account_designer_info->updateDesigner($this->request->post);
				unlink($_SERVER["DOCUMENT_ROOT"].$designer_info['background_img']);
			}
			else
			{
				$this->model_account_designer_info->addDesigner($this->request->post);
			}
			
			
			
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
			'href'      => $this->url->link('account/designer_info', '', 'SSL'),       	
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_your_details'] = $this->language->get('text_your_details');



		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		
		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}	

		$this->data['action'] = $this->url->link('account/designer_info', '', 'SSL');
		
		$this->load->model('account/address');
		$results = $this->model_account_address->getAddresses();
		foreach($results as $res){
		$this->data['address_url'] = $this->url->link('account/address/update', 'address_id=' . $res['address_id'], 'SSL');
		}
	
/*		if (isset($this->request->post['designer_bg_img_url'])) {
			$this->data['designer_bg_img_url'] = $this->request->post['designer_bg_img_url'];
		} elseif (isset($customer_info['designer_bg_img_url'])) {
			$this->data['designer_bg_img_url'] = $customer_info['designer_bg_img_url'];
		} else {
			$this->data['designer_bg_img_url'] = '';
		}*/

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/designer_info.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/designer_info.tpl';
		} else {
			$this->template = 'default/template/account/designer_info.tpl';
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
		

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>