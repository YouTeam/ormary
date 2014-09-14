<?php  
class ControllerCheckoutCheckoutLogin extends Controller { 
	private $error = array();
	
	public function index() {
		if (!$this->cart->hasProducts()) 
		{
			$this->redirect($this->url->link('common/home'));
		}
		
		if ($this->customer->isLogged()) 
		{
			$this->redirect($this->url->link('checkout/checkout_shipping', '', 'SSL'));
		}
		
		$this->language->load('checkout/custom_checkout');
		$this->load->model('account/customer');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) 
		{
			if(isset($this->request->post['form_type']) && $this->request->post['form_type'] == 'login')
			{
				unset($this->session->data['guest']);
			}
			elseif(isset($this->request->post['form_type']) && $this->request->post['form_type'] == 'register')
			{
				$this->session->data['new_user_email'] = $this->request->post['register_email'];
			}
			$this->redirect($this->url->link('checkout/checkout_shipping', '', 'SSL'));
		}
		
		
		$this->document->setTitle($this->language->get('checkout_login_title'));
		$this->data['form_action'] = $this->url->link('checkout/checkout_login', '', 'SSL');
		$this->data['forgotten_pass_link'] = $this->url->link('account/forgotten', '', 'SSL');

		if (isset($this->error['login_warning'])) {
			$this->data['login_warning'] = $this->error['login_warning'];
		} else {
			$this->data['login_warning'] = '';
		}
		
		if (isset($this->error['register_email_error'])) {
			$this->data['register_email_error'] = $this->error['register_email_error'];
		} else {
			$this->data['register_email_error'] = '';
		}
		
		if (isset($this->error['register_warning'])) {
			$this->data['register_warning'] = $this->error['register_warning'];
		} else {
			$this->data['register_warning'] = '';
		}
		
		
		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}
		
		if (isset($this->request->post['register_email'])) {
			$this->data['register_email'] = $this->request->post['register_email'];
		} else {
			$this->data['register_email'] = '';
		}


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout_login.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout_login.tpl';
		} else {
			$this->template = 'default/template/checkout/checkout_login.tpl';
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
	
	protected function validate() 
	{		
		if(isset($this->request->post['form_type']) && $this->request->post['form_type'] == 'login')
		{
			if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
				$this->error['login_warning'] = $this->language->get('error_login');
			}
	
			$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
	
			if ($customer_info && !$customer_info['approved']) {
				$this->error['login_warning'] = $this->language->get('error_approved');
			}
		}
		elseif(isset($this->request->post['form_type']) && $this->request->post['form_type'] == 'register')
		{
			if ((utf8_strlen($this->request->post['register_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['register_email'])) 
			{
				$this->error['register_email_error'] = $this->language->get('error_email');
			}
	
			if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['register_email'])) 
			{
				$this->error['register_warning'] = $this->language->get('error_exists');
			}	
		}
		
		if(!$this->error) 
		{
			return true;
		} else {
			return false;
		}
	}
}