<?php echo $header; ?>
<?php echo $content_top; ?>

<div class="container cart">
    <h3 class="text-center">CHECKOUT</h3>
    <div class="steps clearfix">
        <div class="col-xs-4 wrap-step">
            <a href="<?php print $shipping_link;?>" class="step">1. shipping</a>
        </div>
        <div class="col-xs-4 wrap-step active">
            <a href="javascript:void(0)" class="step">2. payment</a>
        </div>
        <div class="col-xs-4 wrap-step">
            <a href="javascript:void(0)" class="step">3. review</a>
        </div>
    </div>
    
    <div class="choose_payment clearfix">
        <h5>
            Choose your payment method
        </h5>
        <form action="<?php print $form_action;?>" method="post" id="payment_form">
        	 <input type="hidden" name="type" value="paypal" />
            <div class="csa clearfix">
                <label class="csa-label clearfix">
                    <div class="csa-checkbox">
                        <input type="radio" id="firstPayment" name="choose_payment" value="paypal" <?php if($payment_method == 'paypal'){ print 'checked';}?>/>
                    </div>
                    <div class="csa-payment">
                        <div class="paypal-payment payment-type <?php if($payment_method == 'paypal'){ print 'active';}?> clearfix">
                            <img src="catalog/view/theme/ormary-new/images/paypal.png" alt="PayPal">
                            <span>PAY PAL</span>
                        </div>
                    </div>
                </label>
                <div class="pay-with-paypal" <?php if($payment_method == 'paypal'){ print 'style="display:block;"';}?>>
                    <span>To pay with PayPal, simply click</span> 
                    <?php                    
                    if($show_card_form)
                	{
                    ?>
                    	<a href="javascript:void(0)" onclick="$( '#submit' ).trigger( 'click' );" class="dark_btn">Next step</a>
                    <?php
                    }
                    else
                    {
                    ?>
                    	<a href="javascript:void(0)" onclick="$('#payment_form').submit();" class="dark_btn">Next step</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="csa clearfix">
                <label class="csa-label clearfix">
                    <div class="csa-checkbox">
                        <input type="radio" id="secondPayment" name="choose_payment" <?php if($payment_method != 'paypal'){ print 'checked';}?> value="card" />
                    </div>
                    <div class="csa-payment">
                        <div class="creditcard-payment payment-type <?php if($payment_method != 'paypal'){ print 'active';}?> clearfix">
                            <img src="catalog/view/theme/ormary-new/images/credit_card.png" alt="Credit card">
                            <span>CREDIT CARD</span>
                        </div>
                    </div>
                </label>
                <?php 
                if(isset($show_billing_form) && $show_billing_form == true)
                {
                ?>                	
                    <div class="cart_inputs csa-inputs clearfix" <?php if($payment_method == 'paypal'){ print 'style="display:none;"';}?> >
                        <div class="inputs_group">
                            <div class="inputs_row clearfix">
                                <div class="input_wrap">
                                    <label>
                                        <span>First name*</span>
                                        <input type="text" name="firstname" value="<?php print $firstname;?>"> 
                                        <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_firstname;?></div>
                                    </label>
                                </div>
                                <div class="input_wrap">
                                    <label>
                                        <span>Last name*</span>
                                        <input type="text" name="lastname" value="<?php print $lastname;?>">
                                        <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_lastname;?></div>
                                    </label>
                                </div>
                            </div>
                            <div class="inputs_row clearfix">
                                <div class="input_wrap">
                                    <label>
                                        <span>Country*</span>
                                        <select name="country_id"  class="form-control">
                                            <option value=""><?php echo $text_select; ?></option>
                                            <?php foreach ($countries as $c) { 
                                            	if(isset($country) && $country == $c['country_id'])
                                                {
                                            ?>
                                            		<option value="<?php echo $c['country_id']; ?>" selected="selected"><?php echo $c['name']; ?></option>
                                            <?php
                                            	}
                                            	else
                                                {
                                            ?>
                                            		<option value="<?php echo $c['country_id']; ?>"><?php echo $c['name']; ?></option>
                                            <?php 
                                            	}
                                            } 
                                            ?>
                                        </select>
                                        <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_country;?></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="inputs_group">
                            <div class="inputs_row clearfix">
                                <div class="input_wrap">
                                    <label>
                                        <span>Address 1*</span>
                                        <input type="text" name="address_1" value="<?php print $address_1;?>">
                                        <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_address_1;?></div>
                                    </label>
                                </div>
                                <div class="input_wrap">
                                    <label>
                                        <span>Address 2</span>
                                        <input type="text" name="address_2" value="<?php print $address_2;?>">
                                        <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_address_2;?></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="inputs_group">
                            <div class="inputs_row clearfix">
                                <div class="input_wrap">
                                    <label>
                                        <span>City*</span>
                                        <input type="text" name="city" value="<?php print $city;?>">
                                        <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_city;?></div>
                                    </label>
                                </div>
                                <div class="input_wrap">
                                    <label>
                                        <span>State*</span>
                                        <select name="zone_id">
                                        </select>
                                        <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_zone;?></div>
                                    </label>
                                </div>
                            </div>
                            <div class="inputs_row clearfix">
                                <div class="input_wrap">
                                    <label>
                                        <span>Postcode or ZIP<span id="postcode-required" style="display:inline;">*</span></span>
                                        <input type="text" name="postcode" value="<?php print $postcode;?>">
                                        <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_postcode;?></div>
                                    </label>
                                </div>
                                <div class="input_wrap">
                                    <label>
                                        <span>Mobile*</span>
                                        <input type="text" name="phone" value="<?php print $phone;?>">
                                        <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_phone;?></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <label class="basas">
                            <input type="checkbox" name="use_shipping_address" value="<?php print $shipping_address_id;?>">
                            Billing address same as shipping
                        </label>
                        <div class="clearfix">
                            <div class="bag-bottom clearfix">
                                <a href="javascript:void(0)" onclick="$('#payment_form').submit();" class="dark_btn">next step</a>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="save_billing_address"/>
                    </div>
                <?php
                }
                elseif($show_card_form)
                {
                ?>                	
                	<div class="creditcard-payment-info row clear-left clearfix" <?php if($payment_method == 'paypal'){ print 'style="display:none;"';}?>>
						<div class="clearfix">
							<div class="col-sm-4">
								<div class="billing_address">
									<div class="caption text-center">
										<span>
											<img src="catalog/view/theme/ormary-new/images/billing.png" alt="">
										</span>
										Billing address
									</div>
									<div class="content">
                                    	<?php 
                                            print $firstname.' '.$lastname.'<br/>';
                                            print $address_1.'<br/>';
                                            if(isset($address_2) && $address_2 != '')
                                            {
                                            	print $address_2.'<br/>';
                                            }
                                            print $city.', '.$zone_name.' '.$country_name.'<br/>';                                           
                                            
                                            print $postcode.'<br/>';
                                            print $phone.'<br/>';
                                        ?>
									</div>
									<a href="javascript:void(0)" onclick="$('#edit_billing_address').submit();" class="edit-btn">Edit</a>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="cart_inputs card_type">
									<div class="inputs_group">
										<div class="inputs_row clearfix">
                                        	<div class="input_wrap">
												<label>
													<span>Card type*</span>
													<select class="form-control" name="card_type">
                                                    	<option value=""><?php echo $text_select; ?></option>
														<?php
                                                        foreach($card_types as $key => $type)
                                                        {
                                                        	print '<option value="'.$key.'">'.$type.'</option>';
                                                       	}
                                                        ?>
													</select>
                                                    <div id="type-error" style="display: block; float:left;" class="alert_error"><?php print $error_card_type;?></div>
												</label>
											</div>
											<div class="input_wrap">
												<label>
													<span>Name on card*</span>
													<input type="text" name="card_name" value="" data-braintree-name="cardholder_name">
                                                    <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_card_name;?></div>
												</label>
											</div>
											<div class="input_wrap">
												<label>
													<span>Card number*</span>
													<input type="text"  name="card_number" value="" maxlength="27"  data-braintree-name="number">
                                                    <div id="number-error" style="display: block; float:left;" class="alert_error"><?php print $error_card_number;?></div>
												</label>
											</div>
											<div class="input_wrap">
												<label>
													<span>Expiry date*</span>
</label>
                                                    <input data-braintree-name="expiration_month" value="" name="card_month" style="width:40px;" maxlength="2">
                                                    &nbsp;/&nbsp;
  													<input data-braintree-name="expiration_year" value="" name="card_year" style="width:55px;" maxlength="4">                                                    
													
                                                    <div id="date-error" style="display: block;" class="alert_error"><?php print $error_card_date;?></div>
												
											</div>
											<div class="input_wrap">
												<label>
													<span>Security code*</span>
													<input type="text"  name="card_code" value="" maxlength="4" data-braintree-name="cvv">
                                                    <div id="code-error" style="display: block; float:left;" class="alert_error"><?php print $error_card_code;?></div>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix">
							<div class="bag-bottom clearfix">
								<a href="javascript:void(0)" onclick="if(checkCardForm()){$( '#submit' ).trigger( 'click' );}" class="dark_btn">next step</a>
                                <input type="submit" id="submit" value="Pay" class="dark_btn" style="display:none;"> 
							</div>
						</div>
                        <input type="hidden" name="action" value="save_card_info"/>
					</div>
                <?php
                }
                ?>
            </div>
        </form>
         
        <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
        <script>
			braintree.setup("<?php print $clientToken;?>", "custom", {id: "payment_form"});			
		</script>
                
        <form action="<?php print $form_action;?>" method="post" id="edit_billing_address">
        	<input type="hidden" name="choose_payment" value="card"/>
            <input type="hidden" name="action" value="edit_billing_address"/>            
        </form>
    </div>
</div>   

<?php echo $content_bottom; ?>
<?php echo $footer; ?>
<script type="text/javascript">

$('select[name=\'country_id\']').bind('change', function() {

	$.ajax({
		url: 'index.php?route=account/address/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			/*$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');*/
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
				html += '<option value="0" selected="selected">No regions</option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
</script> 
