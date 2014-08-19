<?php 
class ControllerAccountFollow extends Controller 
{  
	public function changeFollow() 
	{
		if ($this->customer->isLogged()) 
		{
			$state = $this->db->escape($_GET['st']);
			$mid = intval($_GET['mid']);
			
			$this->load->model('account/follow');
			$follows_count = $this->model_account_follow->setFollowState($mid, $state);
			
			print $follows_count;
		}
	}
}
?>