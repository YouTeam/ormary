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
    		<a href="#" class="designer">
                <div class="des-img">
                	<img src="images/regina.png" alt="regina">
                </div>
                <span>Rejina PYO</span>
                <span>Designer</span>
            </a>
    		<div class="designer_goods">
                <a href="#" class="des_slider_left thank_slider_left">
                	<img src="images/des_slider_left.png" alt="">
                </a>
                <a href="#" class="des_slider_right thank_slider_right">
               		<img src="images/des_slider_right.png" alt="">
                </a>
    			<div class="swiper-container thank_you_page_slider">
    				<div class="swiper-wrapper" style="width: 2100px; height: 212px; transform: translate3d(-600px, 0px, 0px); -webkit-transform: translate3d(-600px, 0px, 0px); transition: 0s; -webkit-transition: 0s;">
                        <div class="swiper-slide" style="width: 150px; height: 212px;">
                            <img src="images/des_goods3.png" alt="">
                        </div>
                        <div class="swiper-slide" style="width: 150px; height: 212px;">
                            <img src="images/des_goods1.png" alt="">
                        </div>
                        <div class="swiper-slide" style="width: 150px; height: 212px;">
                            <img src="images/des_goods2.png" alt="">
                        </div>
                        <div class="swiper-slide" style="width: 150px; height: 212px;">
                            <img src="images/des_goods3.png" alt="">
                        </div>
                        <div class="swiper-slide swiper-slide-visible swiper-slide-active" style="width: 150px; height: 212px;">
                            <img src="images/des_goods1.png" alt="">
                        </div>
                        <div class="swiper-slide swiper-slide-visible" style="width: 150px; height: 212px;">
                            <img src="images/des_goods2.png" alt="">
                        </div>
                        <div class="swiper-slide swiper-slide-visible" style="width: 150px; height: 212px;">
                            <img src="images/des_goods3.png" alt="">
                        </div>
                        <div class="swiper-slide swiper-slide-visible" style="width: 150px; height: 212px;">
                            <img src="images/des_goods1.png" alt="">
                        </div>
                        <div class="swiper-slide" style="width: 150px; height: 212px;">
                            <img src="images/des_goods2.png" alt="">
                        </div>
                        <div class="swiper-slide" style="width: 150px; height: 212px;">
                            <img src="images/des_goods3.png" alt="">
                        </div>
                        <div class="swiper-slide" style="width: 150px; height: 212px;">
                            <img src="images/des_goods1.png" alt="">
                        </div>
                        <div class="swiper-slide" style="width: 150px; height: 212px;">
                            <img src="images/des_goods2.png" alt="">
                        </div>
                        <div class="swiper-slide" style="width: 150px; height: 212px;">
                            <img src="images/des_goods3.png" alt="">
                        </div>
                        <div class="swiper-slide" style="width: 150px; height: 212px;">
                            <img src="images/des_goods1.png" alt="">
                        </div>
    				</div>
    			</div>
    		</div>
            <div class="bottom_btn">
                <a href="#" class="light_btn">no</a>
                <a href="#" class="light_btn">yes</a>
            </div>
        </div>
    </div>
</div>
    
<?php echo $content_bottom; ?>
<?php echo $footer; ?>
