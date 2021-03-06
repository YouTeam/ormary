<?php echo $header; ?>
<?php echo $content_top; ?>
<?php if ($attention) { ?>
<div class="attention"><?php echo $attention; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
<!--<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>-->



<div class="container cart">
	<h3 class="text-center">BAG</h3>
	<div class="table_head clearfix">
		<div class="first_title">Item</div>
        <div>Quantity</div>
        <div>Price</div>
        <div>&nbsp;</div>
        <div class="subtotal">Subtotal</div>
	</div>
    

	<?php foreach ($products as $product) { ?>   
        <div class="table_row clearfix">
            <div class="checkbox">
                <input type="checkbox" class="product_select_checkbox" value="<?php print $product['product_id'];?>">
            </div>
            <div class="product_img">
            	<a href="<?php echo $product['href']; ?>">
                	<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
                </a>
            </div>
            <div class="product_info">
                <ul>
                    <li class="cart_designer_name"><?php echo $product['manufacturer']; ?></li>
                    <li class="cart_product_name"><?php echo $product['name']; ?></li>
                    
                    <?php foreach ($product['option'] as $option) { ?>
                        <li>
                        	<span class="greytext"><?php echo $option['name']; ?>: </span><?php echo $option['value']; ?>
                        </li>
                	<?php } ?>    
                </ul>
            </div>
            <div class="quantity">
                 <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="cart_quantity">
                    <select name="quantity[<?php echo $product['key']; ?>]" id="" class="form-control" onchange="$(this).parent().submit();">
                    	<?php 
                        for($i=1; $i<=10; $i++)
                        {
							if($i != $product['quantity'])
                            { 
                            	print '<option value="'.$i.'">'.$i.'</option>';
                            }
                            else
                            {
                            	print '<option value="'.$i.'" selected="selected">'.$i.'</option>';
                            }
                        }
                        ?>
                        </select>
                </form>
            </div>
            <div class="price">
            	<?php echo $product['price']; ?>
            </div>
            <div class="edit">
                <a href="<?php echo $product['remove']; ?>">
                    <img src="catalog/view/theme/ormary-new/images/del.png" alt="Remove">
                </a>
            </div>
            <div class="total-price">
           		<?php echo $product['total']; ?>
            </div>
        </div>
	<?php }?>


    <div class="table_footer">
        <label><input type="checkbox" id="cart_select_all">Select all</label>
        <a href="<?php echo $action;?>" id="cart_remove_selected">Remove selected</a>
        <a href="<?php echo $action;?>" id="cart_move_to_wardrobe_selected">Move to Wardrobe</a>
        <span class="total grand_total">Grand Total : <span><?php echo $total_cart_price; ?></span></span>
    </div>
    <div class="bottom_btns">
        <a href="<?php echo $checkout; ?>" class="dark_btn open_shipping_address">PROCEED TO CHECKOUT</a>
        <a href="<?php echo $continue; ?>" class="light_btn continue_shopping">CONTINUE SHOPPING</a>
    </div>
</div>

<?php echo $content_bottom; ?>
<?php echo $footer; ?>



	


  
<script type="text/javascript"><!--
$('input[name=\'next\']').bind('change', function() {
	$('.cart-module > div').hide();
	
	$('#' + this.value).show();
});
//--></script>
<?php if ($shipping_status) { ?>
<script type="text/javascript"><!--
$('#button-quote').live('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/quote',
		type: 'post',
		data: 'country_id=' + $('select[name=\'country_id\']').val() + '&zone_id=' + $('select[name=\'zone_id\']').val() + '&postcode=' + encodeURIComponent($('input[name=\'postcode\']').val()),
		dataType: 'json',		
		beforeSend: function() {
			$('#button-quote').attr('disabled', true);
			$('#button-quote').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('#button-quote').attr('disabled', false);
			$('.wait').remove();
		},		
		success: function(json) {
			$('.success, .warning, .attention, .error').remove();			
						
			if (json['error']) {
				if (json['error']['warning']) {
					$('#notification').html('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
					$('.warning').fadeIn('slow');
					
					$('html, body').animate({ scrollTop: 0 }, 'slow'); 
				}	
							
				if (json['error']['country']) {
					$('select[name=\'country_id\']').after('<span class="error">' + json['error']['country'] + '</span>');
				}	
				
				if (json['error']['zone']) {
					$('select[name=\'zone_id\']').after('<span class="error">' + json['error']['zone'] + '</span>');
				}
				
				if (json['error']['postcode']) {
					$('input[name=\'postcode\']').after('<span class="error">' + json['error']['postcode'] + '</span>');
				}					
			}
			
			if (json['shipping_method']) {
				html  = '<h2><?php echo $text_shipping_method; ?></h2>';
				html += '<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">';
				html += '  <table class="radio">';
				
				for (i in json['shipping_method']) {
					html += '<tr>';
					html += '  <td colspan="3"><b>' + json['shipping_method'][i]['title'] + '</b></td>';
					html += '</tr>';
				
					if (!json['shipping_method'][i]['error']) {
						for (j in json['shipping_method'][i]['quote']) {
							html += '<tr class="highlight">';
							
							if (json['shipping_method'][i]['quote'][j]['code'] == '<?php echo $shipping_method; ?>') {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" checked="checked" /></td>';
							} else {
								html += '<td><input type="radio" name="shipping_method" value="' + json['shipping_method'][i]['quote'][j]['code'] + '" id="' + json['shipping_method'][i]['quote'][j]['code'] + '" /></td>';
							}
								
							html += '  <td><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['title'] + '</label></td>';
							html += '  <td style="text-align: right;"><label for="' + json['shipping_method'][i]['quote'][j]['code'] + '">' + json['shipping_method'][i]['quote'][j]['text'] + '</label></td>';
							html += '</tr>';
						}		
					} else {
						html += '<tr>';
						html += '  <td colspan="3"><div class="error">' + json['shipping_method'][i]['error'] + '</div></td>';
						html += '</tr>';						
					}
				}
				
				html += '  </table>';
				html += '  <br />';
				html += '  <input type="hidden" name="next" value="shipping" />';
				
				<?php if ($shipping_method) { ?>
				html += '  <input type="submit" value="<?php echo $button_shipping; ?>" id="button-shipping" class="button" />';	
				<?php } else { ?>
				html += '  <input type="submit" value="<?php echo $button_shipping; ?>" id="button-shipping" class="button" disabled="disabled" />';	
				<?php } ?>
							
				html += '</form>';
				
				$.colorbox({
					overlayClose: true,
					opacity: 0.5,
					width: '600px',
					height: '400px',
					href: false,
					html: html
				});
				
				$('input[name=\'shipping_method\']').bind('change', function() {
					$('#button-shipping').attr('disabled', false);
				});
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
<?php } ?>

