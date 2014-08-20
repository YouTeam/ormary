<?php 
class ControllerProductManufacturer extends Controller {  
	public function index() { 
		$this->language->load('product/manufacturer');

		$this->load->model('catalog/manufacturer');

		$this->load->model('tool/image');		

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_index'] = $this->language->get('text_index');
		$this->data['text_empty'] = $this->language->get('text_empty');

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_brand'),
			'href'      => $this->url->link('product/manufacturer'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['categories'] = $this->model_catalog_manufacturer->getManufacturerCategoriesFilter();
		if(isset($this->request->get['category']))
		{
			$this->data['selected_categories'] = explode(',' ,$this->db->escape($this->request->get['category']));
		}
		else
		{
			$this->data['selected_categories'] = array(0);		
		}


		/*$results = $this->model_catalog_manufacturer->getManufacturers();
		
		foreach ($results as $result) {
			if (is_numeric(utf8_substr($result['name'], 0, 1))) {
				$key = '0 - 9';
			} else {
				$key = utf8_substr(utf8_strtoupper($result['name']), 0, 1);
			}

			if (!isset($this->data['manufacturers'][$key])) {
				$this->data['categories'][$key]['name'] = $key;
			}

			$this->data['categories'][$key]['manufacturer'][] = array(
				'name' => $result['name'],
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
			);
		}*/
				
		$manufacturers = $this->model_catalog_manufacturer->getManufacturersList($this->request->get);
		
		if(isset($manufacturers['0-9']))
		{
			$this->data['manufacturers_numbers'] = $manufacturers['0-9'];
			unset($manufacturers['0-9']);
		}
		
		$manufacturers = array_values($manufacturers);

		$manufacturers_rows = array();
		$j = 1;
		//print_r($manufacturers);
		for($i = 0; $i< count($manufacturers); $i++)
		{
			$manufacturers_rows[$j]['header'][]= $manufacturers[$i]['letter'];
			
			foreach($manufacturers[$i]['manufacturers'] as $mf)
			{
				//print_r($mf);
				$manufacturers_rows[$j]['manufacturers'][]= $mf;
			}
			if(($i+1)%3 == 0)
			{
				$j++;
			}
		}

		//print_r($manufacturers_rows);
		
		$this->data['manufacturers_list']  = $manufacturers_rows;

		$this->data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/manufacturer_list.tpl';
		} else {
			$this->template = 'default/template/product/manufacturer_list.tpl';
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

	public function info() {
		$this->language->load('product/manufacturer');

		$this->load->model('catalog/manufacturer');

		$this->load->model('catalog/product');

		$this->load->model('tool/image'); 

		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = (int)$this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		} 

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		} 

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		} 

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array( 
			'text'      => $this->language->get('text_brand'),
			'href'      => $this->url->link('product/manufacturer'),
			'separator' => $this->language->get('text_separator')
		);

		$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

		if ($manufacturer_info) {
			$this->document->setTitle($manufacturer_info['name']);
			$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}	

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['breadcrumbs'][] = array(
				'text'      => $manufacturer_info['name'],
				'href'      => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url),
				'separator' => $this->language->get('text_separator')
			);
			
			$this->load->model('account/follow');
			if ($this->customer->isLogged()) 
			{
				if($this->model_account_follow->checkFollow($manufacturer_id, $this->customer->getId()))
				{
					$this->data['state'] = "unfollow";
				}
				else
				{
					$this->data['state'] = "follow";
				}
			}
			else
			{
				$this->data['state'] = "";	
			}
			
			$this->data['followers_count'] = $this->model_account_follow->getManufacturerFollowersCount($manufacturer_id);
			
                                                        if ($this->data['followers_count'] < 100 ) {
                                                            $this->data['followers_count'] = strlen($manufacturer_info['name']) * 9;
                                                        }
                        
			
			$this->data['bgimage'] = "image/".$manufacturer_info['bgimage'];
			
			if($manufacturer_info['image']) 
			{
				$this->data['image'] = $this->model_tool_image->resize($manufacturer_info['image'], 218, 215);
			} else {
				$this->data['image'] = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
			}

			$this->data['manufacturer_description'] = $manufacturer_info['manufacturer_description'];
			
			
			$filter = $this->model_catalog_manufacturer->getManufacturerFilter($manufacturer_id);
			
			$this->data['categories_list'] = '';
			
			if(isset($this->request->get['category']))
			{
				$selected_category = (int) $this->request->get['category'];
			}
			else
			{
				$selected_category = 0;
			}
			
			$selected ='';
			if($selected_category == 0)
			{
				$selected = 'checked="checked"';
			}
			
			$this->data['filter_options']['categories_list'] = '<li class="light_font"> 
											<input type="radio" name="category" id="wAllCategories" '.$selected.' value="0">
											<label class="filter-label" for="wAllCategories">
												All categories
											</label>
										</li>';	
			
			foreach($filter['categories'] as $cat)
			{
				$selected ='';
				if($cat['category_id'] == $selected_category )
				{
					$selected = 'checked="checked"';
				}

				$this->data['filter_options']['categories_list'] .= '<li class="light_font"> 
								<input type="radio" name="category" id="w'.$cat['name'].'" '.$selected.' value="'.$cat['category_id'].'">
								<label class="filter-label" for="w'.$cat['name'].'">
									'.$cat['name'].'
								</label>
							</li>';				
			}
			
			$category = array();
			if(isset($this->request->get['category']))
			{
				$category[] = (int)$this->request->get['category'];

			}

			if(isset($this->request->get['price_low']))
			{
				$this->data['filter_options']['price']['price_low'] = (int)$this->request->get['price_low'];
			}
			else
			{
				$this->data['filter_options']['price']['price_low'] = 0;	
			}
			
			if(isset($this->request->get['price_top']))
			{
				$this->data['filter_options']['price']['price_top'] = (int)$this->request->get['price_top'];
			}
			else
			{
				$this->data['filter_options']['price']['price_top'] = $filter['max_price'];	
			}

			$this->data['filter_options']['price']['max_price'] = $filter['max_price'];
			
			
			$this->data['filter_options']['month_list'] = $filter['month_list'];	
			$this->data['filter_options']['years_list'] = $filter['years_list'];	
			
			
			if(isset($this->request->get['rd_year']))
			{
				$this->data['filter_options']['rd_year'] = (int)$this->request->get['rd_year'];
			}
			else
			{
				$this->data['filter_options']['rd_year'] = '';	
			}
			
			if(isset($this->request->get['rd_month']))
			{
				$this->data['filter_options']['rd_month'] = (int)$this->request->get['rd_month'];
			}
			else
			{
				$this->data['filter_options']['rd_month'] = '';	
			}
			
			
			$this->data['mid'] = $manufacturer_id;
			$this->data['manufacturer_href'] = $this->url->link('product/manufacturer/info', 'manufacturer_id='.$manufacturer_id);
			$this->data['heading_title'] = $manufacturer_info['name'];
			$this->data['text_empty'] = $this->language->get('text_empty');
			$this->data['text_quantity'] = $this->language->get('text_quantity');
			$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$this->data['text_model'] = $this->language->get('text_model');
			$this->data['text_price'] = $this->language->get('text_price');
			$this->data['text_tax'] = $this->language->get('text_tax');
			$this->data['text_points'] = $this->language->get('text_points');
			$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$this->data['text_display'] = $this->language->get('text_display');
			$this->data['text_list'] = $this->language->get('text_list');
			$this->data['text_grid'] = $this->language->get('text_grid');			
			$this->data['text_sort'] = $this->language->get('text_sort');
			$this->data['text_limit'] = $this->language->get('text_limit');

			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_wishlist'] = $this->language->get('button_wishlist');
			$this->data['button_compare'] = $this->language->get('button_compare');
			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['compare'] = $this->url->link('product/compare');

			$this->data['products'] = array();

			$data = array(
				'filter_manufacturer_id' => $manufacturer_id, 
				'sort'                   => $sort,
				'order'                  => $order,
				'start'                  => ($page - 1) * $limit,
				'limit'                  => $limit,
				
				/*--------------- Search params ----------------*/
				'price_top'              => $this->data['filter_options']['price']['price_top'],
				'price_low'              => $this->data['filter_options']['price']['price_low'],
				'rd_year'              => $this->data['filter_options']['rd_year'],
				'rd_month'              => $this->data['filter_options']['rd_month'],

				
				
			);
			
			$data['filter_category_id']  = 0;
			if(isset($this->request->get['category']) && $this->request->get['category'] !=0)
			{
				$data['filter_category_id']  = (int)$this->request->get['category'];
				$data['filter_sub_category'] = true;
				$data['filter_category_ids_list']	= $category;
			}
			
			$product_total = $this->model_catalog_product->getTotalProducts($data);

			$results = $this->model_catalog_product->getProducts($data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('no_image.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
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

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				$this->data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $result['rating'],
					'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'        => $this->url->link('product/product', '&manufacturer_id=' . $result['manufacturer_id'] . '&product_id=' . $result['product_id'] . $url)
				);
			}

			$url = '';

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC' . $url)
			); 

			if ($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=DESC' . $url)
				); 

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=ASC' . $url)
				);
			}

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.model&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$this->data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value){
				$this->data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
		
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('product/manufacturer/info','manufacturer_id=' . $this->request->get['manufacturer_id'] .  $url . '&page={page}');

			//$this->data['pagination'] = $pagination->render();
			$this->data['pagination'] = $pagination->renderCatalogPager();

			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;

			$this->data['continue'] = $this->url->link('common/home');
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/manufacturer_info.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/manufacturer_info.tpl';
			} else {
				$this->template = 'default/template/product/manufacturer_info.tpl';
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
		} else {
			$url = '';

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/category', $url),
				'separator' => $this->language->get('text_separator')
			);

			$this->document->setTitle($this->language->get('text_error'));

			$this->data['heading_title'] = $this->language->get('text_error');

			$this->data['text_error'] = $this->language->get('text_error');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
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
	
	
	public function getDesignersByName()
	{
		$this->load->model('catalog/manufacturer');
		$params = array();
		$manufacturers_list = "";
		
		if (isset($this->request->get['designer_name'])) 
		{
			$params['name'] = $this->db->escape($this->request->get['designer_name']);
		}

		if (isset($this->request->get['category'])) 
		{
			$params['category'] = implode(",", $this->request->get['category']);
		}
		
		$manufacturers = $this->model_catalog_manufacturer->getManufacturersList($params);	

		foreach($manufacturers as $m)
		{
			$manufacturers_list .= '<li><a href="index.php?route=product/manufacturer/info&manufacturer_id='.$m['manufacturer_id'].'">'.$m['name'].'</a></li>';	
		}
		
		print $manufacturers_list;
	}
}
?>