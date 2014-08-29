<?php echo $header; ?>
<?php echo $content_top; ?>


<div id="content" class="container content">
    <div class="top_panel clearfix">
        <div class="caption_with_counter">
        	<?php if($search_phrase == ""){?>
        	<h4><?php print $heading_title; ?></h4>
        	<span class="count_items">
        		<span class="number"><?php print $total_products;?></span> 
        		items
        	</span>
            <?php
            }
            else
            {
            ?>
            <h4>SEARCH FOR: <span><?php print $search_phrase;?></span></h4>
            <span class="count_items">
              Found 
              <span class="number"><?php print $total_products;?></span> 
               items
            </span>
            <?php }?>
        </div>
        <div class="wrap_pagination">
        	<?php echo $pagination; ?>
        </div>
      <!--
  <div class="wrap_items_on_page">
            <form action="" id="orm_count_filter">
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
-->
	</div>
	<a href="javascript:void(0);" class="sort_by">Sort by</a>
  
    <div class="col-md-2 clearfix aside clothing_aside">
    	<?php echo $column_left; ?>
    </div>
  
    <div class="col-md-10 clearfix nopadding">
    	<div class="section clearfix">
    		<?php if ($products) { ?>

            	<?php foreach ($products as $product) { ?>

                    <div class="col-md-4 col-sm-4 col-xs-6 clearfix">
                        <div class="product_wrap">
                            <div class="product">
                            	<?php if ($product['thumb']) { ?>
                                	<a href="<?php print $product['href']; ?>">
                                    	<img class="swapimg" src="<?php print $product['thumb']; ?>" alt="<?php print $product['name']; ?>" title="<?php print $product['name']; ?>" data-swap="<?php print $product['extraimage']; ?>" />
                                    </a>
                                <?php } ?>    
                                <div class="designer_name"><?php print $product['manufacturer_name'];?></div>
                                <div class="prod_name"><?php print $product['name']; ?></div>
                                <?php if ($product['price']) { ?>
                                	<div class="price"><?php print str_replace("£", "&pound;", $product['price']); ?></div>
                                <?php } ?>
                                <a href="javascript:void(0)" class="add_to_wardrobe" onclick="addToWishList('<?php echo $product['product_id']; ?>');">
                                	+ My Wardrobe
                                </a>
                            </div>
                        </div>
                    </div>
            	<?php } ?>
            <?php 
            	} 
             	else 
                {
             ?>
                <div class="no_results">
                    <div class="caption">
                    	Sorry, no results matched your search request.
                    </div>
                    <div class="suggestions">
                    	<p>Suggestions:</p>
                    	<p>1. Make sure all words are spelled correctly.</p>
                    	<p>2. Reduce filter conditions for more results.</p>
                    	<p>3. Try other keywords.</p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="wrap_pagination">
        	<?php echo $pagination; ?>
        </div>
    </div>
</div>
    
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




  /* Items counter */

  var $i= $('.product_wrap').length;

  $('.count_items .number').text($i);

</script>