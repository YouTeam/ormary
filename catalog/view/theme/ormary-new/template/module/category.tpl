<form action="" id="orm_filter">
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

    <fieldset>
        <div class="filter_title">
        	Designers
        </div>
    	<div class="designer-search-wrap">
            <input name="designer_name" type="text" placeholder="Type designer name" value="<?php print $filter_options['designer_name'];?>">
    		<div class="scrollable-area">
                <ul class="filter-clothing filter-designers">
					<?php print $filter_options['designers_list']; ?>
                </ul>
    		</div>
   		</div>
    </fieldset>

    <fieldset>
        <div class="filter_title">
        	Color
        </div>
        <ul class="filter-clothing filter-clothing-colors ">
			<?php print $filter_options['colors_list'];?>
        </ul>
        <!--<input type="hidden" name="color" id="color" value="<?php print $filter_options['colors_input_value'];?>"/>-->
    </fieldset>
    
    <fieldset>
        <div class="filter_title">
        	Size
        </div>
        <ul class="filter-clothing filter-clothing-sizes">
			<?php print $filter_options['sizes_list'];?>
        </ul>
    </fieldset>
    <input type="hidden" name="page" id="page" value="catalog"/>
	<input type="hidden" id="catId" value="<?php print $filter_options['category_id'];?>"/>
    <?php
    if(isset($filter_options['featured']))
    {
    ?>
    	<input type="hidden" name="featured" value="1"/>        
    <?php
   	}
    ?>
    <a href="<?php print $filter_options['clear_filter'];?>" class="dark_btn clear_filter_btn">Clear  all filters</a>
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


      /* Items counter */

      var $i= $('.product_wrap').length;

      $('.count_items .number').text($i);

    </script>
	
</form>