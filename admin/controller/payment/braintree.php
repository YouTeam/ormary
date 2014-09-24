<?php
class ControllerPaymentBraintree extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/braintree');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->data['success'] = false;
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('braintree', $this->request->post);

			$this->data['success'] = $this->language->get('text_success');
		}

		$this->data['heading_title'] = $this->language->get('heading_title');


		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_merchantid'] = $this->language->get('entry_merchantid');	
		$this->data['entry_publickey'] = $this->language->get('entry_publickey');
		$this->data['entry_privatekey'] = $this->language->get('entry_privatekey');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['action'] = $this->url->link('payment/braintree', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');



		if (isset($this->request->post['braintree_test'])) {
			$this->data['braintree_test'] = $this->request->post['braintree_test'];
		} else {
			$this->data['braintree_test'] = $this->config->get('braintree_test');
		}

		if (isset($this->request->post['braintree_merchantid'])) {
			$this->data['braintree_merchantid'] = $this->request->post['braintree_merchantid'];
		} else {
			$this->data['braintree_merchantid'] = $this->config->get('braintree_merchantid');
		}

		if (isset($this->request->post['braintree_publickey'])) {
			$this->data['braintree_publickey'] = $this->request->post['braintree_publickey'];
		} else {
			$this->data['braintree_publickey'] = $this->config->get('braintree_publickey');
		}

		if (isset($this->request->post['braintree_privatekey'])) {
			$this->data['braintree_privatekey'] = $this->request->post['braintree_privatekey'];
		} else {
			$this->data['braintree_privatekey'] = $this->config->get('braintree_privatekey');
		}



		$this->template = 'payment/braintree.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/braintree')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>