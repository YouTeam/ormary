<?php  
class ControllerModuleCategory extends Controller {
	protected function index($setting) {
		$this->language->load('module/category');

		$this->data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if($this->request->get['route'] == 'product/category')
		{
			if (isset($parts[0])) {
				$this->data['category_id'] = $parts[0];
			} else {
				$this->data['category_id'] = 0;
			}
	
			if (isset($parts[1])) {
				$this->data['child_id'] = $parts[1];
			} else {
				$this->data['child_id'] = 0;
			}
	
			$this->load->model('catalog/category');
	
			$this->load->model('catalog/product');
	
			$this->data['categories'] = array();
	
			$categories = $this->model_catalog_category->getCategories(0);
	
			
			foreach ($categories as $category) {
				$total = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category['category_id']));
	
				$children_data = array();
	
				$children = $this->model_catalog_category->getCategories($category['category_id']);
	
				foreach ($children as $child) {
					$data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);
	
					$product_total = $this->model_catalog_product->getTotalProducts($data);
	
					$total += $product_total;
	
					$children_data[] = array(
						'category_id' => $child['category_id'],
						'name'        => $child['name'],// . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
						'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])	
					);		
				}
	
				$this->data['categories'][] = array(
					'category_id' => $category['category_id'],
					'name'        => $category['name'],// . ($this->config->get('config_product_count') ? ' (' . $total . ')' : ''),
					'children'    => $children_data,
					'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
				);	
			}	
			
					
			$this->data['filter_options'] = $this->model_catalog_product->getFilterOptions($this->data['category_id']);
		}


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/category.tpl';
		} else {
			$this->template = 'default/template/module/category.tpl';
		}

		$this->render();
	}
	
	
	public function getDesignersByName() 
	{
		$this->load->model('catalog/manufacturer');
		if(isset($this->request->get['dname']))
		{
			print $this->model_catalog_manufacturer->getManufacturersByName($this->request->get['dname']);
		}
	}
	
	public function getDesignersByNameAndCategory() 
	{
		$this->load->model('catalog/manufacturer');
		if(isset($this->request->get['dname']) && isset($this->request->get['category']))
		{
			print $this->model_catalog_manufacturer->getManufacturersByNameAndCategory($this->request->get['dname'], $this->request->get['category']);
		}
		elseif (isset($this->request->get['dname']))
		{
			print $this->model_catalog_manufacturer->getManufacturersByName($this->request->get['dname']);
		}
	}
	
}


/*

		foreach ($categories as $category) {
			$total = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category['category_id']));

			$children_data = array();

			$children = $this->model_catalog_category->getCategories($category['category_id']);

			foreach ($children as $child) 
			{
				$data = array(
					'filter_category_id'  => $child['category_id'],
					'filter_sub_category' => true
				);

				$product_total = $this->model_catalog_product->getTotalProducts($data);

				$total += $product_total;
				
				
				$child_subcategories = $this->model_catalog_category->getCategories($child['category_id']);
				
				foreach ($child_subcategories as $subcat) 
				{
					if(strtolower($subcat['name']) == 'mens')
					{
						$children_data_mens[] = array(
							'category_id' => $subcat['category_id'],
							'name'        => $child['name'],// . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
							'href'        => $this->url->link('product/category', 'path=' . $subcat['category_id'] . '_' . $subcat['category_id']));
					}
					else
					{
						$children_data_womens[] = array(
							'category_id' => $subcat['category_id'],
							'name'        => $child['name'],// . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
							'href'        => $this->url->link('product/category', 'path=' . $subcat['category_id'] . '_' . $subcat['category_id']));	
					}
				}
			}

			$this->data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'],// . ($this->config->get('config_product_count') ? ' (' . $total . ')' : ''),
				'children_mens'    => $children_data_mens,
				'children_womens'    => $children_data_womens,				
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);	
		}
*/
?>

