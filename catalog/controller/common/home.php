<?php  
class ControllerCommonHome extends Controller {
	public function index() {
		if ($this->customer->isLogged()) {
				
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
			
			$this->load->model('catalog/product');
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
				$this->data['products'] = $this->model_catalog_product->getRecommendationsProducts();		
			}

			foreach($this->data['products'] as &$p)
			{
				if($p['image'] !="")
				{
					//print_r("--".$p['image']."--");
					$p['image'] = $this->model_tool_image->resize($p['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
				}
				else
				{
					
					$p['image'] = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
				}
				$p['price']  = $this->currency->format($p['price'], $p['tax_class_id'], $this->config->get('config_tax'));
			}
			/*elseif($filter == "featured")
			{
				$this->data['active_link']['featured']= "active";
				$this->data['products'] = $this->model_account_follow->getFeaturedMyFashionfeedProd();	
			}*/
			
			
			$this->load->model('catalog/product');
			$collection_products = $this->model_catalog_product->getWishListProducts();
			
			//foreach ($this->session->data['wishlist'] as $key => $product_id) 
			foreach ($collection_products as $key => $product_id)
			{
				$product_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($product_info) 
				{
					$this->data['wardrobe_products'][$product_id]['product_id'] = $product_id; 
					
					if($product_info['image'] != "")
					{
						$this->data['wardrobe_products'][$product_id]['image'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
					}
					else
					{
						$this->data['wardrobe_products'][$product_id]['image'] = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));	
					}
					
					$this->data['wardrobe_products'][$product_id]['name'] = $product_info['name'];
					$this->data['wardrobe_products'][$product_id]['designer'] = $product_info['manufacturer'];
					$this->data['wardrobe_products'][$product_id]['price'] = $this->currency->format($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
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
	
			
		}
		else
		{
			$this->document->setTitle($this->config->get('config_title'));
			$this->document->setDescription($this->config->get('config_meta_description'));
	
			$this->data['heading_title'] = $this->config->get('config_title');
			
			
			$this->load->model('catalog/product');
			$this->load->model('tool/image'); 
			
			
			$data = array(
				'featured' => 1,				
			);
			
			
			$this->load->model('setting/landing');
			$this->data['blocks'] = $this->model_setting_landing->getLandingPageBlocks();
			
			foreach($this->data['blocks'] as &$b)
			{
				if($b['id'] == 1)
				{
					$b['image'] = $this->model_tool_image->resize($b['image'], 376, 875);	
				}
				elseif($b['id'] == 2 || $b['id'] == 3)
				{
					$b['image'] = $this->model_tool_image->resize($b['image'], 375, 448);		
				}
				elseif($b['id'] == 4)
				{
					$b['image'] = $this->model_tool_image->resize($b['image'], 754, 423);		
				}
			}
			$this->data['featured_products']  = array();
			$results = $this->model_catalog_product->getProducts($data); 
			foreach ($results as $result) 
			{
				if ($result['image']) 
				{
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
				} 
				else 
				{
					$image = $this->model_tool_image->resize("no_image.png", $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')); 
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}	

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}	
							
				$this->load->model('catalog/manufacturer');
				$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($result['manufacturer_id']);
				
				$this->data['featured_products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', '&product_id=' . $result['product_id'] ),
					'manufacturer_name'	=>	$manufacturer_info['name'],
				);
				
			}
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
			} else {
				$this->template = 'default/template/common/home.tpl';
			}
	
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
		}

		$this->response->setOutput($this->render());
	
		
	}
}
?>