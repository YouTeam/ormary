<?php 
class ControllerAccountFashionfeed extends Controller { 
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

			if (isset($this->session->data['success'])) {
				$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
			} else {
				$this->data['success'] = '';
			}
	
			$this->language->load('account/account');
	
			$this->document->setTitle($this->language->get('my_fashionfeed_heading_title'));
	
			$this->load->model('account/follow');
			$my_followers = $this->model_account_follow->getMyFollows();
			
			$this->data['follows_count'] = $my_followers->num_rows;
			
			$this->data['my_follows'] = $my_followers->rows;
			
			
			$this->data['active_link'] = array('all' => '', 'new' => '', 'recomended' => '', 'featured' => '');
			if(isset($this->request->get['filter']))
			{
				$filter = $this->request->get['filter'];
			}
			else
			{
				$filter = 'all';
			}
			
			$this->load->model('tool/image'); 
			
			if($filter == "all")
			{
				$this->data['active_link']['all']= "active";
				$this->data['products'] = $this->model_account_follow->getAllMyFashionfeedProd();
			}
			elseif($filter == "new")
			{
				$this->data['active_link']['new']= "active";
				$this->data['products'] = $this->model_account_follow->getNewMyFashionfeedProd();
			}
			elseif($filter == "recomended")
			{
				$this->data['active_link']['recomended']= "active";
				$this->data['products'] = $this->model_account_follow->getRecomendedMyFashionfeedProd();		
			}
			
			foreach($this->data['products'] as &$p)
			{
				$p['image'] = $this->model_tool_image->resize($p['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			}
			/*elseif($filter == "featured")
			{
				$this->data['active_link']['featured']= "active";
				$this->data['products'] = $this->model_account_follow->getFeaturedMyFashionfeedProd();	
			}*/
			
			
			$this->load->model('catalog/product');
			foreach ($this->session->data['wishlist'] as $key => $product_id) 
			{
				$product_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($product_info) 
				{
					$this->data['wardrobe_products'][$product_id]['product_id'] = $product_id; 
					$this->data['wardrobe_products'][$product_id]['image'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
					$this->data['wardrobe_products'][$product_id]['name'] = $product_info['name'];
					$this->data['wardrobe_products'][$product_id]['designer'] = $product_info['manufacturer'];
					$this->data['wardrobe_products'][$product_id]['price'] = $product_info['price'];
				}
			}
			
	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/fashionfeed.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/account/fashionfeed.tpl';
			} else {
				$this->template = 'default/template/account/fashionfeed.tpl';
			}
			$this->children = array(
				'common/column_left',
				'common/column_right',
				//'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'		
			);
	
		$this->response->setOutput($this->render());
	}
}
?>