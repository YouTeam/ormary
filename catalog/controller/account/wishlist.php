<?php 
class ControllerAccountWishList extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/wishlist', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/wishlist');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}

		if (isset($this->request->get['remove'])) {
			$key = array_search($this->request->get['remove'], $this->session->data['wishlist']);

			if ($key !== false) {
				unset($this->session->data['wishlist'][$key]);
			}

			$this->session->data['success'] = $this->language->get('text_remove');

			$this->redirect($this->url->link('account/wishlist'));
		}

		$this->document->setTitle($this->language->get('heading_title'));	

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
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/wishlist'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');	

		$this->data['text_empty'] = $this->language->get('text_empty');

		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_stock'] = $this->language->get('column_stock');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		
		
		if(isset($this->request->get['collection_id']))
		{
			$this->data['collection_id'] = (int)$this->request->get['collection_id'];
		}
		else
		{
			$this->data['collection_id'] = 0;
		}
		
		$this->data['collections_list'] = $this->model_catalog_product->getWishListCollections();
		
		//print_r($this->session->data['wishlist']);
/*		foreach($this->data['collections_list'] as $cl)
		{
			$this->data['collections_list']['count'] = $this->model_catalog_product->getWishListCollectionProductsCount($cl['collection_id']);
		}*/

		$collection_products = $this->model_catalog_product->getWishListCollectionProducts($this->data['collection_id']);
		//print_r($collection_products);
		$this->data['products'] = array();

		//foreach ($this->session->data['wishlist'] as $key => $product_id) 
		foreach ($collection_products as $key => $product_id) 
		{
			//if(in_array($product_id, $collection_products))
			//{
				$product_info = $this->model_catalog_product->getProduct($product_id);
	
				if ($product_info) { 
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
					} else {
						$image = $this->model_tool_image->resize("no_image.png", $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
					}
	
					if ($product_info['quantity'] <= 0) {
						$stock = $product_info['stock_status'];
					} elseif ($this->config->get('config_stock_display')) {
						$stock = $product_info['quantity'];
					} else {
						$stock = $this->language->get('text_instock');
					}
	
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}
	
					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}
	
					$this->data['products'][] = array(
						'product_id' => $product_info['product_id'],
						'manufacturer' => $product_info['manufacturer'],
						'thumb'      => $image,
						'name'       => $product_info['name'],
						'model'      => $product_info['model'],
						'stock'      => $stock,
						'price'      => $price,		
						'special'    => $special,
						'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
						'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id'])
					);
				} else {
					unset($this->session->data['wishlist'][$key]);
				}
			//}
		}	

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/wishlist.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/wishlist.tpl';
		} else {
			$this->template = 'default/template/account/wishlist.tpl';
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

	public function add() {

		if ($this->customer->isLogged()) 
		{
			$this->language->load('account/wishlist');
	
			$json = array();
	
			if (!isset($this->session->data['wishlist'])) {
				$this->session->data['wishlist'] = array();
			}
	
			if (isset($this->request->post['product_id'])) {
				$product_id = $this->request->post['product_id'];
			} else {
				$product_id = 0;
			}
			
			
			if (isset($this->request->post['collection_id'])) {
				$collection_id = $this->request->post['collection_id'];
			} else {
				$collection_id = 0;
			}
	
			$this->load->model('catalog/product');
	
			$product_info = $this->model_catalog_product->getProduct($product_id);
	
			if ($product_info) {
				//if (!in_array($this->request->post['product_id'], $this->session->data['wishlist'])) {
				if (!in_array($this->request->post['product_id'], $this->model_catalog_product->getWishListCollectionProducts($collection_id))) {	
					$this->session->data['wishlist'][] = $this->request->post['product_id'];
					//$json['success'] = $this->request->post['product_id']."--".$collection_id."+++";
					$this->model_catalog_product->addToWishListCollection($this->request->post['product_id'], $collection_id);
				}
				
				if ($this->customer->isLogged()) {			
					$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'), $this->url->link('account/wishlist'));				
				} else {
					$json['success'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));				
				}
	
				$json['total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
			}	
	
			$this->response->setOutput(json_encode($json));
		}
	}
	
	public function remove() 
	{
		if ($this->customer->isLogged()) 
		{
			if (isset($this->request->get['product_id'])) {
				$product_id = $this->request->get['product_id'];
			} else {
				$product_id = 0;
			}
			
			if (isset($this->request->get['collection_id'])) {
				$collection_id = $this->request->get['collection_id'];
			} else {
				$collection_id = 0;
			}
			
			$this->load->model('catalog/product');
			$this->model_catalog_product->removeFromWishListCollection($product_id, $collection_id);
		}
	}
	
	public function update() 
	{
		if ($this->customer->isLogged()) 
		{
			if (isset($this->request->get['product_id'])) {
				$product_id = $this->request->get['product_id'];
			} else {
				$product_id = 0;
			}
			
			if (isset($this->request->get['collection_id'])) {
				$collection_id = $this->request->get['collection_id'];
			} else {
				$collection_id = 0;
			}
			
			$this->load->model('catalog/product');
                        
                        
                                   	$this->model_catalog_product->addToWishListCollection($product_id, $collection_id);
                                   
                        
                                                 
                                    
         
                                                        }
	}
	
	public function addCollection() 
	{
		if ($this->customer->isLogged()) 
		{
			$this->load->model('catalog/product');
			$this->model_catalog_product->addWishListCollection($this->request->get['collection_name']);
		}
	}
	
	public function removeCollection() 
	{
		if ($this->customer->isLogged()) 
		{
			$this->load->model('catalog/product');
			$this->model_catalog_product->removeWishListCollection($this->request->get['collection_id']);
		}
	}
	
	
	public function getWishlistRelatedProduct() 
	{
		if ($this->customer->isLogged()) 
		{
			if (isset($this->request->post['product_id'])) 
			{
				$product_id = (int)$this->request->post['product_id'];
							
				$this->load->model('catalog/product');

				$results = $this->model_catalog_product->getProductRelated((int)$this->request->post['product_id']);
				$json = array();
				$this->load->model('tool/image');
				$this->load->model('catalog/manufacturer');
				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
					} else {
						$image = $image = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
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
	
					if ($this->config->get('config_review_status')) {
						$rating = (int)$result['rating'];
					} else {
						$rating = false;
					}

					$related_manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($result['manufacturer_id']);
	
					$json['products'][] = array(
						'product_id' => $result['product_id'],
						'thumb'   	 => $image,
						'name'    	 => $result['name'],
						'designer'   => $related_manufacturer_info['name'],
						'price'   	 => $price,
						'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				} 
			}
		}
		$this->response->setOutput(json_encode($json));
	}
	
        
        
}
?>