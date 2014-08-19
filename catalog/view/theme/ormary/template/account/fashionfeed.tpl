<?php echo $header; ?>

<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>

	<div class="container content">
    	<?php //echo $content_top; ?>
        <h4>MY FASHIONFEED</h4>
        <div class="col-md-9 clearfix nopadding">
          <div class="criteria clearfix">
            <a href="<?php print $this->url->link('common/home', 'filter=all', 'SSL') ?>" class="<?php print $active_link['all'];?>">All</a>
            <a href="<?php print $this->url->link('common/home', 'filter=new', 'SSL') ?>" class="<?php print $active_link['new'];?>">New from designers</a>
            <a href="<?php print $this->url->link('common/home', 'filter=recomended', 'SSL') ?>" class="<?php print $active_link['recomended'];?>">Recommended for wardrobe</a>
           <!-- <a href="<?php print $this->url->link('account/fashionfeed', 'filter=featured', 'SSL') ?>" class="<?php print $active_link['featured'];?>">Featured</a>-->
          </div>
          <div class="section">
          	<?php
              foreach($products as $p)
              {
            ?>
            <div class="col-md-4 col-sm-4 col-xs-6 clearfix">
                <div class="product_wrap">
                  <div class="product">
                    <a href="<?php print $this->url->link('product/product', 'product_id='.$p['product_id'], 'SSL') ?>"><img src="<?php print $p['image'];?>" alt="<?php print $p['name']?>"></a>
                    <div class="designer_name"><?php print $p['manufacturer']?></div>
                    <div class="prod_name light_font"><?php print $p['name']?></div>
                    <div class="price"><?php print str_replace("£", "&pound;", $p['price']);?></div>
                    <a href="#" class="add_to_wardrobe" onclick="addToWishList('<?php echo $p['product_id']; ?>');">
                      <img src="catalog/view/theme/ormary/images/add_to_wardrobe.png" alt="+ wardrobe">
                    </a>
                  </div>
                </div>
            </div>
            <?php
          	}
          	?>
          </div>
        </div>
        <div class="col-md-3 clearfix aside">
          <div class="my_wardrobe">

            <img class="wardrobe_icon" src="image/data/wardrobe.png" alt="i">
			<span class="in_my_wardrobe">IN MY WARDROBE</span>
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
                                  <img src="<?php print $wp['image']; ?>" alt="default">
                                  <div class="designer_name"><?php print $wp['designer']; ?></div>
                                  <div class="prod_name light_font"><?php print $wp['name']; ?></div>
                                  <div class="price"><?php print str_replace("£", "&pound;", $wp['price']); ?></div>
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
                                <img src="image/data/wardrobe_default.png" alt="default">
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




<!--
<div id="content" class="container content"><?php echo $content_top; ?>
	<h4>My Fashionfeed</h4>
        
      
	<div class="col-md-9 clearfix nopadding section">
          <div class="criteria">
            <a href="<?php print $this->url->link('account/fashionfeed', 'filter=all', 'SSL') ?>" class="<?php print $active_link['all'];?>">All</a>
            <a href="<?php print $this->url->link('account/fashionfeed', 'filter=new', 'SSL') ?>" class="<?php print $active_link['new'];?>">New from designers</a>
            <a href="<?php print $this->url->link('account/fashionfeed', 'filter=recomended', 'SSL') ?>" class="<?php print $active_link['recomended'];?>">Recommended for wardrobe</a>
            <a href="<?php print $this->url->link('account/fashionfeed', 'filter=featured', 'SSL') ?>" class="<?php print $active_link['featured'];?>">Featured</a>
          </div>
          
          <?php
          foreach($products as $p)
          {
          ?>
              <div class="col-md-4 col-sm-4 col-xs-6 clearfix">
                  <div class="product_wrap">
                    <div class="product">
                      <a href="<?php print $this->url->link('product/product', 'product_id='.$p['product_id'], 'SSL') ?>"><img src="/ormary/image/<?php print $p['image']?>" alt="<?php print $p['name']?>"></a>
                      <div class="designer_name"><?php print $p['manufacturer']?></div>
                      <div class="prod_name light_font"><?php print $p['name']?></div>
                      <div class="price">&pound;<?php print $p['price']?></div>
                      <a href="#" class="pin">
                        <img src="/ormary/image/data/pin.png" alt="pin it">
                      </a>
                      <a href="#" class="add_to_wardrobe">
                        <img src="/ormary/image/data/add_to_wardrobe.png" alt="+ wardrobe">
                      </a>
                    </div>
                  </div>
              </div>
          <?php
          }
          ?>
          
          
	</div>
    
    <div class="col-md-3 clearfix aside">
      <div class="my_wardrobe">
        <img class="wardrobe_icon" src="/ormary/image/data/wardrobe.png" alt="i">
        <span class="in_my_wardrobe">IN MY WARDROBE</span>
        <div class="wardrobe_product">
          <img src="/ormary/image/data/wardrobe_default.png" alt="default">
        </div>
      </div>
    </div>
    
	
</div>-->

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


  document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);

  $('.scroll-area ul li').mouseover(function(){
	 myScroll2.refresh();
  });
  
	$('.scroll-area ul li').mouseout(function(){
	 myScroll2.refresh();
	});
	
	if ($('.scroll-area').height() < 540 ) {
	$(".iScrollVerticalScrollbar").hide();
	}

</script>

