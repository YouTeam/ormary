<?php echo $header; ?>
<?php echo $content_top; ?>

<div id="content" class="container content">
  <!--<h4><?php echo $heading_title; ?></h4>-->
  
    <h4>
        Search for: 
        <div class="search_span">
            <span><?php print $search_phrase;?></span>
            <a href="javascript:void(0)" class="open_search_input">
                <img src="catalog/view/theme/ormary/images/pencil.png" alt="Edit">
            </a>
        </div>
        <div class="search_input">
        	<form id="orm_search_word">
            	<input type="text" class="light_font s_input" name="search_phrase" value="<?php print $search_phrase;?>">
            	<input type="submit" value="">
            </form>
        </div>
        
        <div class="quantity_elements light_font" style="display:inline-block;">
        	<span><?php print $total_products;?></span> items found
      	</div>
    </h4>
  
  <span class="sort_by">Sort by</span>
  <div class="col-md-3 clearfix aside clothing_aside">
  	<?php echo $column_left; ?>
  </div>
  
<!--  <?php if ($categories) { ?>
 	 <h2><?php echo $text_refine; ?></h2>
  <div class="category-list">
    <?php if (count($categories) <= 5) { ?>
    <ul>
      <?php foreach ($categories as $category) { ?>
        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <?php for ($i = 0; $i < count($categories);) { ?>
    <ul>
      <?php $j = $i + ceil(count($categories) / 4); ?>
      <?php for (; $i < $j; $i++) { ?>
      <?php if (isset($categories[$i])) { ?>
      <li><a href="<?php echo $categories[$i]['href']; ?>"><?php echo $categories[$i]['name']; ?></a></li>
      <?php } ?>
      <?php } ?>
    </ul>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>-->
  
  
  <?php if ($products) { ?>
  
	<div class="col-md-9 clearfix nopadding">
    	<div class="clothing_top_panel clearfix">
  			<form id="orm_sort_filter" action="">
                <div class="col-md-6 clearfix">
                    <div class="wrap_sort_by_newest">
                        <select name="sort" id="" class="sort_by_newest form-control"> <!-- nchange="location = this.value;"-->
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
                        
                        <div class="designer_name"><?php print $product['manufacturer_name']; ?></div>
                        
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
			<?php } ?>
		</div>

	</div>


	<?php }
    else
    {
     ?>
	
    <?php //if (!$categories && !$products) { ?>
        <div class="col-md-9 clearfix nopadding">
        	<div class="no_results">
        		<div class="caption">
                	Sorry, no results matched your search request.
                </div>
                <div class="suggestions light_font">
                	<p>Suggestions:</p>
                	<p>1. Make sure all words are spelled correctly.</p>
                	<p>2. Reduce filter condition for more results.</p>
                	<p>3. Try other keywords.</p>
                </div>
        	</div>
        </div>

<!--        <div class="content"><?php echo $text_empty; ?></div>
        <div class="buttons">
            <div class="right">
                <a href="<?php echo $continue; ?>" class="button">
                    <?php echo $button_continue; ?>
                </a>
            </div>
        </div>    -->
        
        
    <?php } ?>

	</div></div>
    
   <?php echo $content_bottom; ?>
   <?php echo $footer; ?> 
<script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');
		
		$('.product-list > div').each(function(index, element) {
			html  = '<div class="right">';
			html += '  <div class="cart">' + $(element).find('.cart').html() + '</div>';
			html += '  <div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
			html += '  <div class="compare">' + $(element).find('.compare').html() + '</div>';
			html += '</div>';			
			
			html += '<div class="left">';
			
			var image = $(element).find('.image').html();
			
			if (image != null) { 
				html += '<div class="image">' + image + '</div>';
			}
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<div class="price">' + price  + '</div>';
			}
					
			html += '  <div class="name">' + $(element).find('.name').html() + '</div>';
			html += '  <div class="description">' + $(element).find('.description').html() + '</div>';
			
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
				
			html += '</div>';
						
			$(element).html(html);
		});		
		
		$('.display').html('<b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display(\'grid\');"><?php echo $text_grid; ?></a>');
		
		$.totalStorage('display', 'list'); 
	} else {
		$('.product-list').attr('class', 'product-grid');
		
		$('.product-grid > div').each(function(index, element) {
			html = '';
			
			var image = $(element).find('.image').html();
			
			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}
			
			html += '<div class="name">' + $(element).find('.name').html() + '</div>';
			html += '<div class="description">' + $(element).find('.description').html() + '</div>';
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<div class="price">' + price  + '</div>';
			}
			
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
						
			html += '<div class="cart">' + $(element).find('.cart').html() + '</div>';
			html += '<div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
			html += '<div class="compare">' + $(element).find('.compare').html() + '</div>';
			
			$(element).html(html);
		});	
					
		$('.display').html('<b><?php echo $text_display; ?></b> <a onclick="display(\'list\');"><?php echo $text_list; ?></a> <b>/</b> <?php echo $text_grid; ?>');
		
		$.totalStorage('display', 'grid');
	}
}

view = $.totalStorage('display');

if (view) {
	display(view);
} else {
	display('list');
}
//--></script> 
<script>
  $(document).ready(function(){
	$('.open_search_input').on('click',function(){

	  var valueResult = $(this).siblings('span').text();

	  $(this).parent().hide();
	  $(this).parent().siblings('.search_input').show().css('display','inline-block');
	  $(this).parent().siblings('.search_input').children('.s_input').attr('value', valueResult);
	});
  });
</script>
