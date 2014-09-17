<?php 
class ModelSettingLanding extends Model {
	
	public function getLandingPageBlocks()
	{
		$blocks = array();
		$result = $this->db->query("SELECT * FROM ".DB_PREFIX."landing_page");
		foreach($result->rows as $b)
		{
			$blocks[$b['id']] = $b;	
		}
		return $blocks;
	}
	
	
	public function updateLanding($data)
	{
		for($i=1; $i<6; $i++)	
		{
			$this->db->query("UPDATE " . DB_PREFIX . "landing_page SET text_top = '".$data['block'.$i.'_text1']."', text_bottom = '".$data['block'.$i.'_text2']."', link = '".$data['block'.$i.'_link']."' WHERE id = '" .$i. "'");	
			
			if (isset($data['block'.$i.'_image'])) 
			{
				$this->db->query("UPDATE " . DB_PREFIX . "landing_page SET image = '" . $this->db->escape(html_entity_decode($data['block'.$i.'_image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . $i . "'");	
			}
			
		}
	}
	
}
?>