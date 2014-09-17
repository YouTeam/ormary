<?php echo $header; ?>
<?php

if (  $this->customer->isLogged() ) {

?>

<div class="container-fluid top-banner clearfix">
    <div class="container">
        <span>
               You have new recommendations just for you in your<br>Ormary Fashion Feed
        </span>
        <a href="/index.php?route=common/feed" class="dark_btn loggedin">My Fashion Feed</a>
    </div>
</div>
<?php

}else {

?>
<div class="container-fluid top-banner clearfix">
    <div class="container">
        <span>
        Get your personal style magazine, new designers alerts
        & access to EXCLUSIVE member offers
        </span>
        <a href="#" class="dark_btn open_ormary">Join now</a>
    </div>
</div>
<?php } ?>








<div class="container shop_collections">
     <div class="mainpromo shop_collection">
          <a href="<?php print $blocks[5]['link'];?>">
    	<img src="<?php print $blocks[5]['image'];?>" alt="<?php print $blocks[5]['text_top'];?>">
        </a>
        <a href="<?php print $blocks[5]['link'];?>" class='linkdown'>
    		<div class="collection_name">
            	<?php print $blocks[5]['text_top'];?>
            </div>
            <div class="collection_title" >
            	<?php print $blocks[5]['text_bottom'];?>
            </div>
    	</a>
    </div>
    <div class=clearfix></div>
    <div class="col-md-4 shop_collection">
          <a href="<?php print $blocks[1]['link'];?>">
    	<img src="<?php print $blocks[1]['image'];?>" alt="">
        </a>
        <a href="<?php print $blocks[1]['link'];?>">
    		<div class="collection_name">
            	<?php print $blocks[1]['text_top'];?>
            </div>
            <div class="collection_title">
            	<?php print $blocks[1]['text_bottom'];?>
            </div>
    	</a>
    </div>
    <div class="col-md-8 shop_collection">
    	<div class="col-md-6 shop_collection">
                <a href="<?php print $blocks[2]['link'];?>">
        	<img src="<?php print $blocks[2]['image'];?>" alt="">
                </a>
            <a href="<?php print $blocks[2]['link'];?>">
            	<div class="collection_name">
            		<?php print $blocks[2]['text_top'];?>
                </div>
                <div class="collection_title">
                    <?php print $blocks[2]['text_bottom'];?>
                </div>
            </a>
    	</div>
    	<div class="col-md-6 shop_collection">
              <a href="<?php print $blocks[3]['link'];?>">
        	<img src="<?php print $blocks[3]['image'];?>" alt="">
                </a>
            <a href="<?php print $blocks[3]['link'];?>">
            	<div class="collection_name">
            		<?php print $blocks[3]['text_top'];?>
                </div>
                <div class="collection_title">
                    <?php print $blocks[3]['text_bottom'];?>
                </div>
            </a>            
    	</div>
    	<div class="col-md-12 shop_collection">
                        <a href="<?php print $blocks[4]['link'];?>">
        	<img src="<?php print $blocks[4]['image'];?>" alt=""></a>
            <a href="<?php print $blocks[4]['link'];?>">
            	<div class="collection_name">
                        <?php print $blocks[4]['text_top'];?>
                    </div>
                    <div class="collection_title">
                        <?php print $blocks[4]['text_bottom'];?>
                    </div>
                </div>
            </a>
    </div>
</div>

<div class="container newest_products">
    <h3 class="text-center">
    	<span>WHAT’S NEW</span>
    </h3>
    
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
</div>
   


<?php

if (  $this->customer->isLogged() ) {

?>

<div class="container bottom-banner">
    <a href="/index.php?route=common/feed">
    	<img src="catalog/view/theme/ormary-new/images/bottom-banner-loggedin.png" alt="Join now">
    </a>
</div>
<?php

}else {

?>
<div class="container bottom-banner">
    <a href="#" class="open_ormary">
    	<img src="catalog/view/theme/ormary-new/images/bottom-banner.png" alt="Join now">
    </a>
</div>
<?php } ?>

<?php echo $content_bottom; ?>
<?php echo $footer; ?>