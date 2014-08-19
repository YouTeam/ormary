<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>

<div class="container content my_wardrobe_page">
    <?php echo $content_top; ?>
    <h4>My wardrobe</h4>
    
    <div class="col-md-3 clearfix aside my_wardrobe_aside light_font">
    	<?php
        if($collection_id == 0)
        {
       		print '<a href="'.$this->url->link('account/wishlist', 'collection_id=0', 'SSL').'" class="active">'.$collections_list['unsorted']['collection_name'].'<span class="redtext">'.$collections_list['unsorted']['count'].'</span></a>';
        }
        else
        {
        	print '<a href="'.$this->url->link('account/wishlist', 'collection_id=0', 'SSL').'">'.$collections_list['unsorted']['collection_name'].'<span class="redtext">'.$collections_list['unsorted']['count'].'</span></a>';
       	}
        
        unset($collections_list['unsorted']);
        ?>
        <div class="title">
        	My colections
        </div>
        <?php 
        foreach($collections_list as $c)
        {	
        	if($c['collection_id'] != $collection_id)
            {
            	print '<a href="'.$this->url->link('account/wishlist', 'collection_id='.$c['collection_id'], 'SSL').'">'.$c['collection_name'].'<span>'.$c['count'].'</span></a>';
            }
            else
            {
            	print '<a href="'.$this->url->link('account/wishlist', 'collection_id='.$c['collection_id'], 'SSL').'" class="active">'.$c['collection_name'].'<span class="remove open_remove_collection" id="">Remove</span><span>'.$c['count'].'</span></a>';
            }
        }
        ?>
        <a href="#" class="cnc open_create_collection"><span class="plus">+</span>Create  new  collection</a>
    </div>
    
    
    
    
    <?php if ($products) { ?>
    	<div class="col-md-9 clearfix nopadding section">
    		<?php foreach ($products as $product) { ?>
    			<div class="col-md-4 col-sm-4 col-xs-6 clearfix">
                    <div class="product_wrap">
                    	<div class="product" >
                    		<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"></a>
                    		<div class="designer_name"><?php echo $product['manufacturer']; ?></div>
                    		<div class="prod_name light_font"><?php echo $product['name']; ?></div>
                    		<div class="price"><?php echo str_replace("£", "&pound;", $product['price']); ?></div>
                    		<select name="" id="move_to_collection"  onchange="moveToWishListCollection('<?php echo $product['product_id']; ?>', this.value)">
                    			<option value="">Add to collection</option>
                                <?php
                                foreach($collections_list as $c)
                                {	
                                    if($c['collection_id'] != $collection_id)
                                    {
                                        print '<option value="'.$c['collection_id'].'">'.$c['collection_name'].'</option>';
                                    }
                                }
                                ?>
                    		</select>
                            <input type="hidden" id="product_id" value="<?php echo $product['product_id']; ?>"/>
                            <a href="#" class="view_recommended">
                            	<img src="catalog/view/theme/ormary/images/view_recommended.png" alt="View Recommended">
                            </a>
                             <a href="javascript:void(0)" class="" onclick="removeFromWishList('<?php echo $product['product_id']; ?>', '<?php echo $collection_id; ?>');">
                          		remove
                        	</a>
                    	</div>
                    </div>
                </div>
            <?php }?>
        </div>
    <?php }?>
</div>

<?php echo $content_bottom; ?>


<div class="popup" style=""></div>

<div class="related_popup">
    <div class="product_wrap">
        <div class="product">
            <a href="#">
                <img src="images/test-img1.png" alt="1">
            </a>
            <div class="designer_name">Designer Name</div>
            <div class="prod_name light_font">Product name</div>
            <div class="price">£ 30</div>
            <select name="" id="">
                <option value="">Add to collection</option>
            </select>
        </div>
    </div>
    <div class="recommended">
        <h4>Recommended <span class="number">6</span></h4>
        <a href="#" class="rec_product">
            <div class="rec_product_img">
                <img src="images/rec-test-img.png" alt="">
            </div>
            <div class="rec_product_info">
                <div>Designer name</div>
                <div class="light_font">Product name</div>
                <div>£ 99</div>
            </div>
        </a>
    </div>
    <a href="#" class="close_popup"></a>
</div>

<div class="create_collection">
    <div class="caption text-center">
    	Name your collection
    </div>
    <div class="middle">
        <form action="">
            <label>
            	<span>Title <span class="required">*</span></span>
            	<input type="text" required="" name="collection_name" id="collection_name">
            </label>
        </form>
    </div>
    <div class="bottom_btn">
        <a href="javascript:void(0)" class="light_btn" id="create_collection_reject">no</a>
        <a href="javascript:void(0)" class="light_btn" onclick="addWishlistCollection();">yes</a>
    </div>
    <a href="#" class="close_popup"></a>
</div>
        
<div class="remove_collection">
    <div class="caption text-center">
    	Are you sure you want to remove this collection?
    </div>
    <div class="bottom_btn">
    	<a href="javascript:void(0)" class="light_btn" id="remove_collection_reject">no</a>
    	<a href="javascript:void(0)" class="light_btn" onclick="removeWishlistCollection('<?php print $collection_id;?>');">yes</a>
    </div>
    <a href="#" class="close_popup"></a>
</div> 

<?php echo $footer; ?>