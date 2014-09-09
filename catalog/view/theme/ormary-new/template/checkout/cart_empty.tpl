<?php echo $header; ?>




<div class="container content">
    <div class=""><h4 class="text-center">Your Shopping Bag Is Empty.</h4></div>
    
    <div >
       
    <div class="container newest_products" style="margin-top: 40px;">
    <h3 class="text-center">
    	<span>We Reccommend</span>
    </h3>
    <?php if (!$this->customer->isLogged()) { ?>
    <?php 
    if(count($featured_products) >= 6)
    {
    ?>
    <a href="#" class="newest_carousel_prev"></a>
    <a href="#" class="newest_carousel_next"></a>
    <?php 
    } 
    ?>
    
    <div class="swiper-container orm_newest_carousel">
    	<div class="swiper-wrapper">
    		<?php foreach($featured_products as $p){ ?>
            
            <div class="clearfix swiper-slide">
    			<div class="product_wrap">
                    <div class="product">
                        <a href="<?php print $p['href']?>"><img src="<?php print $p['thumb']?>" alt="<?php print $p['name']?>"></a>
                        <div class="designer_name"><?php print $p['manufacturer_name']?></div>
                        <div class="prod_name"><?php print $p['name']?></div>
                        <div class="price"><?php print $p['price']?></div>
                    </div>
    			</div>
    		</div>
            <?php }?>
		</div>
	</div>
            <?php }?>

    <?php if ($this->customer->isLogged()) { ?> 
        <?php 
    if(count($featured_products) >= 6)
    {
    ?>
    <a href="#" class="newest_carousel_prev"></a>
    <a href="#" class="newest_carousel_next"></a>
    <?php 
    } 
    ?>
 <div class="swiper-container orm_newest_carousel">
    	<div class="swiper-wrapper">
    		<?php foreach($featured_products as $p){ ?>
            
            <div class="clearfix swiper-slide">
    			<div class="product_wrap">
                    <div class="product">
                        <a href="<?php print $this->url->link('product/product', 'product_id='.$p['product_id'], 'SSL') ?>"><img src="<?php print $p['image']?>" alt="<?php print $p['name']?>"></a>
                        <div class="designer_name"><?php print $p['manufacturer']?></div>
                        <div class="prod_name"><?php print $p['name']?></div>
                        <div class="price"><?php print $p['price']?></div>
                    </div>
    			</div>
    		</div>
            <?php }?>
		</div>
	</div>
    
    <?php } ?>
</div>
   

<br><br>
<a href="/new" class='empty_whatsnew'>SHOP WHAT'S NEW</a>
    
    </div>
</div>
<?php echo $footer; ?>

