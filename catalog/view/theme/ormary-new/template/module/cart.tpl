
<li class="open_cart_dropdown">
    <a href="index.php?route=checkout/cart" class="cart">
        <span>BAG</span>
        <span class="number total" id="cart_header_price"><?php echo str_replace('£', '&pound', $total_price); ?></span>
        <b class="caret"></b>
    </a>
    <div class="cart_dropdown" id="cart">
        <ul class="clearfix">
        	<?php 
            	if($products)
                {
            		foreach ($products as $product) 
                    {                 
            ?>
                <li class="clearfix">
                    <div class="product_img">
                    <?php if ($product['thumb']) { ?>
            			<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
            		<?php } ?>
                        
                    </div>
                    <div class="product_name "><?php echo $product['name']; ?></div>
                    <div class="quantity ">x<?php echo $product['quantity']; ?></div>
                    <div class="price"><?php echo str_replace('£', '&pound', $product['price']); ?></div>
                    <a href="javascript:void(0)" class="del" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $product['key']; ?>' : $('#cart').load('index.php?route=module/cart&remove=<?php echo $product['key']; ?>' + ' #cart > *', function(){ $('.open_cart_dropdown #cart_header_price').html($('#cart span.total #cart_price').html());});">
                        <img src="catalog/view/theme/ormary-new/images/del.png" alt="del">
                    </a>
                </li>
			<?php 
            		}
            	} else {
              
                ?>
                <div class="emptybag">
                <h3 >Your Bag Is Empty.<br><br>:(</h3>
                
                <a href="/index.php?route=product/category&path=0&featured=1">SHOP WHATS NEW</a>
                </div>
                <?php
                
                
                }
                ?>   
        </ul>
        <?php
        	if($products)
                {
                ?>
        <div class="cart_dropdown_bottom">
            <span class="total">
                <span class="">Total </span><span id="cart_price"><?php echo str_replace('£', '&pound', $total_price); ?></span>
            </span>
            <div class=" emptybag">
                <a class="minicartcheckout" href="<?php print $this->url->link('checkout/cart');?>">Checkout</a>
                <!--<a href="<?php print $this->url->link('checkout/checkout');?>">Shipping and  Payment</a>-->
            </div>
        </div>
    </div>
    <?php } ?>
</li>

