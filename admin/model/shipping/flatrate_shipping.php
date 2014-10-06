<?php
class ModelShippingFlatrateShipping extends Model {
	
	public function getAllShippingRates()
	{
		$query = $this->db->query("SELECT s.* FROM " . DB_PREFIX . "custom_flatrate_shipping AS s ORDER BY s.sort_order ASC");
		return $query->rows;		
	}
	
	public function getShippingRate($id)
	{
		$query = $this->db->query("SELECT s.* FROM " . DB_PREFIX . "custom_flatrate_shipping AS s WHERE s.id=".(int)$id);
		if($query->num_rows > 0)
		{
			return $query->row;
		}
		else
		{
			return false;	
		}
	}
	
	public function addShippingRate($data)
	{
		//print_r("INSERT INTO " . DB_PREFIX . "custom_flatrate_shipping AS s SET s.name ='".$this->db->escape($data['name'])."', s.price =".(int)$data['price'].", s.sort_order =".(int)$data['sort_order'].", s.countries = '".implode(',', $data['countries'])."', s.cart_price =".(int)$data['cart_price'].", s.message='".$this->db->escape($data['message'])."'");

		if(isset($data['countries']))
		{
			$countries = implode(',', $data['countries']);	
		}
		else
		{
			$countries = '';
		}
		
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "custom_flatrate_shipping SET name ='".$this->db->escape($data['name'])."', price =".(int)$data['price'].", sort_order =".(int)$data['sort_order'].", countries = '".$countries."', cart_price =".(int)$data['cart_price'].", message='".$this->db->escape($data['message'])."'");
		
	}

	public function editShippingRate($id, $data)
	{
		if(isset($data['countries']))
		{
			$countries = implode(',', $data['countries']);	
		}
		else
		{
			$countries = '';
		}
		
		$query = $this->db->query("UPDATE " . DB_PREFIX . "custom_flatrate_shipping AS s SET s.name ='".$this->db->escape($data['name'])."', s.countries = '".implode(',', $data['countries'])."', s.price =".(int)$data['price'].", sort_order =".(int)$data['sort_order'].", s.cart_price =".(int)$data['cart_price'].", s.message='".$this->db->escape($data['message'])."' WHERE s.id=".(int)$id);
		
	}
	
	public function deleteShippingRate($id)
	{
		$query = $this->db->query("DELETE FROM " . DB_PREFIX . "custom_flatrate_shipping WHERE id=".(int)$id);
		
	}
}
?>
