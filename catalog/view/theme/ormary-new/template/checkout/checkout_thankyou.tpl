<?php echo $header; ?>
<?php echo $content_top; ?>

<div class="container clearfix thank_you_page">
    <div class="col-md-4 aside">
    	<h2>Congratulations.</h2>
    	<span>Your order will be with you soon</span>
        <?php
        	foreach($products as $product)
            {
        ?>
            <div class="order">
                <a href="<?php print $product['href'];?>"><img src="<?php print $product['image'];?>" alt="Good"></a>
            </div>
        <?php
        	}
        ?>
        
    </div>
    <div class="col-md-8 content">
    	<div class="title text-center">
    		<h2>
            	Get personal with ormary <br> and 
            	<span class="big">win</span> <span class="big">£</span>200 to spend with us
            </h2>
    		<div class="tell_us">
                <h2>
                Just tell us <br>
                the designers you love
                </h2>
    		</div>
    	</div>
    	<div class="do_you_like" style="display: block; top: 91px;">
    		<div class="caption text-center">
            Do you like?
            </div>
    		<a href="#" class="designer" style="width:86px;" id="<?php print $designer['id'];?>">
                <div class="des-img" style="float:none; width:60px; height:60px;" id="<?php print $designer['mid'];?>">
                	<img src="<?php print $designer['image'];?>" alt="<?php print $designer['name'];?>" id="designer_image">
                </div>
                <span id="designer_name"><?php print $designer['name'];?></span>
                <span>Designer</span>
            </a>
    		<div class="designer_goods">
                <a href="#" class="des_slider_left thank_slider_left">
                	<img src="catalog/view/theme/ormary-new/images/des_slider_left.png" alt="">
                </a>
                <a href="#" class="des_slider_right thank_slider_right">
               		<img src="catalog/view/theme/ormary-new/images/des_slider_right.png" alt="">
                </a>
    			<div class="swiper-container thank_you_page_slider">
    				<div class="swiper-wrapper">
                        <?php print $designer['image_list'];?>                        
    				</div>
    			</div>
    		</div>
            <div class="bottom_btn" id="purchase_foollow_designer">
                <a href="javascript:void(0)" class="light_btn payment_like_designer" id="no">no</a>
                <a href="javascript:void(0)" class="light_btn payment_like_designer" id="yes">yes</a>
            </div>
        </div>
    </div>
</div>

<script>

	$(document).ready(function(){
		purchaseSuccessSlider();
	});

</script> 

<?php echo $content_bottom; ?>
<?php echo $footer; ?>
