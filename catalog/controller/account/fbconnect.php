<?php 
class ControllerAccountFbconnect extends Controller {
	private $error = array();
	      
  	public function index() 
	{

		if ($this->customer->isLogged()) 
		{
	  		$this->redirect($this->url->link('account/account', '', 'SSL'));
    	}

		$this->language->load('module/fbconnect');

		$json = array();
		$fbuser_profile = array();
		                       //'1516828378549040'
		$fbuser_profile['id']=  $_POST['id']; //'100006656777063';//
		$fbuser_profile['email']= $_POST['email']; //'xrvxfpa_panditstein_1408126266@tfbnw.net';//
		$fbuser_profile['first_name']= $_POST['first_name'];//'James Amffefgggjfc Panditstein';//


		if($fbuser_profile['id'] && $fbuser_profile['email'] )
		{
			$this->load->model('account/customer');

			$email = $fbuser_profile['email'];
			$password = $this->get_password($fbuser_profile['id']);

			if($this->customer->login($email, $password)){
				$json['login'] = 'login';
				//$this->redirect($this->url->link('account/account', '', 'SSL')); 
			}

			$email_query = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(strtolower($email)) . "'");

			if($email_query->num_rows)
			{
				$this->model_account_customer->editPassword($email, $password);
				
				if($this->customer->login($email, $password))
				{
					$json['login'] = 'login';
					//$this->redirect($this->url->link('common/home', '', 'SSL')); 
				}
			}
			else
			{
				$config_customer_approval = $this->config->get('config_customer_approval');
				$this->config->set('config_customer_approval',0);

				$this->request->post['email'] = $email;
			
				$add_data=array();
				$add_data['email'] = $fbuser_profile['email'];
				$add_data['password'] = $password;
				$add_data['firstname'] = isset($fbuser_profile['first_name']) ? $fbuser_profile['first_name'] : '';
				$add_data['lastname'] =   '';
				$add_data['fax'] = '';
				$add_data['biography'] = '';
				$add_data['telephone'] = '';
				$add_data['company'] = '';
				$add_data['company_id'] = '';
				$add_data['tax_id'] = '';
				$add_data['address_1'] = '';
				$add_data['address_2'] = '';
				$add_data['city'] = '';
				$add_data['postcode'] = '';
				$add_data['country_id'] = 0;
				$add_data['zone_id'] = 0;

				$this->model_account_customer->addCustomer($add_data);
				$this->config->set('config_customer_approval',$config_customer_approval);
				
				if($this->customer->login($email, $password))
				{
					$json['registration'] = 'registration';
					$json['user_id'] = $this->customer->getId();
					unset($this->session->data['guest']);
					//$this->redirect($this->url->link('common/home'));
				}
			}
			
			
		}
		
		$this->response->setOutput(json_encode($json));	
		//$this->redirect($this->url->link('account/account', '', 'SSL'));

	}

	private function get_password($str) 
	{
		$password = $this->config->get('fbconnect_pwdsecret') ? $this->config->get('fbconnect_pwdsecret') : 'fb';
		$password.=substr($this->config->get('fbconnect_apisecret'),0,3).substr($str,0,3).substr($this->config->get('fbconnect_apisecret'),-3).substr($str,-3);
		return strtolower($password);
	}

	private function clean_decode($data) {
    		if (is_array($data)) {
	  		foreach ($data as $key => $value) {
				unset($data[$key]);
				$data[$this->clean_decode($key)] = $this->clean_decode($value);
	  		}
		} else { 
	  		$data = htmlspecialchars_decode($data, ENT_COMPAT);
		}

		return $data;
	}	  
}
?>