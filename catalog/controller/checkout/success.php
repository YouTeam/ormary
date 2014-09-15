<?php
class ControllerCheckoutSuccess extends Controller { 
	public function index() {
		if (isset($this->session->data['order_id'])) {
		$email_message = file_get_contents('./emails/thanks_template.html', FILE_USE_INCLUDE_PATH);
		
		$this->load->model('account/order');

		$order = $this->model_account_order->getOrderAllStatuses($this->session->data['order_id']);	
		$order_totals = $this->model_account_order->getOrderTotals($this->session->data['order_id']);	
		$order_products = $this->model_account_order->getOrderProductsWithDetails($this->session->data['order_id']);

		$email_message = str_ireplace("CUSTOMER_NAME", $order['payment_firstname'], $email_message);
		
		$totals_html = '<table width="500" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">';
		foreach($order_totals as $ordertotal)
		{
			$totals_html .=	'<tr><td width="340"></td><td align="right"><font color="#000000" size="2">'.$ordertotal['title'].'</font></td><td width="10"></td>
								<td><font color="#000000" size="2">'.$ordertotal['text'].'</font></td><td width="25"></td></tr>';
		}
		$totals_html.='<tr><td height="20"></td></tr></table>';
		$email_message = str_ireplace("TABLE_TOTALS", $totals_html, $email_message);
		
		$products_html = '';
		foreach($order_products as $order_product)
		{
		
			$products_html .= '<table width="500" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff"><tr><td width="20"></td>
								<td width="105"><img src="http://ORMARY_SERVER/image/'.$order_product['image'].'" alt="Product" width="105" height="129"></td>
								<td valign="top" width="225"><font color="#000000" size="2"> '.$order_product['name'].' <br></font>
									<font color="#000000" size="2">'.strip_tags (html_entity_decode($order_product['description'])).' <br></font></td>
								<td valign="top" width="65"><font color="#000000" size="2">'.$order_product['product_quantity'].'</font></td>
								<td valign="top"><font color="#000000" size="2">'.(double)((int)$order_product['product_quantity']*(double)$order_product['product_price']).'</font></td>
							</tr><tr><td height="20"></td></tr></table>';
		}
		$email_message = str_ireplace("TABLE_PRODUCTS", $products_html, $email_message);
		
		$email_message = str_ireplace("SHIPPING_COUNTRY",$order['payment_zone'].", ".$order['payment_country'], $email_message);
		$email_message = str_ireplace("SHIPPING_CITY", $order['payment_city'], $email_message);
		$email_message = str_ireplace("SHIPPING_STREET", $order['payment_address_1'], $email_message);
		
		$mail = new Mail();
		$mail->sendNotificationEmail($order['email'], '', $email_message, 'ORMARY order confirmation');
		
		$this->load->model('checkout/order');
		
		$this->model_checkout_order->confirm($this->session->data['order_id'], 2, '', false);
		$this->model_checkout_order->update($this->session->data['order_id'], 2, '', false);
		
		
			//print_r($this->session->data);
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
			//print_r($order_info);
			
			$this->load->model('tool/image');

			$this->data['products'] = array();

			$this->data['products'] = $this->cart->getProducts();
			foreach ($this->data['products'] as &$product) 
			{
				$product_total = 0;
				if ($product['image']) 
				{
					$product['image'] = $this->model_tool_image->resize($product['image'], 200, 230);
				} 
				else 
				{
					$product['image'] = '';
				}
				$product['href'] = $this->url->link('product/product', 'product_id=' . $product['product_id']);
			}
			
			$this->cart->clear();

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);	
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
		}	

		$this->language->load('checkout/success');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array(); 

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home'),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/cart'),
			'text'      => $this->language->get('text_basket'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
			'text'      => $this->language->get('text_checkout'),
			'separator' => $this->language->get('text_separator')
		);	

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('checkout/success'),
			'text'      => $this->language->get('text_success'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		if ($this->customer->isLogged()) {
			$this->data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
			$this->data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('common/home');



		/*----------Who to follow wizard------------*/
		$this->load->model('catalog/manufacturer');
		$this->session->data['designers'] = $this->model_catalog_manufacturer->getPopularManufacturersList();
		
		$first_designer = current($this->session->data['designers']);
		$this->session->data['designers_style_count'] = $first_designer['style'];
		$this->session->data['designers_liked_count'] = 0;
		$this->session->data['designers_liked_summary'] = 0;
		
		$this->data['first_designer_order_id'] = 0;
		
		
		$json = array();
		
		$this->data['designer']['id'] = 0;
		$this->data['designer']['mid'] = $first_designer['mid'];
		$this->data['designer']['name'] = $first_designer['name'];
		$this->data['designer']['image'] = $first_designer['image'];
		$this->data['designer']['image_list'] = '';
		foreach($first_designer['images'] as $img)
		{
			$this->data['designer']['image_list'] .= '<div class="swiper-slide"><img src="'.$img.'"></div>';
		}
		


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout_thankyou.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout_thankyou.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}


/*		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}*/

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'			
		);

		$this->response->setOutput($this->render());
	}
}
?>