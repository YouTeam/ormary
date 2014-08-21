<?php echo $header; ?>
<?php echo $content_top; ?>


<div class="container content">
	<div class="container breadcrumbs clearfix">
        <ul>
            <li><a href="<?php print $category_info['href'];?>"><?php print $category_info['text'];?></a></li>
            <li><a href="<?php print $manufacturer_link; ?>"><?php echo $manufacturer; ?></a></li>
            <li><a href="<?php print $product_href;?>" class="active"><?php echo $heading_title; ?></a></li>
        </ul>
    </div>
	<div class="clearfix">
		<div class="col-lg-6 col-md-6 col-sm-6">
            <div class="product_image">
            	<img src="<?php echo $mainimage; ?>" data-zoom-image="<?php echo $zoom; ?>" alt="<?php echo $heading_title; ?>" id="zoom">
               <div class="scroll_cap" id="open_zoom"></div>
                <a href="#" class="close_zoom" id="close_zoom">
                	<img src="catalog/view/theme/ormary-new/images/close_popup.png" alt="">
                </a>
            </div>
            <?php if ($images) { ?>
                <div class="product_thumbnails clearfix" id="product_thumbs">
                	<a href="#" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $thumb; ?>"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>"></a>
                    <?php foreach ($images as $image) { ?>
                    	<a href="#" data-image="<?php echo $image['mainimage']; ?>" data-zoom-image="<?php echo $image['popup']; ?>"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $heading_title; ?>"></a>
                    <?php } ?>
                </div>
            <?php } ?>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6">
			<div class="product_title"><a href="<?php print $manufacturer_link; ?>"><?php echo $manufacturer; ?></a></div>
			<div class="product_sub_title"><?php echo $heading_title; ?></div>
			<div class="price"><?php print str_replace("£", "&pound;", $price); ?></div>
            <div class="product_description"><?php echo $description; ?></div>
			<div class="available clearfix">
          
            
				<div class="available_sizes">
                    <form action=""  id="orm_product">
                        <?php if(isset($options['14'])){?>
                            <select name="option[<?php print $options['14']['product_option_id']?>]" id="size" class="form-control">
                            <option value="">Choose your size</option>
                                <?php
                                    foreach($options['14']['option_value'] as $op)
                                    {
                                        print '<option value="'.$op['product_option_value_id'].'">'.$op['name'].'</option>';
                                    }
                                ?>
                            </select>
                         <?php }?> 
                    	<input type="hidden" value="<?php print $product_id;?>" name="product_id">
                        <input type="hidden" value="1" name="quantity">  
                        <input type="hidden" value="<?php if(isset($options['13']['option_value'][0]['product_option_value_id'])){ print $options['13']['option_value'][0]['product_option_value_id'];}?>" id="color" name="option[<?php if(isset($options['13']['option_value'][0]['product_option_value_id'])){ print $options['13']['product_option_id'];}?>]" title="<?php if(isset($options['13']['option_value'][0]['product_option_value_id'])){ print $options['13']['option_value'][0]['name'];}?>"> 
                    </form>
                    <div class="alert_error" style="display:none;">Please, select a size first</div>
                    <a href="#" class="size_guide">Size Guide</a>
				</div>
			</div>
			<div class="buttons_pannel clearfix">                
                <a href="#" class="add_to_cart open_add_to_cart_popup">Add to bag</a>
                <a href="javascript:void(0)" class="add_to_my_wardrobe" onclick="addToWishList('<?php echo $product_id; ?>');"> + My wardrobe</a>
            </div>
			<div class="orm_share clearfix">
				<div>
                	<span>Got more questions about this item?</span>
                	<a href="#">Email us</a>
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
        	Related goods
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
              </label>
              <label>
                <span>Your email <span class="required">*</span></span>
                <input type="text" required value="<?php print $user_email;?>" name="myemail">
              </label>
              <label>
                <span>Your friend email <span class="required">*</span></span>
                <input type="text" required name="femail">
              </label>
              <a href="#" class="one_more_friend">Add one more friend </a>
              <label>
                <span>Subject <span class="required">*</span></span>
                <input type="text" required value="<?php echo $heading_title; ?>" name="subject">
              </label>
              <label>
                <span>Your message <span class="required">*</span></span>
                <textarea name="msg" id="msg"><?php echo trim(strip_tags($description)); ?></textarea>
              </label>
            </form>
          </div>
        </div>
        <div class="col-sm-5 hidden-xs swf_product_img">
          <img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>">
        </div>
      </div>
      <a onclick="$('#frmShare').submit();" class="dark_btn">submit</a>
      <a href="#" class="close_popup"></a>
    </div>

    <script>

      $(window).resize(function(){

        $('.zoomContainer').remove();

        $('#zoom').elevateZoom({
          gallery: "product_thumbs",
          zoomType: "inner",
          cursor: "crosshair",
          zoomWindowFadeIn: 500,
          zoomWindowFadeOut: 750,
          loadingIcon : '/catalog/view/theme/ormary-new/images/productloading.gif'
        }); 
      }).resize();

    </script>


