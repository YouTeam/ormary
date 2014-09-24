<?php
class ControllerShippingFlatrateShippingList extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('shipping/flatrate_shipping');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('shipping/flatrate_shipping');

		$this->data['heading_title'] = $this->language->get('heading_list_title');


		$this->data['insert'] = $this->url->link('shipping/flatrate_shipping', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('shipping/flatrate_shipping/delete', 'token=' . $this->session->data['token'], 'SSL');	
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');	

		//$manufacturer_total = $this->model_catalog_manufacturer->getTotalManufacturers();

		$results = $this->model_shipping_flatrate_shipping->getAllShippingRates();
		foreach ($results as $result) 
		{
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('shipping/flatrate_shipping', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] , 'SSL')
			);

			$this->data['shipping'][] = array(
				'id' => $result['id'],
				'name'            => $result['name'],
				'sort_order'      => $result['sort_order'],
				'action'          => $action
			);
		}

		$this->template = 'shipping/flatrate_shipping_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>