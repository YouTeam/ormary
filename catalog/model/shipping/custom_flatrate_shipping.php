<?php
class ModelShippingCustomFlatrateShipping extends Model {
	public function getShippingPrice($country_id, $price) 
	{
		$query = $this->db->query("SELECT s.* FROM " . DB_PREFIX . "custom_flatrate_shipping AS s ORDER BY s.sort_order ASC");
		
		$this->load->model('localisation/country');
		$country_info = $this->model_localisation_country->getCountry($country_id);
		$country = $country_info['name'];
		
		foreach($query->rows as $shipping)
		{			
			if($shipping['countries']!== '' && in_array($country_id, explode(',', $shipping['countries'])))
			{
				if($shipping['cart_price'] <= $price)
				{	
					$shipping['message'] = str_replace(array('#price#', '#country#', '#cart_price#'), array($shipping['price'], $country, $shipping['cart_price']), $shipping['message']);				
					return $shipping;
				}
			}
			elseif($shipping['countries']== '')
			{
				if($shipping['cart_price'] <= $price)
				{
					$shipping['message'] = str_replace(array('#price#', '#country#', '#cart_price#'), array($shipping['price'], $country, $shipping['cart_price']), $shipping['message']);
					return $shipping;
				}
			}
		}
	}
}
?>