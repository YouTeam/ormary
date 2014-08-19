<?php
class ModelAccountDesignerInfo extends Model {
	public function addDesigner($data) 
	{
		$this->load->model('account/customer');
		$customer_id = $this->customer->getId();
		$customer = $this->model_account_customer->getCustomer($customer_id);
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET customer_id = '" . $customer_id . "', name = '" . $customer['firstname'] . "', image = '". $customer['profile_img_url'] ."', background_img = '". $this->db->escape($data['designer_bg_img_url'])."', registration_date = '". $customer['date_added'] ."'");	
	}
	
	public function updateDesigner($data) 
	{
		$this->load->model('account/customer');
		$customer_id = $this->customer->getId();
		$customer = $this->model_account_customer->getCustomer($customer_id);
		
		$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET name = '" . $customer['firstname'] . "', image = '". $customer['profile_img_url'] ."', background_img = '". $this->db->escape($data['designer_bg_img_url'])."', registration_date = '". $customer['date_added'] ."' WHERE customer_id = '" . $customer_id . "'");	
	}
	
	public function deleteDesigner($designer_id) 
	{
		
	}	
	
	public function getDesignerInfo($designer_id) 
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer WHERE customer_id = '" . (int)$designer_id . "'");
		return $query->row;
	}
}
?>