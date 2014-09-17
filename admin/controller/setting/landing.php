<?php
class ControllerSettingLanding extends Controller {

	public function index() 
	{
		$this->document->setTitle("Landing page settings");
		$this->language->load('setting/setting'); 
		$this->load->model('setting/landing');
		$this->load->model('tool/image');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_landing->updateLanding($this->request->post);


			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('setting/landing', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}
		
		
		$this->data['heading_title'] = "Landing page settings";
		
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');	
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		
		$this->data['cancel'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
		
		
		$this->data['action'] = $this->url->link('setting/landing', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];
		
		
		$blocks = $this->model_setting_landing->getLandingPageBlocks();
		
		
		// --- Block #1 Left side
		for($i=1; $i<6; $i++)
		{
			if (isset($this->request->post['block'.$i.'_text1'])) {
				$this->data['block'.$i.'_text'] = $this->request->post['block'.$i.'_text1'];
			} else {
				$this->data['block'.$i.'_text1'] = $blocks[$i]['text_top'];
			}
			
			if (isset($this->request->post['block'.$i.'_text2'])) {
				$this->data['block'.$i.'_text2'] = $this->request->post['block'.$i.'_text2'];
			} else {
				$this->data['block'.$i.'_text2'] = $blocks[$i]['text_bottom'];
			}
			
			if (isset($this->request->post['block'.$i.'_link'])) {
				$this->data['block'.$i.'_link'] = $this->request->post['block'.$i.'_link'];
			} else {
				$this->data['block'.$i.'_link'] = $blocks[$i]['link'];
			}
			
			if (isset($this->request->post['block'.$i.'_image'])) {
				$this->data['block'.$i.'_image'] = $this->request->post['block'.$i.'_image'];
			} elseif (!empty($block[$i])) {
				$this->data['block'.$i.'_image'] = $product_info['block'.$i.'_image'];
			} else {
				$this->data['block'.$i.'_image'] = '';
			}
			
			if (isset($this->request->post['block'.$i.'_image']) && file_exists(DIR_IMAGE . $this->request->post['block'.$i.'_image'])) {
				$this->data['block'.$i.'_thumb'] = $this->model_tool_image->resize($this->request->post['block'.$i.'_image'], 100, 100);
				$this->data['block'.$i.'_image'] = $this->request->post['block'.$i.'_image'];
			} elseif (!empty($blocks[$i]) && $blocks[$i]['image'] && file_exists(DIR_IMAGE . $blocks[$i]['image'])) {
				$this->data['block'.$i.'_thumb'] = $this->model_tool_image->resize($blocks[$i]['image'], 100, 100);
				$this->data['block'.$i.'_image'] = $blocks[$i]['image'];
			} else {
				$this->data['block'.$i.'_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
				$this->data['block'.$i.'_image'] = '';
			}
		}
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		$this->template = 'setting/landing.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
		
		
	}


	protected function validate() 
	{
		return true;
	}
}