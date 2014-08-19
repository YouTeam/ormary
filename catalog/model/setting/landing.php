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
}
?>