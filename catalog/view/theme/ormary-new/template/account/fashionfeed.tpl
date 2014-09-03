<?php echo $header; ?>


<?php //echo $content_top; ?>


<div class="container content">
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>

    <h4 class="myfashionfeed">MY FASHIONFEED</h4>
    <div class="col-md-10 clearfix nopadding">
        <!--
    	<div class="criteria clearfix">
            <a href="<?php print $this->url->link('common/feed', 'filter=all', 'SSL') ?>" class="<?php print $active_link['all'];?>">All</a>
            <a href="<?php print $this->url->link('common/feed', 'filter=new', 'SSL') ?>" class="<?php print $active_link['new'];?>">New from designers</a>
            <a href="<?php print $this->url->link('common/feed', 'filter=recomended', 'SSL') ?>" class="<?php print $active_link['recomended'];?>">Recommended for wardrobe</a>
            <a href="<?php print $this->url->link('account/fashionfeed', 'filter=featured', 'SSL') ?>" class="<?php print $active_link['featured'];?>">Featured</a>
        </div>-->
    	<div class="section clearfix">
            
            <?php
                foreach($products as $p)
                {
            ?>
                    <div class="col-md-4 col-sm-4 col-xs-6 clearfix">
                        <div class="product_wrap">
                            <div class="product">
                                <a href="<?php print $this->url->link('product/product', 'product_id='.$p['product_id'], 'SSL') ?>" class="link_to_product"><img src="<?php print $p['image'];?>" alt="<?php print $p['name'];?>"  data-swap="<?php print $p['extraimage']; ?>"></a>
                                <div class="designer_name"><?php print $p['manufacturer'];?></div>
                                <div class="prod_name light_font"><?php print $p['name'];?></div>
                                <div class="price"><?php print str_replace("£", "&pound;", $p['price']);?></div>
                                <a href="javascript:void(0)" class="add_to_wardrobe add_to_wardrobe_ff" onclick="addToWishList('<?php echo $p['product_id']; ?>');" >
                                    + My Wardrobe
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
            	}
            ?>
		</div>
    </div>

    <div class="col-md-2 clearfix aside">
    	<div class="my_wardrobe">
    		<img class="wardrobe_icon" src="catalog/view/theme/ormary-new/images/i.png" alt="i">
    		<span class="in_my_wardrobe"><a href="/index.php?route=account/wishlist">IN MY WARDROBE</a></span>
            <div class="scroll-area">
                <ul>
                    <?php
                    if(isset($wardrobe_products))
                    {
                        foreach($wardrobe_products as $wp)
                        {
                    ?>
                            <li>
                                <a href="<?php print $this->url->link('product/product', 'product_id='.$wp['product_id'], 'SSL') ?>" class="wardrobe_product">
                                    <img src="<?php print $wp['image']; ?>" alt="<?php print $wp['name']; ?>">
                                    <div class="">
                                    	<div class="designer_name"><?php print $wp['designer']; ?></div>
                                    	<div class="prod_name"><?php print $wp['name']; ?></div>
                                    	<div class="price"><?php print str_replace("£", "&pound;", $wp['price']); ?></div>
                                   	</div>
                                </a>
                            </li>
                    <?php
                        }
                    }   
                    else
                    {
                    ?>
                        <li>
                            <div class="wardrobe_product">
                                <img src="catalog/view/theme/ormary-new/images/wardrobe_default.png" alt="default">
                            </div>
                        </li>                   
                    <?php
                    }         
                    ?>
                </ul>
            </div>
    	</div>
    </div>
</div>

</div>
<?php echo $content_bottom; ?>
<?php echo $footer; ?> 
<script>

  var myScroll2;

  myScroll2 = new IScroll('.scroll-area', {
	scrollbars: true,
	mouseWheel: true,
	interactiveScrollbars: true,
	shrinkScrollbars: 'scale',
	fadeScrollbars: false
  });



  $('.scroll-area ul li').mouseover(function(){
	 myScroll2.refresh();
  });
  
	$('.scroll-area ul li').mouseout(function(){
	 myScroll2.refresh();
	});
	
	if ($('.scroll-area').height() < 610 ) {
	$(".iScrollVerticalScrollbar").hide();
	}

</script>

