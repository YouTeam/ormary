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
	
	
	function getQuote($address) {
		
		$method_data = array();

		$quote_data = array();

		$quote_data['flat'] = array(
			'code'         => 'custom_flatrate_shipping.custom_flatrate_shipping',
			'title'        => "Flatrate",
			'cost'         => $this->session->data['shipping_price'],
			'tax_class_id' => '',
			'text'         => $this->currency->format($this->session->data['shipping_price'])
		);

		$method_data = array(
			'code'       => 'custom_flatrate_shipping',
			'title'      => "Flatrate shipping",
			'quote'      => $quote_data,
			'sort_order' => 3,
			'error'      => false
		);
		

		return $method_data;
	}
	
}
?>