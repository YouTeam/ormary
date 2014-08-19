<?php echo $header; ?>

<div id="content" class="container content orm_designer_page">
<?php echo $content_top; ?>
    <div class="breadcrumbs clearfix">
	  <ul>
		<li><a href="<?php echo $this->url->link('product/manufacturer');?>">All designers</a></li>
		<li><a href="<?php echo $this->url->link('product/manufacturer/info', 'manufacturer_id='.$this->request->get['manufacturer_id']);?>" class="active"><?php echo $heading_title ?></a></li>
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
    <div class="orm_designer_info_wrap clearfix" >
        <div class="orm_designer_info">
        	<div class="orm_designer_logo">
        		<img src="<?php echo $this->url->img_link($image); ?>" alt="<?php echo $heading_title; ?>" data-pin-no-hover="true">
        	</div>
       		<div class="orm_designer_content">
        		<div class="orm_designer_content_inner">
        			<div class="orm_designer_name"><?php echo $heading_title; ?></div>
        			<div class="orm_designer_about light_font"><?php print $manufacturer_description;?>
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
        		</div>
        	</div>
        </div>
    </div>

  
 <span class="sort_by">Sort by</span>
   <div class="col-md-3 clearfix aside clothing_aside">
   
   
   <form action="" id="orm_filter">
   
	<input type="hidden" value="<?php print $mid;?>" id="" name="manufacturer_id">
    <fieldset>
     <ul class="filter-clothing filter-clothing-womens">
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
    
    <fieldset>
        <div class="filter_title">
            Release date
        </div>
        <select name="rd_month" id="" class="month_select form-control">
            <?php print $filter_options['month_list'];?>
        </select>
        
		<select name="rd_year" id="" class="year_select form-control">
        	<?php print $filter_options['years_list'];?>
        </select>
    </fieldset>
	</form>
	</div>
    
   <?php if ($products) { ?>  
    <div class="col-md-9 clearfix nopadding">
          <div class="clothing_top_panel clearfix">
				
                <form id="orm_sort_filter" action="">
                    <div class="col-md-6 clearfix">
                        <div class="wrap_sort_by_newest">
                            <select name="sort" id="" class="sort_by_newest form-control">
                                <?php foreach ($sorts as $sorts) { ?>
                                    <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                                        <option value="<?php echo $sorts['value']; ?>" selected="selected"><?php echo "Sort by ".$sorts['text']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $sorts['value']; ?>"><?php echo "Sort by ".$sorts['text']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                         </div>
                    </div>
                    
                    <div class="col-md-6 clearfix">
                        <div class="wrap_pagination">
                            
                            <?php echo $pagination; ?>
                            
                            <div class="wrap_items_on_page">
                                <span class="light_font">Items on page</span>
                                <select name="limit" id="" class="items_on_page form-control"> 
                                <!-- onchange="location = this.value;" -->
                                    <?php foreach ($limits as $limits) { ?>
                                        <?php if ($limits['value'] == $limit) { ?>
                                            <option value="<?php echo $limits['value']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $limits['value']; ?>"><?php echo $limits['text']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            
          </div>

          
        <div class="section">
         	<?php foreach ($products as $product) { ?>
        	<div class="col-md-4 col-sm-4 col-xs-6 clearfix">
        		<div class="product_wrap">
        			<div class="product">
                    
        				<?php if ($product['thumb']) { ?>
                        	<a href="<?php print $product['href']; ?>">
                            	<img src="<?php print $product['thumb']; ?>" title="<?php print $product['name']; ?>" alt="<?php echo $product['name']; ?>" />
                            </a>
                        <?php } ?>
                        
                        <div class="designer_name"><?php print $heading_title; ?></div>
                        
        				<div class="prod_name light_font">
                        	<?php print $product['name']; ?>
                        </div>
                        
        				<?php if ($product['price']) { ?>
                        	<div class="price"><?php print str_replace("£", "&pound;", $product['price']); ?></div>
                        <?php } ?>
 
                        <a href="javascript:void(0)" class="add_to_wardrobe" onclick="addToWishList('<?php echo $product['product_id']; ?>');">
                        	<img src="catalog/view/theme/ormary/images/add_to_wardrobe.png" alt="+ wardrobe">
                        </a>
 
        			</div>
        		</div>
       		</div>
            <?php }?>
        </div>
        
	</div>
    
    <?php 
    	}
    	else 
        { 
    ?>
  <div class="col-md-9 clearfix nopadding section"><?php echo $text_empty; ?></div>
  <?php }?>
  </div>
  
  <?php echo $content_bottom; ?></div>
  <?php echo $footer; ?>

