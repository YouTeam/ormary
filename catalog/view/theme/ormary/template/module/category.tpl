<!--<script type="text/javascript">
	changeCat = function(event)
	{
	location.href = $(event).attr('data-value');
	}
</script>-->
<form action="" id="orm_filter">

    <fieldset>
<!--         <div class="tabs">
            <a href="#" class="womens_tab active">Womens</a>
            <a href="#" class="mens_tab">Mens</a>
          </div>-->
<!--    <?php foreach ($categories as $category) { ?>
        <?php if ($category['category_id'] == $category_id) { ?>
            <?php if ($category['children']) { ?>
                <ul class="filter-clothing filter-clothing-womens">
                    <?php foreach ($category['children'] as $child) { ?>
                        <li class="light_font" data-value="<?php echo $child['href']; ?>"> <!--onClick="changeCat(this)">
                            <?php if ($child['category_id'] == $child_id) { ?>
                                <input type="radio" name="clothing" id="w<?php echo $child['name']; ?>" checked="checked">
                                <label class="filter-label" for="w<?php echo $child['name']; ?>">
                                    <?php echo $child['name']; ?>
                                </label>
                            <?php } else { ?>
                                <input type="radio" name="clothing" id="w<?php echo $child['name']; ?>">
                                <label class="filter-label" for="w<?php echo $child['name']; ?>">
                                    <?php echo $child['name']; ?>
                                </label>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>
    <?php } ?>-->
    
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
            Release date
        </div>
        <select name="rd_month" id="" class="month_select form-control">
            <?php print $filter_options['month_list'];?>
        </select>
        
		<select name="rd_year" id="" class="year_select form-control">
        	<?php print $filter_options['years_list'];?>
        </select>
    </fieldset>
    
    
    
<fieldset>
    <div class="filter_title">
    	Color
    </div>
    <ul class="filter-colors">
    	<?php print $filter_options['colors_list'];?>
    </ul>
    <input type="hidden" name="color" id="color" value="<?php print $filter_options['colors_input_value'];?>"/>
</fieldset>    


<fieldset>
    <div class="filter_title">
    	Size
    </div>
    <ul class="filter-clothing filter-clothing-sizes">
        <?php print $filter_options['sizes_list'];?>
    </ul>
</fieldset>


</form>





