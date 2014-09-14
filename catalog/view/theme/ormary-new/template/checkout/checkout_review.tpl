<?php echo $header; ?>
<?php echo $content_top; ?>


<div class="container cart review">
    <h3 class="text-center">BAG</h3>
    <div class="steps clearfix">
        <div class="col-xs-4 wrap-step">
        	<a href="<?php print $shipping_link;?>" class="step">1. shipping</a>
        </div>
        <div class="col-xs-4 wrap-step">
        	<a href="<?php print $payment_link;?>" class="step">2. payment</a>
        </div>
        <div class="col-xs-4 wrap-step active">
        	<a href="javascript:void(0)" class="step">3. review</a>
        </div>
    </div>
    <div class="table_head clearfix">
        <div class="first_title">
        	Cart contents
        </div>
        <div>Quantity</div>
        <div class="subtotal">
        	Price
        </div>
    </div>
    <?php
    foreach($products as $product)
    {
    ?>
        <div class="table_row clearfix">
            <div class="product_img">
                <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
            <div class="product_info">
                <ul>
                    <li><?php print $product['manufacturer'];?></li>
                    <li><?php print $product['name'];?></li>
                    
                    <?php foreach ($product['option'] as $option) { ?>
                        <li>
                        	<span class="greytext"><?php echo $option['name']; ?>: </span><?php echo $option['value']; ?>
                        </li>
                	<?php } ?> 
                    
                </ul>
            </div>
            <div><?php print $product['quantity'];?></div>
            <div class="total-price">
                <?php print $product['total'];?>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="shipping_cost clearfix">
        <div class="name">
            Shipping cost
        </div>
        <div class="total-price">
            <?php print $shipping_price;?>
        </div>
    </div>
    <div class="grand_total clearfix">
        <div class="name">
            Grand total
        </div>
        <div class="total-price">
            <?php print $order_price;?>
        </div>
    </div>
    <div class="clearfix row">
        <div class="col-sm-6">
            <div class="billing_address">
                <div class="caption text-center">
                    <span>
                        <img src="catalog/view/theme/ormary-new/images/frs.png" alt="">
                    </span>
                    Shipping address
                </div>
                <div class="content">
                    <?php print $shipping_firstname.' '.$shipping_lastname;?> <br>
                    <?php print $shipping_address_1;?><br>
                    <?php print $shipping_address_2;?><br>
                    <?php print $shipping_city;?><br>
                    <?php print $shipping_zone;?><br>
                    <?php print $shipping_postcode;?><br>
                    <?php print $shipping_country;?><br>
                    <div class="separate"></div>
                    FLAT RATE SHIPPING: <?php print $shipping_price;?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="billing_address">
                <div class="caption text-center">
                    <span>
                        <img src="catalog/view/theme/ormary-new/images/billing.png" alt="">
                    </span>
                    Billing address
                </div>
                <?php
                if($payment_method == 'card')
                {
                ?>
                    <div class="content">
                        <?php print $billing_firstname.' '.$shipping_lastname;?> <br>
                        <?php print $billing_address_1;?><br>
                        <?php print $billing_address_2;?><br>
                        <?php print $billing_city;?><br>
                        <?php print $billing_zone;?><br>
                        <?php print $billing_postcode;?><br>
                        <?php print $billing_country;?><br>
                        <div class="separate"></div>
                        <img src="catalog/view/theme/ormary-new/images/credit_card.png" alt="Credit card">
                    </div>   
                    <form action="<?php print $action_link;?>" id="card_form" method="post">
                        <input type="hidden" name="action" value="process_checkout"/>
                    </form>                       
                <?php
                }
                elseif($payment_method == 'paypal')
                {
                ?>
                    <div class="content">
                            Paying with a paypal <br>
                            <div class="separate"></div>
                            <img src="catalog/view/theme/ormary-new/images/paypal.png" alt="PayPal">
                    </div>
                    <?php
                    	print $payment_paypal_form;
                    ?>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="gift">
        <a href="#" id="gift">Is the a gift? Write a personal message</a>
        <div id="gift-ta">
            <textarea name="comment"></textarea>
        </div>
    </div>

    <div class="clearfix">
    	<div style="float:left; font-size:15px; margin-top:20px;">
        	<input type="checkbox" id="terms" value="0" name="terms"> <label for="terms">I agree to Ormary.com <a href="/terms_and_conditions">Terms and conditions</a> and <a href="/privacy_policy">Privacy Policy</a></label>
            <div id="terms-error" style="display: none;" class="alert_error">To complete registration, you must agree to Ormary Terms and Conditions and Privacy Policy</div>
        </div>
        <div class="bag-bottom clearfix">
        	<?php
            if($payment_method == 'card')
            {
            ?>
				<a href="javascript:void(0)" class="dark_btn" id="pay_card">CONFIRM AND PAY</a><!--onclick="$('#card_form').submit();" -->
            <?php
            }
            elseif($payment_method == 'paypal')
            {
            ?>
				<a href="javascript:void(0)" class="dark_btn" id="pay_paypal">CONFIRM AND PAY</a><!-- onclick="$('#paypal_form').submit();"-->
            <?php
            }
            ?>            
        </div>
    </div>
</div>
    
<?php echo $content_bottom; ?>
<?php echo $footer; ?>
