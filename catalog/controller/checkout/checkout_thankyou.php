<?php  
class ControllerCheckoutCheckoutLogin extends Controller { 
	public function index() {
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) 
		{
		//	$this->redirect($this->url->link('/'));
		}
		
		if ($this->customer->isLogged()) 
		{
			$this->redirect($this->url->link('/'));
		}
		
		
		
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['shipping_required'] = $this->cart->hasShipping();	





		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout_thankyou.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout_thankyou.tpl';
		} else {
			$this->template = 'default/template/checkout/checkout_thankyou.tpl';
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
}