<?php
class ModelCatalogProduct extends Model {
	public function updateViewed($product_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . (int)$product_id . "'");
	}

	public function getProduct($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	

		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$customer_group_id . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'product_id'       => $query->row['product_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'upc'              => $query->row['upc'],
				'ean'              => $query->row['ean'],
				'jan'              => $query->row['jan'],
				'isbn'             => $query->row['isbn'],
				'mpn'              => $query->row['mpn'],
				'location'         => $query->row['location'],
				'quantity'         => $query->row['quantity'],
				'stock_status'     => $query->row['stock_status'],
				'image'            => $query->row['image'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
				'special'          => $query->row['special'],
				'reward'           => $query->row['reward'],
				'points'           => $query->row['points'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'length_class_id'  => $query->row['length_class_id'],
				'subtract'         => $query->row['subtract'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed'],
				'featured'    	   => $query->row['featured'],
			);
		} else {
			return false;
		}
	}

	public function getProducts($data = array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	

		$sql = "SELECT p.product_id, p.price, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special"; 


		if(!isset($data['filter_category_id']))
		{
			$data['filter_category_id'] = 0;
		} 

		if($data['filter_category_id'] != 0)
		{
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";			
				} else {
					$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
				}
	
				if (!empty($data['filter_filter'])) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
				} else {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
				}
			} else {
				$sql .= " FROM " . DB_PREFIX . "product p";
			}
	
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
	
	
	
			if(!empty($data['filter_category_ids_list']) && count($data['filter_category_ids_list']) != 0)
			{
				$sql .= " AND p2c.category_id IN (" .implode(', ', $data['filter_category_ids_list']). ") ";		
			}
			elseif (!empty($data['filter_category_id']) && $data['filter_category_id'] !=0) 
			{
				if (!empty($data['filter_sub_category'])) {
					$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";	
				} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";			
				}	
	
				if (!empty($data['filter_filter'])) {
					$implode = array();
	
					$filters = explode(',', $data['filter_filter']);
	
					foreach ($filters as $filter_id) {
						$implode[] = (int)$filter_id;
					}
	
					$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";				
				}
			}	
		}
		else
		{
			$sql .= " FROM " . DB_PREFIX . "product p";
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";	
		}
		
		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}	

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}		

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}		

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		if (!empty($data['featured'])) {
			$sql .= " AND p.featured = " . (int)$data['featured'] . "";
		}

		$sql .= " GROUP BY p.product_id";
		
		$sort_data = array(
			'pd.name',
			'p.model',
			'p.quantity',
			'p.price',
			'rating',
			'p.sort_order',
			'p.date_added'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} elseif ($data['sort'] == 'p.price') {
				$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";	
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
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

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			
			//$product_data[$result['product_id']] = $this->getProduct($result['product_id']); //-Old code
			
			//- New code
			$result['customer_group_id'] = $customer_group_id; 
			if($this->filterProduct($result, $data))
			{
                            
                                                                            $proddata = $this->getProduct($result['product_id']);
                                                                            $prod_images = $this->getProductImages(  $proddata['product_id']);
                                                                            $proddata['extraimages'] = $prod_images;
				$product_data[$result['product_id']] = $proddata;
                         
			}
			// - New code
		}
                
                

		return $product_data;
	}

	public function getProductSpecials($data = array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	

		$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";	
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
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

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) { 		
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getLatestProducts($limit) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	

		$product_data = $this->cache->get('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $customer_group_id . '.' . (int)$limit);

		if (!$product_data) { 
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getPopularProducts($limit) {
		$product_data = array();

		$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed, p.date_added DESC LIMIT " . (int)$limit);

		foreach ($query->rows as $result) { 		
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getBestSellerProducts($limit) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	

		$product_data = $this->cache->get('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit);

		if (!$product_data) { 
			$product_data = array();

			$query = $this->db->query("SELECT op.product_id, COUNT(*) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) { 		
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'). '.' . $customer_group_id . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getProductAttributes($product_id) {
		$product_attribute_group_data = array();

		$product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($product_attribute_group_query->rows as $product_attribute_group) {
			$product_attribute_data = array();

			$product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($product_attribute_query->rows as $product_attribute) {
				$product_attribute_data[] = array(
					'attribute_id' => $product_attribute['attribute_id'],
					'name'         => $product_attribute['name'],
					'text'         => $product_attribute['text']		 	
				);
			}

			$product_attribute_group_data[] = array(
				'attribute_group_id' => $product_attribute_group['attribute_group_id'],
				'name'               => $product_attribute_group['name'],
				'attribute'          => $product_attribute_data
			);			
		}

		return $product_attribute_group_data;
	}

	public function getProductOptions($product_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($product_option_query->rows as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();

				$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

				foreach ($product_option_value_query->rows as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'name'                    => $product_option_value['name'],
						'image'                   => $product_option_value['image'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']
					);
				}

				$product_option_data[] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => $product_option_value_data,
					'required'          => $product_option['required']
				);
			} else {
				$product_option_data[] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => $product_option['option_value'],
					'required'          => $product_option['required']
				);				
			}
		}

		return $product_option_data;
	}

	public function getProductDiscounts($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;		
	}

	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getProductRelated($product_id) {
            $limit = 5;
		$product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (m.manufacturer_id = p.manufacturer_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

                foreach ($query->rows as $result) { 
			$product_data[$result['related_id']] = $this->getProduct($result['related_id']);
		}
                
                
  if ( count ($query->rows) == 0) {
                                         $query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY RAND() DESC LIMIT " . (int)$limit);   

                                         foreach ($query->rows as $result) { 
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}
                                         
                                        }                                      
     
		

		return $product_data;
	}

	public function getProductLayoutId($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return false;
		}
	}

	public function getCategories($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}	

	public function getTotalProducts($data = array()) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	

		//$sql = "SELECT COUNT(DISTINCT p.product_id) AS total"; //- Old code
		
		//- New code
		$sql = "SELECT DISTINCT p.product_id, p.price, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special"; 
		 //- New code

		//print_r($data);
		
		if($data['filter_category_id'] != 0)
		{		
			if (!empty($data['filter_category_id'])) 
			{
				if (!empty($data['filter_sub_category'])) {
					$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";			
				} else {
					$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
				}
	
				if (!empty($data['filter_filter'])) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
				} else {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
				}
			} else {
				$sql .= " FROM " . DB_PREFIX . "product p";
			}
	
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
	
			
			
			if(!empty($data['filter_category_ids_list']) && count($data['filter_category_ids_list']) != 0)
			{
				$sql .= " AND p2c.category_id IN (" .implode(', ', $data['filter_category_ids_list']). ") ";		
			}
			elseif (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";	
				} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";			
				}	
	
				if (!empty($data['filter_filter'])) {
					$implode = array();
	
					$filters = explode(',', $data['filter_filter']);
	
					foreach ($filters as $filter_id) {
						$implode[] = (int)$filter_id;
					}
	
					$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";				
				}
			}
		}
		else
		{
			$sql .= " FROM " . DB_PREFIX . "product p";
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";	
		}
		
		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}	

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}		

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}		

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";				
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		if (!empty($data['featured'])) {
			$sql .= " AND p.featured = " . (int)$data['featured'] . "";
		}

		$query = $this->db->query($sql); 

		//return $query->row['total'];//-Old code
		
		//- New code
		$product_data = array();
		foreach ($query->rows as $result) 
		{
			$result['customer_group_id'] = $customer_group_id;
			if($this->filterProduct($result, $data))
			{
				$product_data[] = $result['product_id'];
			}
		}

		return count($product_data);
		//- New code
	}

	public function getProfiles($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		

		return $this->db->query("SELECT `pd`.* FROM `" . DB_PREFIX . "product_profile` `pp` JOIN `" . DB_PREFIX . "profile_description` `pd` ON `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " AND `pd`.`profile_id` = `pp`.`profile_id` JOIN `" . DB_PREFIX . "profile` `p` ON `p`.`profile_id` = `pd`.`profile_id` WHERE `product_id` = " . (int)$product_id . " AND `status` = 1 AND `customer_group_id` = " . (int)$customer_group_id . " ORDER BY `sort_order` ASC")->rows;

	}

	public function getProfile($product_id, $profile_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		

		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "profile` `p` JOIN `" . DB_PREFIX . "product_profile` `pp` ON `pp`.`profile_id` = `p`.`profile_id` AND `pp`.`product_id` = " . (int)$product_id . " WHERE `pp`.`profile_id` = " . (int)$profile_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$customer_group_id)->row;
	}

	public function getTotalProductSpecials() {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}		

		$query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;	
		}
	}
			
	private function filterProduct($product_info, $data)
	{
		if(!empty($data['price_low']) || !empty($data['price_top']))
		{
/*			if($product_info['special'] != '')
			{
				$price = $product_info['special'];
			}
			elseif($product_info['discount'] != '')
			{
				$price = $product_info['discount'];
			}
			elseif($product_info['price'])
			{
				$price = $product_info['price'];
			}*/

			$price = $product_info['price'];
			if(!empty($data['price_low']) && $price < $data['price_low'])
				return false;
			if(!empty($data['price_top']) && $price > $data['price_top'])
				return false;
		}

		if(!empty($data['rd_year']))
		{
			$rd_top = $rd_low = "";
			
			if(!empty($data['rd_month']))
			{
				$date = "'".$data['rd_year']."-".$data['rd_month']."-01 00:00:00' AND '".$data['rd_year']."-".$data['rd_month']."-01 00:00:00' +INTERVAL 1 MONTH";
			}
			else
			{
				$date = "'".$data['rd_year']."-01-01 00:00:00' AND '".$data['rd_year']."-01-01 00:00:00' +INTERVAL 1 YEAR";
			}
			$result = $this->db->query("SELECT date_added FROM  " . DB_PREFIX ."product WHERE date_added BETWEEN ".$date." AND product_id = ".$product_info['product_id']);

			if($result->num_rows == 0)
			{	
				return false;	
			}
		}
		
		if(!empty($data['designer']) && $data['designer'] > -1)
		{
			$result = $this->db->query("SELECT p.* FROM " . DB_PREFIX ."product as p LEFT JOIN  " . DB_PREFIX ."manufacturer as m ON p.manufacturer_id  = m.manufacturer_id WHERE m.manufacturer_id = ".(int)$data['designer']." AND p.product_id = ".$product_info['product_id']);
			//m.name LIKE '".$data['dname']."' AND p.product_id = ".$product_info['product_id']);
			
			if($result->num_rows == 0)
			{	
				return false;	
			}
		}
		
		
		if(!empty($data['color']) && $data['color'] > -1)
		{
			$result = $this->db->query("SELECT p.* FROM " . DB_PREFIX ."product as p LEFT JOIN  " . DB_PREFIX ."product_option_value as o ON p.product_id  = o.product_id WHERE o.option_value_id = '".$data['color']."' AND p.product_id = ".$product_info['product_id']);
			
			if($result->num_rows == 0)
			{	
				return false;	
			}
		}
		
		if(!empty($data['size']) && $data['size'] > -1)
		{
			$result = $this->db->query("SELECT p.* FROM " . DB_PREFIX ."product as p LEFT JOIN  " . DB_PREFIX ."product_option_value as o ON p.product_id  = o.product_id WHERE o.option_value_id = '".$data['size']."' AND p.product_id = ".$product_info['product_id']);
			
			if($result->num_rows == 0)
			{	
				return false;	
			}
		}		
				
		return true;
	}
	
	public function getMaxProductPrice()
	{
		$result = $this->db->query("SELECT MAX(price) as price FROM " . DB_PREFIX ."product");
		return $result->row['price'];			
	}
	
	public function getMaxProductPriceByCategory($catId)
	{
		$result = $this->db->query("SELECT MAX(price) as price FROM " . DB_PREFIX ."product p where p.product_id in (select ptc.product_id from ".DB_PREFIX."product_to_category ptc Where ptc.category_id = ".$catId.")");
		return $result->row['price'];			
	}
	
	public function getFilterOptions($category_id = 0)
	{
		$options = array('price' => '', 'month_list' => '', 'years_list' => '', 'colors_list' => '', 'sizes_list' => '' );
		
		if (isset($this->request->get['price_top'])) 
		{
			$options['price']['price_top'] = $this->request->get['price_top'];
		}
		else
		{
			if ($category_id > 0)
				$options['price']['price_top'] = ceil($this->getMaxProductPriceByCategory($category_id));
			else
				$options['price']['price_top'] = ceil($this->getMaxProductPrice());
		}
		if (isset($this->request->get['price_low'])) 
		{
			$options['price']['price_low'] = $this->request->get['price_low'];
		}
		else
		{
			$options['price']['price_low'] = 0;
		}
		
		if ($category_id > 0)
				$options['price']['max_price'] = ceil($this->getMaxProductPriceByCategory($category_id));
		else
				$options['price']['max_price'] = ceil($this->getMaxProductPrice());
		//$options['price']['max_price'] = ceil($this->getMaxProductPriceByCategory($category_id));
		
		
		
		$month_list = array( 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		
		$options['month_list']	.='<option value=""></option>';

		foreach($month_list as $key => $value)
		{
			if (isset($this->request->get['rd_month']) && (int)$this->request->get['rd_month'] == $key )
			{
				$options['month_list']	.='<option value="'.$key.'" selected>'.$value.'</option>';
			}
			else
			{
				$options['month_list']	.='<option value="'.$key.'">'.$value.'</option>';	
			}
		}
		
		
		$result = $this->db->query("SELECT EXTRACT(YEAR FROM MIN(date_added)) as year FROM " . DB_PREFIX ."product");
		$lowest_year = (int)$result->row['year'];
		$current_year = (int) date("Y");
		
		$options['years_list']	.='<option value=""></option>';
						
		for($i = $lowest_year; $i<= $current_year; $i++)
		{
			if (isset($this->request->get['rd_year']) && (int)$this->request->get['rd_year'] == $i )
			{
				$options['years_list']	.='<option value="'.$i.'" selected>'.$i.'</option>';
			}
			else
			{
				$options['years_list']	.='<option value="'.$i.'">'.$i.'</option>';	
			}	
		}

		$options['designers_list'] = "";
		if ($category_id > 0)
			$designers = $this->db->query("SELECT m.* FROM " . DB_PREFIX . "manufacturer m WHERE m.manufacturer_id in (select p.manufacturer_id from ".DB_PREFIX."product p left join ".DB_PREFIX."product_to_category ptc on p.product_id = ptc.product_id WHERE ptc.category_id = ".$category_id.") ORDER by name");//WHERE name LIKE '".$this->db->escape($this->request->get['designer_name'])."%'
		else
			$designers = $this->db->query("SELECT m.* FROM " . DB_PREFIX . "manufacturer m ORDER BY name");
		
		if(isset($this->request->get['designer']) && $this->request->get['designer'] != '')
		{
			
			
			if( $this->request->get['designer'] == -1){
				$options['designers_list'] .='<li class="">
										<input type="radio" name="designer" id="dalldesigners" value="-1" checked="checked">
										<label class="filter-label" for="dalldesigners">All designers</label></li>';
										$options['designer_name'] = "";	 
										}
			else
				$options['designers_list'] .='<li class="">
										<input type="radio" name="designer" id="dalldesigners" value="-1" >
										<label class="filter-label" for="dalldesigners">All designers</label></li>';
			
			foreach($designers->rows as $d)
			{
				if(isset($this->request->get['designer']) && $d['manufacturer_id'] == (int)$this->request->get['designer'])
				{
					$checked = 'checked="checked"';	
					$options['designer_name'] = $d['name'];
				}
				else
				{
						$checked = '';
				}
				$options['designers_list'] .='<li class="">
										<input type="radio" name="designer" id="d'.$d['manufacturer_id'].'" value="'.$d['manufacturer_id'].'" '.$checked.'>
										<label class="filter-label" for="d'.$d['manufacturer_id'].'">
											'.$d['name'].'
										</label>
									</li>';	
				
			}
		}
		else
		{
			//$designers = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m ORDER by name");
			$options['designers_list'] .='<li class="">
										<input type="radio" name="designer" id="dalldesigners" value="-1" checked="checked">
										<label class="filter-label" for="dalldesigners">All designers</label></li>';	
										
			foreach($designers->rows as $d)
			{
				$options['designers_list'] .='<li class="">
										<input type="radio" name="designer" id="d'.$d['manufacturer_id'].'" value="'.$d['manufacturer_id'].'">
										<label class="filter-label" for="d'.$d['manufacturer_id'].'">
											'.$d['name'].'
										</label>
									</li>';	
				
			}
			$options['designer_name'] = "";	 
		}
		
		if(isset($this->request->get['designer_name']) && !isset($options['designer_name']))
		{
			$options['designer_name'] = $this->request->get['designer_name'];
		}
			
		if ($category_id > 0)
			$option_colors = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_id = '13' and ov.option_value_id in (select option_value_id from ".DB_PREFIX."product_option_value pov1 INNER JOIN ".DB_PREFIX."product_to_category ptc1 on pov1.product_id = ptc1.product_id WHERE pov1.option_id = '13' and pov1.quantity > 0 and ptc1.category_id = ".$category_id.") ORDER BY ov.sort_order ASC");
		else
			$option_colors = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_id = '13' ORDER BY ov.sort_order ASC");
		if (isset($this->request->get['color']) &&  $this->request->get['color'] >= 0){
		$options['colors_list'] .= '<li class="light_font"> 
								<input type="radio" name="color" id="clallcolors" value="-1">
								<label class="filter-label" for="clallcolors">All colors</label>
							</li>';
		}
		else
		{
		$options['colors_list'] .= '<li class="light_font"> 
								<input type="radio" name="color" id="clallcolors" checked="checked" value="-1">
								<label class="filter-label" for="clallcolors">All colors</label>
							</li>';
		}
		foreach ($option_colors->rows as $option_value) 
		{
			if (isset($this->request->get['color']) && (int)$this->request->get['color'] == $option_value['option_value_id'] )
			{
				$options['colors_list'] .= '<li class="light_font"> 
								<input type="radio" name="color" id="cl'.strtolower($option_value['name']).'" checked="checked" value="'.$option_value['option_value_id'].'">
								<label class="filter-label" for="cl'.strtolower($option_value['name']).'">
									'.$option_value['name'].'
								</label>
							</li>';

				//$options['colors_list']	.='<li id="cl'.$option_value['option_value_id'].'"><span href="#" class="selected" title="'.$option_value['name'].'" style="background-image:url(image/'.$option_value['image'].')"></span></li>';
			}
			else
			{
				$options['colors_list'] .= '<li class="light_font"> 
								<input type="radio" name="color" id="cl'.strtolower($option_value['name']).'" value="'.$option_value['option_value_id'].'">
								<label class="filter-label" for="cl'.strtolower($option_value['name']).'">
									'.$option_value['name'].'
								</label>
							</li>';
				//$options['colors_list']	.='<li id="cl'.$option_value['option_value_id'].'"><span href="#" class="" title="'.$option_value['name'].'" style="background-image:url(image/'.$option_value['image'].')"></span></li>';
			}
		}
		
		if(isset($this->request->get['color']))
		{
			$options['colors_input_value'] = (int)$this->request->get['color'];
		}
		else
		{
			$options['colors_input_value'] = "";
		}

		
		if ($category_id > 0)
			$option_sizes = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_id = '14' and ov.option_value_id in (select option_value_id from ".DB_PREFIX."product_option_value pov1 INNER JOIN ".DB_PREFIX."product_to_category ptc1 on pov1.product_id = ptc1.product_id WHERE pov1.option_id = '14' and pov1.quantity > 0 and ptc1.category_id = ".$category_id.") ORDER BY ov.sort_order ASC");
		else
			$option_sizes = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_id = '14' ORDER BY ov.sort_order ASC");
		if (isset($this->request->get['size']) &&  $this->request->get['size'] >= 0){
		$options['sizes_list'] .= '<li class="light_font"> 
								<input type="radio" name="size" id="szallsizes" value="-1">
								<label class="filter-label" for="szallsizes">All sizes</label>
							</li>';
		}
		else
		{
		$options['sizes_list'] .= '<li class="light_font"> 
								<input type="radio" name="size" id="szallsizes" checked="checked" value="-1">
								<label class="filter-label" for="szallsizes">All sizes</label>
							</li>';
		}
		
		foreach ($option_sizes->rows as $option_value) 
		{
			if (isset($this->request->get['size']) && (int)$this->request->get['size'] == $option_value['option_value_id'] )
			{
				$options['sizes_list']	.='<li class="light_font">
            									<input type="radio" name="size" id="sz'.$option_value['option_value_id'].'" checked="checked" value="'.$option_value['option_value_id'].'">
												<label class="filter-label" for="sz'.$option_value['option_value_id'].'">
													'.$option_value['name'].'
												</label>
											</li>';
			}
			else
			{
				$options['sizes_list']	.='<li class="light_font">
								<input type="radio" name="size" id="sz'.$option_value['option_value_id'].'" value="'.$option_value['option_value_id'].'">
								<label class="filter-label" for="sz'.$option_value['option_value_id'].'">
									'.$option_value['name'].'
								</label>
							</li>';
			}
		}
		
		
		$parts =array();
		$subcategory = 0;
		if(isset($this->request->get['path'])) 
		{
			$parts = explode('_', (string)$this->request->get['path']);
			
				
			if(isset($this->request->get['featured'])) 
			{				
				$categories = $this->model_catalog_category->getCategories(0);
				$subcategory = $parts[0];
				$category = 0;
			}
			else
			{			
				$category = $parts[0];				
				if(isset($parts[1]))
				{
					$subcategory = $parts[1];
				}
				$categories = $this->model_catalog_category->getCategories($parts[0]);
			}
		} 
		else 
		{
			$category = 0;
			$categories = $this->model_catalog_category->getCategories(0);
		}

		$categories_list = '';
		if($category != 0)
		{
			$current_category = $this->model_catalog_category->getCategory($category);
		}
		else
		{
			$current_category = array('name' => 'categories');
		}
		
		/*if(isset($subcategory))*/
		
		//print_r( $current_category);
		
		if($subcategory == 0 || $current_category == $subcategory)
		{
			$categories_list .= '<li class="light_font"> 
								<input type="radio" name="path" id="wAll'.strtolower($current_category['name']).'" checked="checked" value="'.$category.'">
								<label class="filter-label" for="wAll'.strtolower($current_category['name']).'">
									All '.strtolower($current_category['name']).'
								</label>
							</li>';
		}
		else
		{
			$categories_list .= '<li class="light_font"> 
								<input type="radio" name="path" id="wAll'.strtolower($current_category['name']).'"  value="'.$category.'">
								<label class="filter-label" for="wAll'.strtolower($current_category['name']).'">
									All '.strtolower($current_category['name']).'
								</label>
							</li>';	
		}
		
		$category_prefix = '';
		if($category != 0 && !isset($this->request->get['featured']))
		{
			$category_prefix = $category.'_';
		}
		
		foreach($categories as $cat)
		{
			if($cat['category_id'] == $subcategory)
			{
				$categories_list .= '<li class="light_font"> 
								<input type="radio" name="path" id="w'.$cat['name'].'" checked="checked" value="'.$category_prefix.$cat['category_id'].'">
								<label class="filter-label" for="w'.$cat['name'].'">
									'.$cat['name'].'
								</label>
							</li>';				
			}
			else
			{
				$categories_list .= '<li class="light_font"> 
								<input type="radio" name="path" id="w'.$cat['name'].'" value="'.$category_prefix.$cat['category_id'].'">
								<label class="filter-label" for="w'.$cat['name'].'">
									'.$cat['name'].'
								</label>
							</li>';	
			}
		}
		
		$options['categories_list'] = $categories_list;
		$options['category_id'] = $category_id;


		if(isset($this->request->get['featured']))
		{
			$options['featured'] = 1;
		}

		$options['clear_filter'] = 'index.php?route=product/category&path='.$category;
		
		
		return $options;	
	}
	
	
	public function checkWishListCollection($product_id, $collection_id = 0)
	{
		//$result = $this->db->query("SELECT * FROM " . DB_PREFIX."wishlist_product_to_collection WHERE customer_id =".(int)$this->customer->getId()." AND product_id=".(int)$product_id." AND collection_id=".(int)$collection_id);
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX."wishlist_product_to_collection WHERE customer_id =".(int)$this->customer->getId()." AND product_id=".(int)$product_id);
		if($result->num_rows > 0)
		{
			return true;	
		}
		else
		{
			return false;	
		}
	}
	
	public function addToWishListCollection($product_id, $collection_id = 0)
	{
		//if($this->checkWishListCollection($product_id, $collection_id))
		/*if($this->checkWishListCollection($product_id))
		{
			$this->db->query("UPDATE " . DB_PREFIX . "wishlist_product_to_collection SET collection_id=".(int)$collection_id." WHERE customer_id =".(int)$this->customer->getId()." AND product_id=".(int)$product_id);
		}
		else
		{
                 * */
            
                 $r = $this->db->query("SELECT * FROM " . DB_PREFIX . "wishlist_product_to_collection WHERE customer_id=".(int)$this->customer->getId()." AND collection_id='".(int)$collection_id."' AND product_id=".(int)$product_id.""); 
                        if (count ( $r->row) > 0) {
                            return false;
                        } else {
            		$this->db->query("INSERT INTO " . DB_PREFIX . "wishlist_product_to_collection SET customer_id =".(int)$this->customer->getId().", product_id=".(int)$product_id.", collection_id=".(int)$collection_id);
  
                            }
                        
            

	
                        
                        
	/*
         	}
         */
			
		/*if($collection_id !=0)
		{
			$this->db->query("DELETE FROM " . DB_PREFIX . "wishlist_product_to_collection WHERE customer_id =".(int)$this->customer->getId()." AND product_id=".(int)$product_id." AND collection_id=0");	
		}
	
*/		//$this->db->query("UPDATE " . DB_PREFIX . "wishlist_product_to_collection SET collection_id=".(int)$collection_id)." WHERE customer_id =".(int)$this->customer->getId()." AND product_id=".(int)$product_id;
		
	}
	
	public function removeFromWishListCollection($product_id, $collection_id = 0)
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "wishlist_product_to_collection WHERE customer_id =".(int)$this->customer->getId()." AND product_id=".(int)$product_id." AND collection_id=".(int)$collection_id);
	}
	
	
	public function addWishListCollection($collection_name)
	{
		$this->db->query("INSERT INTO " . DB_PREFIX . "wishlist_collection SET customer_id =".(int)$this->customer->getId().", collection_name='".$this->db->escape($collection_name)."'"); 
	}
	
        public function getProductCountByFeatured ($id) {
       
            $sql = "SELECT count(*) as c FROM " . DB_PREFIX . "product_to_category as pc";
            $sql .= " LEFT JOIN " . DB_PREFIX . "product as p ON p.product_id = pc.product_id " ;
            $sql .= " WHERE";

            if ($id){
            $sql .= " pc.category_id=".(int)$id." AND ";
            }
            $sql .= " p.status = 1";
            $sql .= " AND p.featured = 1";
            
            $result = $this->db->query($sql); 
		return $result->row['c'];
        }
        
        public function getProductCountByCategory ($id) {
            
            $sql = "SELECT count(*) as c FROM " . DB_PREFIX . "product_to_category as pc";
            $sql .= " LEFT JOIN " . DB_PREFIX . "product as p ON p.product_id = pc.product_id " ;
            $sql .= " WHERE pc.category_id=".(int)$id." AND p.status = 1";
            
            $result = $this->db->query($sql); 
		return $result->row['c'];
            
            return 20;
        }
	public function getWishListCollectionProductsCount($collection_id)
	{
		$result = $this->db->query("SELECT count(*) as c FROM " . DB_PREFIX . "wishlist_product_to_collection WHERE customer_id=".(int)$this->customer->getId()." AND collection_id='".(int)$collection_id."'"); 
		return $result->row['c'];
	}
	
	public function removeWishListCollection($collection_id)
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "wishlist_collection WHERE customer_id =".(int)$this->customer->getId()." AND collection_id='".(int)$collection_id."'"); 
		$this->db->query("UPDATE " . DB_PREFIX . "wishlist_product_to_collection SET collection_id =0 WHERE customer_id=".(int)$this->customer->getId()." AND collection_id='".(int)$collection_id."'"); 
	}
	
	public function getWishListCollections()
	{
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "wishlist_collection WHERE customer_id =".(int)$this->customer->getId()); 
		
		$result->rows['unsorted'] = array('collection_id' => 0, 'customer_id' => (int)$this->customer->getId(), 'collection_name' => 'Everything');
		foreach($result->rows as &$cl)
		{
			$cl['count'] = $this->getWishListCollectionProductsCount($cl['collection_id']);
		}
		
		return $result->rows;
	}
	
	public function getWishListCollectionProducts($collection_id)
	{
		$products = array();
		$result = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "wishlist_product_to_collection WHERE customer_id =".(int)$this->customer->getId()." AND collection_id=".(int)$collection_id); 
		foreach($result->rows as $p)
		{
			$products[] = $p['product_id'];
		}
		return $products;
	}
	
	public function getWishListProducts()
	{
		$products = array();
		$result = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "wishlist_product_to_collection WHERE customer_id =".(int)$this->customer->getId()); 
		foreach($result->rows as $p)
		{
			$products[] = $p['product_id'];
		}
		return $products;
	}
	
	
	public function getRecommendationsStyle()
	{
/*		$styles = $all_styles = $all_user_styles = $top_users_styles = array();
		$result_wishlist = $this->db->query("SELECT m.style_id FROM " . DB_PREFIX . "product as p LEFT JOIN " . DB_PREFIX . "wishlist_product_to_collection as w ON p.product_id = w.product_id LEFT JOIN " . DB_PREFIX . "manufacturer as m ON p.manufacturer_id = m.manufacturer_id WHERE w.customer_id =".(int)$this->customer->getId()); 
		
			
		$result_followed = $this->db->query("SELECT m.style_id FROM " . DB_PREFIX . "manufacturer as m LEFT JOIN " . DB_PREFIX . "follows as f ON m.manufacturer_id = f.mid WHERE f.uid =".(int)$this->customer->getId()); 
		
		$all_styles = array_merge($result_wishlist->rows, $result_followed->rows);
		
		foreach($all_styles as $s)
		{
			$all_user_styles[] = $s['style_id']; 
		}
		
		$styles = array_count_values($all_user_styles);
		arsort($styles);

		$i=0;
		foreach($styles as $sid => $count)
		{
			if($i==3)
			{
				break;	
			}
			else
			{
				$top_users_styles[] = $sid;
				$i++;
			}
		}

		return $top_users_styles;*/
		
		$user_styles = $followed_styles = $designers_styles =  $wishlist_styles = $products_styles = array();
		
		
		$result_followed = $this->db->query("SELECT m.style_id FROM " . DB_PREFIX . "manufacturer as m LEFT JOIN " . DB_PREFIX . "follows as f ON m.manufacturer_id = f.mid WHERE f.uid =".(int)$this->customer->getId()); 
		foreach($result_followed->rows as $f)
		{
			$followed_styles[] = $f['style_id']; 
		}
		$designers_styles = array_count_values($followed_styles);
		arsort($designers_styles);
		$user_styles['designers_styles'] = $designers_styles;

		
		$result_wishlist = $this->db->query("SELECT o.option_value_id FROM " . DB_PREFIX . "product_option_value as o WHERE o.product_id IN (SELECT w.product_id FROM " . DB_PREFIX . "wishlist_product_to_collection as w WHERE w.customer_id =".(int)$this->customer->getId().") AND o.option_id IN (SELECT o.option_id FROM " . DB_PREFIX . "option as o WHERE o.use_in_engine = 1 )");
		
	//	$result_wishlist = $this->db->query("SELECT o.option_value_id FROM " . DB_PREFIX . "product_option_value as o WHERE o.product_id IN (SELECT w.product_id FROM " . DB_PREFIX . "wishlist_product_to_collection as w WHERE w.customer_id =".(int)$this->customer->getId().")");
		
		//print_r($result_wishlist->rows);
		
		foreach($result_wishlist->rows as $w)
		{
			$wishlist_styles[] = $w['option_value_id']; 
		}
		$products_styles = array_count_values($wishlist_styles);
		arsort($products_styles);
		$user_styles['products_styles'] = $products_styles;
		
		return $user_styles;
	}
	
	
	public function getRecommendationsCategory()
	{
		$categories = $all_user_categories = $top_users_categories = array();
		$result_wishlist = $this->db->query("SELECT p2c.category_id FROM " . DB_PREFIX . "product as p LEFT JOIN " . DB_PREFIX . "wishlist_product_to_collection as w ON p.product_id = w.product_id LEFT JOIN " . DB_PREFIX . "product_to_category as p2c ON p.product_id = p2c.product_id WHERE w.customer_id =".(int)$this->customer->getId()); 

		foreach($result_wishlist->rows as $c)
		{
			$all_user_categories[] = $c['category_id']; 
		}

		$categories = array_count_values($all_user_categories);
		arsort($categories);
		return $categories;
		
/*		$i=0;
		foreach($categories as $cid => $count)
		{
			if($i==3)
			{
				break;	
			}
			else
			{
				$top_users_categories[] = $cid;
				$i++;
			}
		}

		return $top_users_categories;*/
	}
	
	
	public function getRecommendationsProducts()
	{
		$products = $products_styles = array();
		$styles =  $this->getRecommendationsStyle();
		$categories =  $this->getRecommendationsCategory();

		if(!empty($categories) && !empty($styles))
		{			
			$wishlist = implode(',', $this->getWishListProducts());
	
			//$result_products = $this->db->query("SELECT p.product_id, m.style_id, p2c.category_id FROM " . DB_PREFIX . "product as p LEFT JOIN " . DB_PREFIX . "manufacturer as m ON p.manufacturer_id = m.manufacturer_id LEFT JOIN " . DB_PREFIX . "product_to_category as p2c ON p.product_id = p2c.product_id WHERE p2c.category_id IN (".implode(",", array_keys($categories)).") AND p.product_id NOT IN (".$wishlist.") AND m.style_id IN (".implode(",", array_keys($styles['designers_styles'])).") AND p.status = 1 ORDER BY p.date_added DESC");
			
			$result_products = $this->db->query("SELECT p.product_id, m.style_id, p2c.category_id FROM " . DB_PREFIX . "product as p LEFT JOIN " . DB_PREFIX . "manufacturer as m ON p.manufacturer_id = m.manufacturer_id LEFT JOIN " . DB_PREFIX . "product_to_category as p2c ON p.product_id = p2c.product_id WHERE p2c.category_id IN (".implode(",", array_keys($categories)).") AND p.product_id NOT IN (".$wishlist.") AND p.status = 1 ORDER BY p.date_added DESC");
	
				
			foreach($result_products->rows as &$p)
			{			
				$product_style_points = 0;
				
				$product_options = $this->db->query("SELECT o.option_value_id FROM " . DB_PREFIX . "product as p LEFT JOIN " . DB_PREFIX . "product_option_value as o ON p.product_id = o.product_id  WHERE p.product_id = ". $p['product_id']);
				
				foreach($product_options->rows as $op)
				{
					if(isset($styles['products_styles'][$op['option_value_id']]))
					{
						$product_style_points += $styles['products_styles'][$op['option_value_id']]	;
					}
				}
				
				if($product_style_points !=0)
				{
					$product_style_points +=  $styles['designers_styles'][$p['style_id']];
					
					$products_styles[$product_style_points][$p['category_id']][] = $p['product_id'];
				}
			}			
			
			$categories_reversed = array_flip(array_keys($categories));
			
	
			
			foreach($products_styles as $style_value => $categories)
			{
				foreach($categories as $category_id => $products_list)
				{
					foreach($products_list as $order => $product_id)
					{
						$order_value = (1000 - (int)$style_value)*10000 + (int)$order*1000 + (500+ (int)$categories_reversed[$category_id]) ;
						$products[$order_value] = $this->getProduct($product_id);;
	
					}
				}
			}	
				
				
			sort($products);
		
		
		}
	
		return $products;
	}
        
        
        public function checkIfProductAlreadyInCollection ($product_id, $collection_id = 0) {
                        $r = $this->db->query("SELECT * FROM " . DB_PREFIX . "wishlist_product_to_collection WHERE customer_id=".(int)$this->customer->getId()." AND collection_id='".(int)$collection_id."' AND product_id=".(int)$product_id.""); 
                        if (count ( $r->row) > 0) {
                            return 1;
                        } else {
                            return 0;
                        }
                        
          
        }
public function getManufacturerId($product_id)
		{
			 $manufacturer = $this->db->query("SELECT manufacturer_id FROM " . DB_PREFIX . "product WHERE product_id=".(int)$product_id); 
			 if ($manufacturer->num_rows)
			 {
			 	return $manufacturer->row['manufacturer_id'];
			 }
			 else
			 {
				return false; 
			 }
		}
}
?>