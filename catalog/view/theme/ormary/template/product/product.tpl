<?php echo $header; ?>
	<div class="container content product_page">
		<?php echo $content_top; ?>

		<div class="breadcrumbs clearfix">
			<ul>
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li>
						<a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6">
			<div class="product_image">
				<img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image">
			</div>
			<?php if ($images) { ?>
				<div class="swiper-container orm_product_carousel">
					<a href="#" class="orm_carousel_prev"></a>
					<a href="#" class="orm_carousel_next"></a>
					<div class="swiper-wrapper">
                    	<div class="swiper-slide orm_carousel_slide active">
								<div class="title">
                    				<img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image">
                        		</div>
						</div>
						<?php foreach ($images as $image) { ?>
							<div class="swiper-slide orm_carousel_slide">
								<div class="title">
									<img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" >
								</div>
							</div>
						<?php } ?>   
					</div>
				</div>
			<?php } ?>
		</div>
        
		<div class="col-lg-6 col-md-6 col-sm-6">
			<div class="product_title">
				<a href="<?php print $manufacturer_link; ?>"><?php echo $manufacturer; ?></a>
			</div>
			<div class="product_sub_title light_font">
				<?php echo $heading_title; ?>
			</div>
			<div class="price light_font"><?php print str_replace("£", "&pound;", $price); ?></div>
			<div class="product_description light_font">
				<?php echo $description; ?>
			</div>
			<form action="" id="orm_product">
            	<?php if(isset($options['13'])){?>
                    <div class="available clearfix light_font">
                        <span>Available colors</span>
                        <ul class="filter-colors">
                            <?php 
                            $class = 'selected';
                            foreach($options['13']['option_value'] as $op)
                            {
                                print '<li id="cl'.$op['product_option_value_id'].'"><span class="'.$class.'" title="'.$op['name'].'" style="background-image:url(image/'.$op['image'].')"></span></li>';
                                $class ='';
                            }
                            ?>
                        </ul>
                        <input type="hidden" value="<?php print $options['13']['option_value'][0]['product_option_value_id']?>" id="color" name="option[<?php print $options['13']['product_option_id']?>]">
                    </div>
                <?php }?>
                
                <?php if(isset($options['14'])){?>
                    <div class="available clearfix light_font">
                        <span>Available sizes</span>
                        <div class="available_sizes">
                            <select name="option[<?php print $options['14']['product_option_id']?>]" id="size" class="form-control">
                                <?php
                                foreach($options['14']['option_value'] as $op)
                                {
                                    print '<option value="'.$op['product_option_value_id'].'">'.$op['name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php }?>
                <div class="available clearfix light_font">
                    <span>Quantity</span>
                    <div class="available_quantity">
                        <select name="quantity" id="qty" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                </div>
                
                <input type="hidden" value="<?php print $product_id;?>" size="2" name="product_id">
            </form>
            
			<div class="buttons_pannel">
				<a href="#" class="add_to_my_wardrobe"  onclick="addToWishList('<?php echo $product_id; ?>');"><span class="plus">+</span> My wardrobe</a>
				<a href="#" class="add_to_cart open_add_to_cart_popup">Add to cart</a>
			</div>
			

            <span id="folow_designer" class="follow">
                <?php 
                    if($follow_state == "follow")
                    {
                ?>
                        <span id="<?php print $manufacturer_id;?>" class="plus">+</span>
                        <span class="word">
                            Follow
                        </span>
                <?php
                    }
                    elseif($follow_state == "unfollow")
                    {
                ?>
                        <span class="minus" id="<?php print $manufacturer_id;?>">-</span>
                        <span class="word">
                            Unfollow
                        </span>
                <?php    
                    }
                ?>
            </span>

		</div>
	</div>
		
	<div class="container product_page_bottom clearfix">
		<div class="col-lg-6 col-md-6 col-sm-6"></div>
		<div class="col-lg-6 col-md-6 col-sm-6 orm_share">
<!--			<div>
				<span>Got more questions about this item?</span><a href="#" class="light_font">Text us</a>
			</div>-->
			<div>
				<span>Share on</span>
				<a href="#">
					<i class="fa fa-facebook"></i>
				</a>
				<a href="#">
					<i class="fa fa-twitter"></i>
				</a>
				<a href="#">
					<i class="fa fa-google-plus"></i>
				</a>
				<a href="#">
					<i class="fa fa-pinterest"></i>
				</a>
			</div>
<!--			<div>
				<span>Email a friend</span>
				<a href="#">
					<i class="fa fa-envelope-o"></i>
				</a>
			</div>-->
		</div>
	</div>
  
<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>


	<div class="popup"></div>
    <div class="add_to_cart_popup">
      <div class="add_to_cart_popup_title"><span id="cart_popup_header">1 item</span> added to your cart</div>
      <div class="product_popup_part clearfix">
        <div class="product_popup_img">
          <img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>">
        </div>
        <div class="product_popup_info">
          <div class="product_popup_info_caption">
            <?php echo $heading_title; ?>
          </div>
          <div class="product_popup_info_row light_font clearfix">
            <div class="cell">
              <span class="greytext">Color: </span><span id="cart_product_color"></span>
            </div>
            <div class="cell">
              <span class="greytext">Size: </span><span id="cart_product_size"></span>
            </div>
            <div class="cell">
              
            </div>
          </div>
          <div class="product_popup_info_row light_font clearfix">
            <div class="cell">
              <span class="greytext">Price: </span>&pound;<span id="product_price"><?php print str_replace("£", "", $price); ?></span>
            </div>
            <div class="cell">
              <span class="greytext">Qty: </span><span id="cart_product_qty"></span>
            </div>
            <div class="cell">
              <span class="greytext">Total: </span><span id="cart_product_price_total"></span>
            </div>
          </div>
          <div class="product_popup_info_row product_popup_info_row-bottom light_font clearfix">
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
          <a href="#" class="add_to_cart">CONTINUE SHOPING</a>
          <a href="index.php?route=checkout/cart" class="add_to_my_wardrobe">My cart</a>
        </div>
      </div>
      <a href="#" class="close_popup"></a>
    </div>
