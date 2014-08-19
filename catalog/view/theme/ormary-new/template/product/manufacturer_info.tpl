<?php echo $header; ?>

<div class="container content orm_designer_page">
	<div class="breadcrumbs container clearfix">
        <ul>
            <li><a href="<?php echo $this->url->link('product/manufacturer');?>">All designers</a></li>
            <li><a href="<?php echo $manufacturer_href;?>" class="active"><?php echo $heading_title ?></a></li>
        </ul>
	</div>
    
    <style>
	.orm_designer_info_wrap 
	{
		background: url('<?php print $this->url->img_link($bgimage);?>') no-repeat 0 0;;
	}
	@media screen and (max-width: 991px){
		.orm_designer_info_wrap 
		{
			height: auto;
			padding: 0;
			background: none;
		}
	}
	</style>
    
    <div class="orm_designer_info_wrap clearfix">
    	<div class="orm_designer_info">
    		<div class="orm_designer_logo">
                <img src="<?php print $image; ?>" alt="<?php echo $heading_title; ?>" data-pin-no-hover="true">
            </div>            
            <div class="orm_designer_content">
            	<div class="orm_designer_content_inner">
            		<div class="orm_designer_name"><?php echo $heading_title; ?></div>
                    <div class="orm_designer_about light_font">
                    	<?php print $manufacturer_description;?>
                    	<!--<a href="#" class="read_more">Read more</a>-->
                    </div>
                    <span href="#" class="follow" id="folow_designer">
                        <?php 
                            if($state == "follow")
                            {
                        ?>                        
                                <span class="plus" id="<?php print $mid;?>">+</span>
                                <span class="word">
                                    Follow
                                </span>
                        <?php
                            }
                            elseif($state == "unfollow")
                            {
                        ?>
                                <span class="minus" id="<?php print $mid;?>">-</span>
                                <span class="word">
                                    Unfollow
                                </span>
                        <?php    
                            }
                        ?>
                    </span>
                    
        			<span class="orm_followers light_font"><span id="follows_count"><?php print $followers_count;?></span> followers</span>
					<div class="share_on light_font">
                        <span>Share on</span>
                            <a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo urlencode($manufacturer_href); ?>&p[images][0]=<?php print $image; ?>&p[title]=<?php echo $heading_title; ?>&p[summary]=<?php echo htmlspecialchars(strip_tags($manufacturer_description)); ?>" target="_blank">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($manufacturer_href); ?>&text=<?php echo htmlspecialchars(strip_tags($manufacturer_description)); ?>&via=ormary" target="_blank">
                                <i class="fa fa-twitter"></i>
                            </a>
                            
                            <a href="https://plus.google.com/share?url=<?php echo $manufacturer_href; ?>" target="_blank">
                                <i class="fa fa-google-plus"></i>
                            </a>
                            <a href="http://www.pinterest.com/pin/create/button/?url=<?php $manufacturer_href;?>&media=<?php print $image;?>&description=<?php echo htmlspecialchars(strip_tags($manufacturer_description)); ?>" data-pin-do="buttonPin" data-pin-config="above" target="_blank">
                                <i class="fa fa-pinterest"></i>
                            </a>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container content">
    <div class="top_panel clearfix">
    	<div class="wrap_pagination">
            <?php echo $pagination; ?>
    	</div>
        <div class="wrap_items_on_page">
        <form action=""  id="orm_sort_filter">
            <span class="">Items on page</span>
            <select name="limit" id="" class="items_on_page form-control">
                <?php foreach ($limits as $limits) { ?>
                    <?php if ($limits['value'] == $limit) { ?>
                        <option value="<?php echo $limits['value']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $limits['value']; ?>"><?php echo $limits['text']; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </form>
        </div>
    </div>
    <a href="javascript:void(0)" class="sort_by">Sort by</a>

    <div class="col-md-2 clearfix aside clothing_aside">
        <form action="" id="orm_filter">
        
        	<input type="hidden" value="<?php print $mid;?>" id="" name="manufacturer_id">
            <fieldset>
                <ul class="filter-clothing">
					<?php print $filter_options['categories_list'];?>
                </ul>
            </fieldset>
            <fieldset>
                <div class="filter_title">
                	Price
                </div>
                <div id="slider"></div>
                <div class="slider_control">
                    <span class='minCost'>&pound; <span type="text" id="minCost"><?php print $filter_options['price']['price_low'];?></span></span>
                    <span class='maxCost'>&pound; <span type="text" id="maxCost"><?php print $filter_options['price']['price_top'];?></span></span>
                    <input type="hidden" value="<?php print $filter_options['price']['price_low'];?>" id="slider_price_low" name="price_low">
            		<input type="hidden" value="<?php print $filter_options['price']['price_top'];?>" id="slider_price_top" name="price_top">            
           			<input type="hidden" value="<?php print $filter_options['price']['max_price'];?>" id="sliderMaxPrice">
                </div>
            </fieldset>
            <a href="<?php echo $this->url->link('product/manufacturer/info', 'manufacturer_id='.$this->request->get['manufacturer_id']);?>" class="dark_btn clear_filter_btn">Clear  all filters</a>
        </form>
    </div>
    <div class="col-md-10 clearfix nopadding">
          <div class="section clearfix">
            <?php if ($products) {  
            	foreach ($products as $product) 
                { 
             ?>           
                    <div class="col-md-4 col-sm-4 col-xs-6 clearfix">
                    	<div class="product_wrap">
                    		<div class="product">                    			
                                <?php if ($product['thumb']) { ?>
                                	<a href="<?php print $product['href']; ?>">
                                		<img src="<?php print $product['thumb']; ?>" title="<?php print $product['name']; ?>" alt="<?php echo $product['name']; ?>" />
                                	</a>
                                <?php } ?>
                    			<div class="designer_name"><?php print $heading_title; ?></div>
                    			<div class="prod_name "><?php print $product['name']; ?></div>
                    			<div class="price"><?php print str_replace("£", "&pound;", $product['price']); ?></div>
                                <a href="javascript:void(0)" class="add_to_wardrobe" onclick="addToWishList('<?php echo $product['product_id']; ?>');">
                                    + My Wardrobe
                                </a>
                   			</div>
                    	</div>
                    </div>            
            <?php 
            	}
            }
            else 
            { 
            ?>
                <?php echo $text_empty; ?>
            <?php 
            }
            ?>
		</div>
	</div>
</div>
<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>

<script>

  /* Custom scroll */

  function iScrollInit(){

	var myScroll;


	myScroll = new IScroll('.scrollable-area', {
	  scrollbars: true,
	  mouseWheel: true,
	  interactiveScrollbars: true,
	  shrinkScrollbars: 'scale',
	  fadeScrollbars: false
	});

  }

  if (window.screen.width > 991) {
	iScrollInit();
  }

</script>
