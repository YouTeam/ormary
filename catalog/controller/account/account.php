<?php 
class ControllerAccountAccount extends Controller { 
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/account');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_my_account'] = $this->language->get('text_my_account');
		$this->data['text_my_orders'] = $this->language->get('text_my_orders');
		$this->data['text_my_newsletter'] = $this->language->get('text_my_newsletter');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_password'] = $this->language->get('text_password');
		$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_reward'] = $this->language->get('text_reward');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_transaction'] = $this->language->get('text_transaction');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_recurring'] = $this->language->get('text_recurring');

		$this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
		$this->data['password'] = $this->url->link('account/password', '', 'SSL');
		$this->data['address'] = $this->url->link('account/address', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['download'] = $this->url->link('account/download', '', 'SSL');
		$this->data['return'] = $this->url->link('account/return', '', 'SSL');
		$this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');
		$this->data['recurring'] = $this->url->link('account/recurring', '', 'SSL');

		if ($this->config->get('reward_status')) {
			$this->data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$this->data['reward'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/account.tpl';
		} else {
			$this->template = 'default/template/account/account.tpl';
		}
		

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'		
		);
		
		$this->data['firstname'] = $this->customer->getFirstName();
		$this->data['lastname'] = $this->customer->getLastName();
		$this->data['biography'] = $this->customer->getBiography();
		$this->data['image_url'] = $this->customer->getProfileImgURL();
		$this->data['email'] = $this->customer->getEmail();

		$this->load->model('account/customer');
		$profile_info = $this->model_account_customer->getCustomer($this->customer->getId());

		$this->data['website'] = $profile_info['website'];
		
		$this->load->model('account/order');
		$this->data['my_orders'] = $this->model_account_order->getOrders(0, 1000);
		
		foreach($this->data['my_orders'] as &$order)
		{
			$order['total'] = $this->currency->format($order['total']);
		}
		
		$this->data['site'] = $this->customer->getEmail();
		
		$this->load->model('account/address');
		$results = $this->model_account_address->getAddresses();

		foreach ($results as $result) {
			$this->data['country'] = $result['country'];
		}
		
		$this->load->model('account/follow');
		$my_followers = $this->model_account_follow->getMyFollows();
		
		$this->load->model('account/follow');
		$reconmended_designers = $this->model_account_follow->getRecomendedDesigners();
		
		$this->load->model('tool/image');

		
		foreach($my_followers->rows as &$mf)
		{
			if($mf['image'])
			{
				$mf['image'] = $this->model_tool_image->resize($mf['image']	, 142, 142);
			}
			else
			{
				$mf['image'] = $this->model_tool_image->resize('no_image.png', 142, 142);	
			}
		}

		$this->data['follows_count'] = $my_followers->num_rows;
		$this->data['my_follows'] = $my_followers->rows;


		foreach($reconmended_designers as &$rd)
		{
			if($rd['image'])
			{
				$rd['image'] = $this->model_tool_image->resize($rd['image']	, 142, 142);
			}
			else
			{
				$rd['image'] = $this->model_tool_image->resize('no_image.png', 142, 142);	
			}
		}

		$this->data['recomended_designers_count'] = count($reconmended_designers);
		$this->data['recomended_designers'] = $reconmended_designers;
		
		$this->data['orders_tab'] = false;
		if(isset($this->request->get['tab']) && $this->request->get['tab'] == 'orders')
		{
			$this->data['orders_tab'] = true;
		}	
		
		$this->response->setOutput($this->render());
	}
}
?>