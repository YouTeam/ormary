<?php
class ModelCatalogManufacturer extends Model {
	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m.manufacturer_id = '" . (int)$manufacturer_id . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
	
		return $query->row;	
	}
	
	public function getManufacturers($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			
			$sort_data = array(
				'name',
				'sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}				
					
			$query = $this->db->query($sql);
			
			return $query->rows;
		} else {
			$manufacturer_data = $this->cache->get('manufacturer.' . (int)$this->config->get('config_store_id'));
		
			if (!$manufacturer_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY name");
	
				$manufacturer_data = $query->rows;
			
				$this->cache->set('manufacturer.' . (int)$this->config->get('config_store_id'), $manufacturer_data);
			}

			return $manufacturer_data;
		}	
	} 
	
	public function getManufacturersByName($name) 
	{
		$designers_list = '';

		if($name != "")
		{
			$designers = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m WHERE name LIKE '".$this->db->escape($name)."%' ORDER BY name");
			foreach($designers->rows as $d)
			{
				$designers_list .='<li class="light_font">
										<input type="radio" name="designer" id="d'.$d['manufacturer_id'].'" value="'.$d['manufacturer_id'].'">
										<label class="filter-label" for="d'.$d['manufacturer_id'].'">
											'.$d['name'].'
										</label>
									</li>';	
			}
		}
		
		return $designers_list;
	}
	
	
	public function getManufacturersList($params = array()) 
	{
		$letters = range('A', 'Z');
		$digits = range(0, 9);
		
		$designers_list = array();

		$join = $where ="";
		
		if(isset($params['name']))
		{
			//$designers = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m WHERE name LIKE '".$this->db->escape($params['name'])."%' ORDER BY name");
			//return $designers->rows;
			$where .= " AND m.name LIKE '".$this->db->escape($params['name'])."%'";
		}
;

		if(isset($params['category']) && $params['category']!= 0)	
		{
			$join .= 'LEFT JOIN oc_product p ON (m.manufacturer_id = p.manufacturer_id) LEFT JOIN oc_product_to_category pc ON (p.product_id = pc.product_id)';
			
			$cat_ids =array();
			
			$manufacturers_ids = array();
			
			$categories_array = explode(',' ,$this->db->escape($params['category']));

			
			foreach($categories_array as $p)
			{
				$subcategory = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = ".$p);	
				if($subcategory->num_rows == 0)
				{
					$cat_ids[] = $p;
				}
				else
				{
					$scat_ids = array();
					foreach($subcategory->rows as $sc)
					{
						$scat_ids[] = $sc['category_id'];
					}
					
					if(count(array_intersect($scat_ids, $categories_array)) == 0)
					{
						$cat_ids = array_merge($cat_ids, $scat_ids);
					}
				}
			}	
			
			$where .= " AND pc.category_id IN (".implode(", ", $cat_ids).") ";
		}

		$results = $this->db->query("SELECT DISTINCT m.manufacturer_id , m.* FROM " . DB_PREFIX . "manufacturer m ".$join." WHERE 1=1 ".$where." ORDER BY name");	

		if(isset($params['name']))
		{
			return 	$results->rows;
		}

		
		for($i = 0; $i<count($letters); $i++)
		{
			$designers_list[$letters[$i]] = array('manufacturers' => array(), 'letter'=> $letters[$i]);
		}

		foreach ($results->rows as $result) {
			if (is_numeric(utf8_substr($result['name'], 0, 1))) {
				$key = '0-9';
			} else {
				$key = utf8_substr(utf8_strtoupper($result['name']), 0, 1);
			}

			if (!isset($this->data['manufacturers'][$key])) {
				$designers_list[$key]['letter'] = $key;
			}

			$designers_list[$key]['manufacturers'][] = array(
				'name' => $result['name'],
				'manufacturer_id' => $result['manufacturer_id'],
                                                                            'manufacturer_link' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
		
			);
		}

		return $designers_list;
	}
	
	
	public function getManufacturerCategoriesFilter()
	{
		$categories_list = array();
		$categories = $this->db->query("SELECT c.*, d.* FROM " . DB_PREFIX . "category as c LEFT JOIN " . DB_PREFIX . "category_description as d ON c.category_id = d.category_id WHERE c.parent_id = 0 ORDER BY name");
		
		$categories_list[0]['name'] = 'All categories';
		foreach($categories->rows as $c)
		{
			$categories_list[$c['category_id']]['name'] = $c['name'];
			$subcategories = $this->db->query("SELECT c.*, d.* FROM " . DB_PREFIX . "category as c LEFT JOIN " . DB_PREFIX . "category_description as d ON c.category_id = d.category_id WHERE c.parent_id = ".$c['category_id']." ORDER BY name");
			
			foreach($subcategories->rows as $sc)
			{
				$categories_list[$c['category_id']]['subcategories'][$sc['category_id']]['name'] = $sc['name'];
			}
		}
		return $categories_list;
	}
	
	
	public function getManufacturerFilter($manufacturer_id)
	{
		$filter =array();
		$categories_list = array();
		$cids = array();
		$manufacturer_categories = $this->db->query("SELECT DISTINCT pc.category_id as c FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category as pc ON p.product_id = pc.product_id WHERE manufacturer_id=".$manufacturer_id);
		
		foreach($manufacturer_categories->rows as $mc)
		{
			$cids[]	= $mc['c'];
		}


		if(count($cids) != 0)
		{
			$categories = $this->db->query("SELECT c.*, cd.* FROM " . DB_PREFIX . "category as c LEFT JOIN " . DB_PREFIX . "category_description as cd ON c.category_id = cd.category_id WHERE c.category_id IN (".implode(', ', $cids).") ORDER BY c.sort_order");
			$filter['categories'] = $categories->rows;
		}
		else
		{
			$filter['categories'] = array();
		}
		
		
		$result = $this->db->query("SELECT MAX(price) as price FROM " . DB_PREFIX ."product WHERE manufacturer_id=".$manufacturer_id );
		$filter['max_price'] =  ceil($result->row['price']);
	
		$month_list = array( 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		
		$filter['month_list'] ='<option value=""></option>';

		foreach($month_list as $key => $value)
		{
			if (isset($this->request->get['rd_month']) && (int)$this->request->get['rd_month'] == $key )
			{
				$filter['month_list']	.='<option value="'.$key.'" selected>'.$value.'</option>';
			}
			else
			{
				$filter['month_list']	.='<option value="'.$key.'">'.$value.'</option>';	
			}
		}

		$result = $this->db->query("SELECT EXTRACT(YEAR FROM MIN(date_added)) as year FROM " . DB_PREFIX ."product WHERE manufacturer_id=".$manufacturer_id);
		$lowest_year = (int)$result->row['year'];
		$current_year = (int) date("Y");
		
		$filter['years_list'] ='<option value=""></option>';
						
		for($i = $lowest_year; $i<= $current_year; $i++)
		{
			if (isset($this->request->get['rd_year']) && (int)$this->request->get['rd_year'] == $i )
			{
				$filter['years_list']	.='<option value="'.$i.'" selected>'.$i.'</option>';
			}
			else
			{
				$filter['years_list']	.='<option value="'.$i.'">'.$i.'</option>';	
			}	
		}

		return $filter;
	}

	public function getPopularManufacturersList()
	{
		
		$result = $this->db->query("SELECT m.*, 2*(SELECT COUNT(f.mid) as c FROM " . DB_PREFIX ."follows as f WHERE f.mid=m.manufacturer_id ) as count FROM " . DB_PREFIX ."manufacturer as m ORDER BY count DESC, m.style_id ASC");
		
		$this->load->model('tool/image');
		
		foreach($result->rows as $des)
		{
			$designers[$des['manufacturer_id']]['mid'] = $des['manufacturer_id'];
			$designers[$des['manufacturer_id']]['popularity'] = $des['count'];
			$designers[$des['manufacturer_id']]['name'] = $des['name'];	
			$designers[$des['manufacturer_id']]['style'] = $des['style_id'];	
			if($des['image'] !="")
			{
				$designers[$des['manufacturer_id']]['image'] = $this->model_tool_image->resize($des['image'], 215, 218);
			}
			else
			{
				$designers[$des['manufacturer_id']]['image'] = $this->model_tool_image->resize("no_image.png", 215, 218);
			}
			
			$designers[$des['manufacturer_id']]['liked'] = false;	
			
			$products = $this->db->query("SELECT p.*, (SELECT COUNT(w.product_id) as c FROM " . DB_PREFIX ."wishlist_product_to_collection as w WHERE w.product_id = p.product_id )+2*(SELECT COUNT(o.product_id) as cc FROM " . DB_PREFIX ."order_product as o WHERE o.product_id = p.product_id ) as popularity FROM " . DB_PREFIX ."product as p WHERE  manufacturer_id = ".$des['manufacturer_id']." ORDER BY popularity DESC LIMIT 0,10");
			
			foreach($products->rows as $product)
			{
				$designers[$des['manufacturer_id']]['images'][] = $this->model_tool_image->resize($product['image'], 150, 212); ;		
			}
		}

		$result = $this->db->query("SELECT p.product_id, p.manufacturer_id, 2*(SELECT COUNT(o.product_id) as order_count FROM " . DB_PREFIX ."order_product as o WHERE o.product_id=p.product_id )+(SELECT COUNT(w.product_id) as wishlist_count FROM " . DB_PREFIX ."wishlist_product_to_collection as w WHERE w.product_id=p.product_id ) as popularity FROM " . DB_PREFIX ."product as p");
		
		foreach($result->rows as $product)
		{
			if(in_array($product['manufacturer_id'], array_keys($designers)))
			{
				$designers[$product['manufacturer_id']]['popularity'] += $product['popularity'];
			}
		}
		
		//print_r($designers);
		
		$designers = array_values($designers);

		foreach ($designers as $key => $row) 
		{
  			$volume[$key]  = $row['popularity'];
   			$edition[$key] = $row['name'];
		}
		array_multisort($volume, SORT_DESC, $edition, SORT_ASC, $designers);
		
		return $designers;
	}
        
        
        public function getPopularManufacturersIds()
	{
		
		$result = $this->db->query("SELECT m.*, 2*(SELECT COUNT(f.mid) as c FROM " . DB_PREFIX ."follows as f WHERE f.mid=m.manufacturer_id ) as count FROM " . DB_PREFIX ."manufacturer as m ORDER BY count DESC, m.style_id ASC");
		
                                    $designers = array();
		
		foreach($result->rows as $des)
		{
                                        array_push($designers,$des['manufacturer_id']);
                                    }	
		return $designers;
	}
		
}
?>