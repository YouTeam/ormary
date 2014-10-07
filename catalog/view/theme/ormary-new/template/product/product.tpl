<?php echo $header; ?>
<?php echo $content_top; ?>


<div class="container content <?php echo $bodyClass; ?>">
	<div class="container breadcrumbs clearfix">
        <ul>
            <li><a href="<?php print $category_info['href'];?>"><?php print $category_info['text'];?></a></li>
            <li><a href="<?php print $manufacturer_link; ?>" class="active"><?php echo $manufacturer; ?></a></li>
          
        </ul>
    </div>
	<div class="clearfix swiper-container">
		<div class="col-lg-6 col-md-6 col-sm-6 mainImageContainer">
            <div class="product_image">
            	<img src="<?php echo $mainimage; ?>" data-zoom-image="<?php echo $zoom; ?>" alt="<?php echo $heading_title; ?>" id="zoom">
               <div class="scroll_cap" id="open_zoom"></div>
                <a href="#" class="close_zoom" id="close_zoom">
                	<img src="catalog/view/theme/ormary-new/images/close_popup.png" alt="">
                </a>
            </div>
            <?php if ($images) { ?>
                <div class="product_thumbnails clearfix" id="product_thumbs">
                	<a href="#" data-image="<?php echo $mainimage; ?>" data-zoom-image="<?php echo $zoom; ?>"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>"></a>
                    <?php foreach ($images as $image) { ?>
                    	<a href="#" data-image="<?php echo $image['mainimage']; ?>" data-zoom-image="<?php echo $image['popup']; ?>"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $heading_title; ?>"></a>
                    <?php } ?>
                </div>
            <?php } ?>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6v textData ">
                    <div class='topData'>
			<div class="product_title"><a href="<?php print $manufacturer_link; ?>"><?php echo $manufacturer; ?></a></div>
			<div class="product_sub_title"><?php echo $heading_title; ?></div>
			<div class="price"><?php print str_replace("£", "&pound;", $price); ?></div>
                        </div>
            <div class="product_description"><?php echo $description; ?></div>
			
                    <form action=""  id="orm_product">
                        <?php if(isset($options['14'])){?>
<div class="available clearfix">
          
            
				<div class="available_sizes">

                            <select name="option[<?php print $options['14']['product_option_id']?>]" id="size" class="form-control">
                            <option value="">Choose your size</option>
                                <?php
                                    foreach($options['14']['option_value'] as $op)
                                    {
                                        print '<option value="'.$op['product_option_value_id'].'">'.$op['name'].'</option>';
                                    }
                                ?>
                            </select>


                    <div class="alert_error" style="display:none;">Please, select a size first</div>
                    <a href="javascript:void(0)" class="size_guide" id="openSizeGuide">Size Guide</a>
	</div>
			</div>

                         <?php }?> 
                    	<input type="hidden" value="<?php print $product_id;?>" name="product_id">
                        <input type="hidden" value="1" name="quantity">  
                        <input type="hidden" value="<?php if(isset($options['13']['option_value'][0]['product_option_value_id'])){ print $options['13']['option_value'][0]['product_option_value_id'];}?>" id="color" name="option[<?php if(isset($options['13']['option_value'][0]['product_option_value_id'])){ print $options['13']['product_option_id'];}?>]" title="<?php if(isset($options['13']['option_value'][0]['product_option_value_id'])){ print $options['13']['option_value'][0]['name'];}?>"> 
                    </form>

			
			<div class="buttons_pannel clearfix">                
                <a href="#" class="add_to_cart open_add_to_cart_popup">Add to bag</a>
                <a href="javascript:void(0)" class="add_to_my_wardrobe" onclick="addToWishList('<?php echo $product_id; ?>');"> + My wardrobe</a>
            </div>
			<div class="orm_share clearfix">
				<div>
                	<span>Got more questions about this item?</span>
                	<a href="/index.php?route=information/contact">Email us</a>
                </div>
                <div>
                    <span class="share_on">Share on</span>
                    <a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo urlencode($product_href); ?>&p[images][0]=<?php print HTTP_SERVER.$thumb; ?>&p[title]=<?php echo $heading_title; ?>&p[summary]=<?php echo trim(htmlspecialchars(strip_tags($description))); ?>" target="_blank">
                    	<i class="fa fa-facebook"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($product_href); ?>&text=<?php echo trim(htmlspecialchars(strip_tags($description))); ?>&via=ormary" target="_blank">
                    	<i class="fa fa-twitter"></i>
                    </a>
                    
                    <a href="https://plus.google.com/share?url=<?php echo $product_href; ?>" target="_blank">
                   		<i class="fa fa-google-plus"></i>
                    </a>
                    <a href="http://www.pinterest.com/pin/create/button/?url=<?php echo $product_href; ?>&media=<?php print HTTP_SERVER.$thumb; ?>&description=<?php echo trim(htmlspecialchars(strip_tags($description))); ?>" data-pin-do="buttonPin" data-pin-config="above" target="_blank">
                        <i class="fa fa-pinterest"></i>
                    </a>
				</div>
                <div>
                    <span>Email a friend</span>
                    <a href="javascript:void(0)" class="open_share_with_friend">
                    <i class="fa fa-envelope-o"></i>
                    </a>
                </div>
			</div>
		</div>
	</div>
	<div class="related_goods hidden-xs clearfix">
		<div class="caption text-center">
        	We Recommend
        </div>
		<div class="clearfix">
        	<?php 
            foreach($products as $p)
            {
            ?>
			<div class="related_good clearfix">
				<div class="product_wrap">
					<div class="product">
						<a href="<?php print $p['href'];?>"><img src="<?php print $p['thumb'];?>" alt="<?php print $p['name'];?>"></a>
						<div class="designer_name"><?php print $p['designer'];?></div>
						<div class="prod_name "><?php print $p['name'];?></div>
						<div class="price"><?php print str_replace('£', '&pound;', $p['price']);?></div>
					</div>
				</div>
			</div>
            <?php 
            }
            ?>
		</div>
	</div>
</div>


<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>

	<div class="popup"></div>
    <div class="add_to_cart_popup">
      <div class="add_to_cart_popup_title">1 item added to your bag</div>
      <div class="product_popup_part clearfix">
        <div class="product_popup_img">
          <img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>">
        </div>
        <div class="product_popup_info">
          <div class="product_popup_info_caption">
            <?php echo $heading_title; ?>
          </div>
          <div class="product_popup_info_row clearfix">
            <!--<div class="cell">
              <span class="greytext">Color: </span><span id="cart_product_color"></span>
            </div>-->

            <div class="cell">
              
            </div>
          </div>
          <div class="product_popup_info_row clearfix">
             <div class="cell">
              <span class="greytext">Size: </span><span id="cart_product_size"></span>
            </div>
            <div class="cell">
              <span class="greytext">Price: </span>&pound;<span id="product_price"><?php print str_replace("£", "", $price); ?></span>
            </div>
            <!--<div class="cell">
              <span class="greytext">Qty: </span><span id="cart_product_qty"></span>
            </div>-->
            <!--<div class="cell">
              <span class="greytext">Total: </span><span id="cart_product_price_total"></span>
            </div>-->
          </div>
          <div class="product_popup_info_row product_popup_info_row-bottom clearfix">
            <div class="cell cell">
              <span class="greytext">ITEMS IN CART: </span><span id="cart_items_in_cart"></span>
            </div>
            <div class="cell cell">
              <span class="greytext">SUBTOTAL: </span><span id="cart_subtotal"></span>
            </div>
            <div class="cell">
             
            </div>
          </div>
        </div>
      </div>
      <div class="add_to_cart_popup_bottom">
        <div>
          <a href="javascript:void(0)" class="add_to_cart" onclick="$('.add_to_cart_popup').hide(); $('.popup').hide();">CONTINUE SHOPING</a>
          <a href="index.php?route=checkout/cart" class="add_to_my_wardrobe">My Bag</a>
        </div>
      </div>
      <a href="#" class="close_popup"></a>
    </div>
    
    
    <div class="share_with_friend_popup">
      <div class="caption text-center">Share with a friend</div>
      <div class="sub_caption clearfix text-center">
        Use the form below to send your friend(s) a personal message and link to this item <br>
        * All form fields with asterisks are mandatory
      </div>
      <div class="clearfix">
        <div class="col-sm-7 col-xs-12 clearfix">
          <div class="inputs">
            <form action="<?php echo $share_prod_friend;?>" id="frmShare" method="post">
              <label>
                <span>Your name <span class="required">*</span></span>
                <input type="text" required value="<?php print $user_firstname;?>" name="fname">
                <div class="alert_error" style="width:240px display:none;" id="error_name">Please enter your name</div>
              </label>
              <label>
                <span>Your email <span class="required">*</span></span>
                <input type="text" required value="<?php print $user_email;?>" name="myemail">
                <div class="alert_error" style="width:240px display:none;" id="error_myemail">Please enter your email</div>
              </label>
              <label id="friendsEmail">
                <span>Your friend email <span class="required">*</span></span>
                <input type="text" required name="femail[]">
                <div class="alert_error" style="width:240px display:none;" id="error_friendemail">Please check your friends email addresses</div>
              </label>
              <a href="javascript:void(0)" onclick="addEmail()" class="one_more_friend">Add one more friend </a>                            
              <label>
                <span>Subject <span class="required">*</span></span>
                <input type="text" required value="<?php echo $heading_title; ?>" name="subject">
               <div class="alert_error" style="width:240px display:none;" id="error_subject">Please enter message subject</div>
              </label>
              <label>
                <span>Your message <span class="required">*</span></span>
                <textarea name="msg" id="msg"><?php echo trim(strip_tags($description)); ?></textarea>
                <div class="alert_error" style="width:240px display:none;" id="error_msg">Please enter message text</div>
              </label>
            </form>
          </div>
        </div>
        <div class="col-sm-5 hidden-xs swf_product_img">
          <img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>">
        </div>
      </div>
     <a onclick="validateEmailUs()" class="dark_btn" href="javascript:void(0)">submit</a>
      <a href="#" class="close_popup"></a>
    </div>
    
	<div class="size_guide_popup" id="size_guide_popup">
      <div class="caption text-center">
        SIZE GUIDE
        <a href="javascript:void(0)" class="close_popup_big">
          <img src="./images/close_popup_big.png" alt="Close">
        </a>
      </div>
      <div class="tables">
        <div class="table-responsive clothing-conversion">
          <table>
           <tr>
             <td colspan="14" class="text-center" width="148">
               <span class="table_title">
                 CLOTHING - SINGLE SIZE CONVERSION
               </span>
             </td>
           </tr>
           <tr>
             <td colspan="2" class="text-left" width="148">
               <span class="table_title first_col">
                 uk
               </span>
             </td>
             <td width="65">4</td>
             <td width="65">6</td>
             <td width="65">8</td>
             <td width="65">10</td>
             <td width="65">12</td>
             <td width="65">14</td>
             <td width="65">16</td>
             <td width="65">18</td>
             <td width="65">20</td>
             <td width="65">22</td>
             <td width="65">24</td>
             <td width="65">26</td>
           </tr>
           <tr>
             <td colspan="2" class="text-left" width="148">
               <span class="table_title first_col">
                 european
               </span>
             </td>
             <td width="65">32</td>
             <td width="65">34</td>
             <td width="65">36</td>
             <td width="65">38</td>
             <td width="65">40</td>
             <td width="65">42</td>
             <td width="65">44</td>
             <td width="65">46</td>
             <td width="65">48</td>
             <td width="65">50</td>
             <td width="65">52</td>
             <td width="65">54</td>
           </tr>
           <tr>
             <td colspan="2" class="text-left" width="148">
               <span class="table_title first_col">
                 us
               </span>
             </td>
             <td width="65">1</td>
             <td width="65">2</td>
             <td width="65">4</td>
             <td width="65">6</td>
             <td width="65">8</td>
             <td width="65">10</td>
             <td width="65">12</td>
             <td width="65">14</td>
             <td width="65">16</td>
             <td width="65">18</td>
             <td width="65">20</td>
             <td width="65">22</td>
           </tr>
           <tr>
             <td colspan="2" class="text-left" width="148">
               <span class="table_title first_col">
                 australia
               </span>
             </td>
             <td width="65">4</td>
             <td width="65">6</td>
             <td width="65">8</td>
             <td width="65">10</td>
             <td width="65">12</td>
             <td width="65">14</td>
             <td width="65">16</td>
             <td width="65">18</td>
             <td width="65">20</td>
             <td width="65">22</td>
             <td width="65">24</td>
             <td width="65">26</td>
           </tr>
          </table>
        </div> 


        <div class="table-responsive clothing-siglesize">
          <table>
            <tr>
              <td colspan="13" class="text-center">
                <span class="table_title first_col">
                  CLOTHING - SINGLE SIZE 
                </span>
              </td>
            </tr>
            <tr>
              <td class="text-left" rowspan="2">
                <span class="table_title first_col">
                  single size
                </span>
              </td>
              <td>
                <span class="table_title">
                  uk 4
                </span>
              </td>
              <td><span class="table_title">uk 6</span></td>
              <td><span class="table_title">uk 8</span></td>
              <td><span class="table_title">uk 10</span></td>
              <td><span class="table_title">uk 12</span></td>
              <td><span class="table_title">uk 14</span></td>
              <td><span class="table_title">uk 16</span></td>
              <td><span class="table_title">uk 18</span></td>
              <td><span class="table_title">uk 20</span></td>
              <td><span class="table_title">uk 22</span></td>
              <td><span class="table_title">uk 24</span></td>
              <td><span class="table_title">uk 26</span></td>
            </tr>
            <tr>
              <td>CM IN</td>
              <td>CM IN</td>
              <td>CM IN</td>
              <td>CM IN</td>
              <td>CM IN</td>
              <td>CM IN</td>
              <td>CM IN</td>
              <td>CM IN</td>
              <td>CM IN</td>
              <td>CM IN</td>
              <td>CM IN</td>
              <td>CM</td>
            </tr>
            <tr>
              <td class="text-left">
                <span class="table_title first_col">
                  bust
                </span>
              </td>
              <td>76 30</td>
              <td>78½ 31</td>
              <td>81 32</td>
              <td>86 34</td>
              <td>91 36</td>
              <td>96 38</td>
              <td>101 40</td>
              <td>108½ 43</td>
              <td>116 45½</td>
              <td>122 48</td>
              <td>128 50½</td>
              <td>134</td>
            </tr>
            <tr>
              <td class="text-left">
                <span class="table_title first_col">
                  waist
                </span>
              </td>
              <td>58 22¾</td>
              <td>60½ 23¾</td>
              <td>63 24¾</td>
              <td>68 26¾</td>
              <td>73 28¾</td>
              <td>78 30¾</td>
              <td>83 32¾</td>
              <td>90½ 35¾</td>
              <td>98 38½</td>
              <td>104 41</td>
              <td>110 43½</td>
              <td>116</td>
            </tr>
            <tr>
              <td class="text-left">
                <span class="table_title first_col">
                  hips
                </span>
              </td>
              <td>83½ 32¾</td>
              <td>86 33¾</td>
              <td>88½ 34¾</td>
              <td>93½ 36¾</td>
              <td>98½ 38¾</td>
              <td>103½ 40¾</td>
              <td>108½ 42¾</td>
              <td>116 45¾</td>
              <td>123½ 48½</td>
              <td>129½ 51</td>
              <td>135½ 53½</td>
              <td>141½</td>
            </tr>
          </table>
        </div>
        <div class="table-responsive clothing-siglesize2">
          <table>
            <tr>
              <td colspan="2" rowspan="2" class="text-left">
                <span class="table_title first_col">
                  dual size
                </span>
              </td>
              <td colspan="2">
                <span class="table_title">
                  uk xs 6
                </span>
              </td>
              <td colspan="2">
                <span class="table_title">
                  uk s 8-10
                </span>
              </td>
              <td colspan="2">
                <span class="table_title">
                  uk m 12-14
                </span>
              </td>
              <td colspan="2">
                <span class="table_title">
                  uk l 16-18
                </span>
              </td>
              <td colspan="2">
                <span class="table_title">
                  uk xl 20
                </span>
              </td>
            </tr>
            <tr>
              <td>cm</td>
              <td>inches</td>
              <td>cm</td>
              <td>inches</td>
              <td>cm</td>
              <td>inches</td>
              <td>cm</td>
              <td>inches</td>
              <td>cm</td>
              <td>inches</td>
            </tr>
            <tr>
              <td colspan="2" class="text-left">
                <span class="table_title first_col">
                  bust
                </span>
              </td>
              <td>78½</td>
              <td>31</td>
              <td>81-86</td>
              <td>32-34</td>
              <td>91-78</td>
              <td>36-38</td>
              <td>101-108½</td>
              <td>40-43</td>
              <td>116</td>
              <td>45½</td>
            </tr>
            <tr>
              <td colspan="2" class="text-left">
                <span class="table_title first_col">
                  waist
                </span>
              </td>
              <td>60½</td>
              <td>23¾</td>
              <td>63-68</td>
              <td>24¾-26¾</td>
              <td>73-78</td>
              <td>28¾-30¾</td>
              <td>83-90½</td>
              <td>32¾-35¾</td>
              <td>98</td>
              <td>38½</td>
            </tr>
            <tr>
              <td colspan="2" class="text-left">
                <span class="table_title first_col">
                  hips
                </span>
              </td>
              <td>86</td>
              <td>33¾</td>
              <td>88½-93½</td>
              <td>34¾-36¾</td>
              <td>98½-103½</td>
              <td>38¾-40¾</td>
              <td>108½-116</td>
              <td>42¾-45¾</td>
              <td>123½</td>
              <td>48½</td>
            </tr>
          </table>
        </div>
        <div class="table-responsive">
          <table>
            <tr>
              <td colspan="6" class="text-center" width="148">
                <span class="table_title">
                  CLOTHING - dual size
                </span>
              </td>
            </tr>
            <tr>
              <td class="text-left" width="148">
                <span class="table_title first_col">
                  uk
                </span>
              </td>
              <td>xs</td>
              <td>s</td>
              <td>m</td>
              <td>l</td>
              <td>xl</td>
            </tr>
            <tr>
              <td class="text-left" width="148">
                <span class="table_title first_col">
                  european
                </span>
              </td>
              <td>xs</td>
              <td>s</td>
              <td>m</td>
              <td>l</td>
              <td>xl</td>
            </tr>
            <tr>
              <td class="text-left" width="148">
                <span class="table_title first_col">
                  us
                </span>
              </td>
              <td>xxs</td>
              <td>xs</td>
              <td>s</td>
              <td>m</td>
              <td>l</td>
            </tr>
            <tr>
              <td class="text-left" width="148">
                <span class="table_title first_col">
                  australia
                </span>
              </td>
              <td>xs</td>
              <td>s</td>
              <td>m</td>
              <td>l</td>
              <td>xl</td>
            </tr>
          </table>
        </div>
      </div>
    </div>



    <script>

	function validateEmailUs()
	{
		$.ajax({
			url: 'index.php?route=product/product/ajaxValidateEmailUsForm',
			type: 'post',
			data: $('#frmShare input, #frmShare textarea'),
			dataType: 'json',
			success: function(json) {
				if (json['error'].length != 0) 
				{										
					if(json['error']['error_name'])
					{
						$('#frmShare #error_name').show();	
					}
					else
					{
						$('#frmShare #error_name').hide();
					}
					
					if(json['error']['error_myemail'])
					{
						$('#frmShare #error_myemail').show();	
					}
					else
					{
						$('#frmShare #error_myemail').hide();
					}	
					
					if(json['error']['error_friendemail'])
					{
						$('#frmShare #error_friendemail').show();	
					}
					else
					{
						$('#frmShare #error_friendemail').hide();
					}					
					
					if(json['error']['error_subject'])
					{
						$('#frmShare #error_subject').show();	
					}
					else
					{
						$('#frmShare #error_subject').hide();
					}		
					
					if(json['error']['error_msg'])
					{
						$('#frmShare #error_msg').show();	
					}
					else
					{
						$('#frmShare #error_msg').hide();
					}								
				} 
				else
				{
					$('#frmShare').submit();
				}	
			}
		});	
	}
	  
	  function addEmail()
	  {
		$('#friendsEmail .alert_error').before ('<br/><br/><span>&nbsp;</span><input type="text" required="" name="femail[]">');
	  }
	  

    </script>
    
      <script type="text/javascript" src="catalog/view/javascript/ormary-js/OrmaryProductDetailsUI.js"></script>

