<?php
class ModelAccountFollow extends Model {
	public function setFollowState($mid, $state) 
	{
		$this->load->model('account/customer');
		$customer_id = $this->customer->getId();
		
		if($state == "follow")
		{	
			$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "follows WHERE uid = " . $customer_id . " AND mid = " . $mid);
			if ($result->num_rows == 0)
			{
				$this->db->query("INSERT INTO " . DB_PREFIX . "follows SET uid = " . $customer_id . ", mid = " . $mid );	
			}
		}
		elseif($state == "unfollow")
		{
			$this->db->query("DELETE FROM " . DB_PREFIX . "follows WHERE uid = " . $customer_id . " AND mid = " . $mid );		
		}
		
		
		return $this->getManufacturerFollowersCount($mid);
	}

	public function checkFollow($mid, $uid)
	{
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "follows WHERE uid = " . $uid . " AND mid = " . $mid);
		if($result->num_rows != 0)
		{	
			return true;
		}
		else
		{
			return false;	
		}
	}
	
	public function getMyFollows()
	{
		$this->load->model('account/customer');
		
		return $this->db->query("SELECT f.*, m.* FROM " . DB_PREFIX . "follows as f LEFT JOIN " . DB_PREFIX . "manufacturer as m ON f.mid = m.manufacturer_id WHERE f.uid = " . $this->customer->getId() );
	}
	
	public function getMyFollowsIDs()
	{
		$this->load->model('account/customer');
		
		return $this->db->query("SELECT * FROM " . DB_PREFIX . "follows  WHERE uid = " . $this->customer->getId() );
	}
	
	public function getAllMyFashionfeedProd()
	{
		$this->load->model('catalog/product');
		
		$manufacturers_ids = $this->model_account_follow->getMyFollowsIDs();
		$products = $data = array();
		foreach($manufacturers_ids->rows as $mid)
		{
			$data['filter_manufacturer_id'] = $mid['mid'];
			$data['filter_category_id'] = 0;
			$products  = array_merge($products, $this->model_catalog_product->getProducts($data));
		}
		return $products;
		
	}
	
	public function getNewMyFashionfeedProd()
	{
		$this->load->model('catalog/product');
		
		$manufacturers_ids = $this->model_account_follow->getMyFollowsIDs();
		$products = $data = array();
		foreach($manufacturers_ids->rows as $mid)
		{
			$data['filter_manufacturer_id'] = $mid['mid'];
			$data['filter_category_id'] = 0;
			$data['sort'] = "p.date_added";
			$data['order'] = "DESC";
			$products  = array_merge($products, $this->model_catalog_product->getProducts($data));
		}
		return $products;	
	}

	
/*	public function getFeaturedMyFashionfeedProd()
	{
		$this->load->model('catalog/product');
		$manufacturers_ids = $this->model_account_follow->getMyFollowsIDs();
		$products = $data = array();
		foreach($manufacturers_ids->rows as $mid)
		{
			$data['filter_manufacturer_id'] = $mid['mid'];
			$data['sort'] = "p.date_added";
			$data['order'] = "DESC";
			$data['featured'] = "1";
			$products  = $this->model_catalog_product->getProducts($data);
		}

		return $products;	
	}*/
	
	
	public function getManufacturerFollowersCount($mid)
	{
		$result =  $this->db->query("SELECT * FROM " . DB_PREFIX . "follows  WHERE mid = " . $mid );
		return $result->num_rows;	
	}
	
	public function saveUserFollows($manufacturers)
	{
		foreach($manufacturers as $m)
		{
			$this->db->query("INSERT INTO " . DB_PREFIX . "follows SET uid = " . $this->session->data['customer_id'] . ", mid = " . (int)$m );	
		}
	}
	
	
	public function getRecomendedDesigners()
	{
		$styles = $follows = $styles_sorted = $recomended_designers = $recomended_list = array();
		$result =  $this->db->query("SELECT f.*, m.* FROM " . DB_PREFIX . "follows as f LEFT JOIN " . DB_PREFIX . "manufacturer as m ON f.mid = m.manufacturer_id WHERE f.uid = " . $this->customer->getId());
		
		foreach($result->rows as $fl)
		{
			$styles[$fl['mid']] = $fl['style_id'];
			$follows[] = $fl['mid'];
		}
		
		
		
		$styles_sorted = array_count_values($styles);
		arsort($styles_sorted);
		
		foreach($styles_sorted as $style_id => $count)
		{
			if($count >= 3)	
			{
				$result =  $this->db->query("SELECT m.* FROM " . DB_PREFIX . "manufacturer as m WHERE m.style_id = " . $style_id ." AND manufacturer_id NOT IN (".implode(',', $follows).")");	
				
				$recomended_designers[$style_id] = array_chunk($result->rows, 3);				
			}
		}
		
		$has_elements = true;
		$i=0;
		while($has_elements)
		{
			$has_elements = false;
			
			foreach($recomended_designers as $d)
			{
				if(isset($d[$i]))
				{
					$recomended_list = array_merge($recomended_list, $d[$i]);
					$has_elements = true;	
				}	
			}			
			$i++;	
		}
		
		return $recomended_list;
	}
	
}
?>