<?php
class ControllerShippingFlatrateShipping extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('shipping/flatrate_shipping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('shipping/flatrate_shipping');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			if(isset($this->request->get['id']))
			{
				$this->model_shipping_flatrate_shipping->editShippingRate($this->request->get['id'], $this->request->post);
			}
			else
			{
				$this->model_shipping_flatrate_shipping->addShippingRate($this->request->post);	
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('shipping/flatrate_shipping_list', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_countries'] = $this->language->get('entry_countries');
		$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_order'] = $this->language->get('entry_order');
		$this->data['entry_cart_price'] = $this->language->get('entry_cart_price');
		$this->data['entry_message'] = $this->language->get('entry_message');


		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/flatrate_shipping_list', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['cancel'] = $this->url->link('shipping/flatrate_shipping_list', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['id'])) 
		{			
			$current_shipping = $this->model_shipping_flatrate_shipping->getShippingRate($this->request->get['id']);	
			$this->data['action'] = $this->url->link('shipping/flatrate_shipping', 'token=' . $this->session->data['token']."&id=".$this->request->get['id'], 'SSL');		
		}
		else
		{
			$this->data['action'] = $this->url->link('shipping/flatrate_shipping', 'token=' . $this->session->data['token'], 'SSL');			
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (isset($this->request->get['id'])) {
			$this->data['name'] = $current_shipping['name'];
		} else {
			$this->data['name'] = '';
		}	
		
		if (isset($this->request->post['countries'])) {
			$this->data['countries'] = $this->request->post['countries'];
		} elseif (isset($this->request->get['id'])) {
			$this->data['countries'] = $current_shipping['countries'];
		} else {
			$this->data['countries'] = 0;
		}		

		$this->load->model('localisation/country');

		$this->data['countries_list'] = $this->model_localisation_country->getCountries();
		
		if (isset($this->request->post['price'])) {
			$this->data['price'] = $this->request->post['price'];
		} elseif (isset($this->request->get['id'])) {
			$this->data['price'] = $current_shipping['price'];
		} else {
			$this->data['price'] = 0;
		}		
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($this->request->get['id'])) {
			$this->data['sort_order'] = $current_shipping['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}		
				
		if (isset($this->request->post['cart_price'])) {
			$this->data['cart_price'] = $this->request->post['cart_price'];
		} elseif (isset($this->request->get['id'])) {
			$this->data['cart_price'] = $current_shipping['cart_price'];
		} else {
			$this->data['cart_price'] = 0;
		}		
		
		if (isset($this->request->post['message'])) {
			$this->data['message'] = $this->request->post['message'];
		} elseif (isset($this->request->get['id'])) {
			$this->data['message'] = $current_shipping['message'];
		} else {
			$this->data['message'] = '';
		}		
			
		$this->template = 'shipping/flatrate_shipping.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
				
		if($this->request->post['name']== '')
		{
			$error['name']="Please enter name";	
		}
		
		if($this->request->post['message']== '')
		{
			$error['message'] = "Please enter shipping message";	
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	public function delete() {

		$this->load->model('shipping/flatrate_shipping');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_shipping_flatrate_shipping->deleteShippingRate($id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$this->redirect($this->url->link('shipping/flatrate_shipping_list', 'token=' . $this->session->data['token'], 'SSL'));
	}
	
}
?>