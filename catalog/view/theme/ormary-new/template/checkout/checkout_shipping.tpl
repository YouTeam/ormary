<?php echo $header; ?>
<?php echo $content_top; ?>

<div class="container cart">
    <h3 class="text-center">BAG</h3>
    <div class="steps clearfix">
        <div class="col-xs-4 wrap-step active">
            <a href="javascript:void(0)" class="step">1. shipping</a>
        </div>
        <div class="col-xs-4 wrap-step">
            <a href="javascript:void(0)" class="step">2. payment</a>
        </div>
        <div class="col-xs-4 wrap-step">
            <a href="javascript:void(0)" class="step">3. review</a>
        </div>
    </div>
    
    
    <?php 
    if($list_addresses)
    {
    ?>
        <div class="choose_shipping_address clearfix">
            <h5>
                Choose shipping address
                <a href="javascript:void(0)" id="open_add_shipping_address">+ Add new address</a>
            </h5>
            <div class="flat_rate_shipping">
                    Flat rate shipping
                </div>
                <form action="<?php print $page_url;?>" method="post" id="select_shipping_address">
                	<?php
                    foreach($addresses as $addr)
                    {
                    ?>
                        <label class="csa clearfix">
                            <div class="csa-checkbox text-center">
                                <input type="radio" id="" name="address_id" value="<?php print $addr['address_id'];?>" <?php if($selected_address == $addr['address_id']){ print "checked";}?> >
                            </div>
                            <div class="csa-address" id="<?php print $addr['address_id'];?>">
                                <p>
                                    <span>Name:</span><?php print $addr['firstname']." ".$addr['lastname'];?>
                                </p>
                                <p>
                                    <span>Address:</span><?php print $addr['city'].", ".$addr['country'];?>
                                </p>
                                <p>
                                    <span>ZIP/Postal code:</span><?php print $addr['postcode'];?>
                                </p>
                                <p>
                                    <span>E-mail:</span><?php print $customer_email;?>
                                </p>
                                <a href="javascript:void(0)" class="edit_btn" id="open_edit_shipping_address">Edit</a>
                            </div>
                        </label>
                	<?php
                    }
                    ?>
					<input type="hidden" name="type" value="select_address">
            	</form>
            </div>
            <div class="clearfix">
                <div class="bag-bottom clearfix">
                    <a href="javascript:void(0)" onclick="$('#select_shipping_address').submit();" class="dark_btn">ship to this address</a>
                </div>
            </div>
        </div>
    <?php
    }
    else
    {
    ?>   
    	<form action="<?php print $page_url;?>" method="post" id="customer_info_form"> 
            <div class="add_shipping_information clearfix">
                <h5>Add your shipping information</h5>
                <div class="flat_rate_shipping">
                    Flat rate shipping
                </div>
                <div class="cart_inputs">
                    <div class="inputs_group">
                        <div class="inputs_row clearfix">
                            <div class="input_wrap">
                                <label>
                                    <span>First name</span>
                                    <input type="text" name="firstname" value="<?php print $firstname;?>">
                                    <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_firstname;?></div>
                                </label>
                            </div>
                            <div class="input_wrap">
                                <label>
                                    <span>Last name</span>
                                    <input type="text" name="lastname" value="<?php print $lastname;?>">
                                    <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_lastname;?></div>
                                </label>
                            </div>
                        </div>
                        <div class="inputs_row clearfix">
                            <div class="input_wrap">
                                <label>
                                    <span>Country</span>
                                    <select name="country_id" id="" class="form-control">
                                    	<option value=""><?php echo $text_select; ?></option>
                                        <?php foreach ($countries as $country) { ?>
                                            <?php if ($country['country_id'] == $country_id) { ?>
                                            	<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                            <?php } else { ?>
                                            	<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
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
                                    <span>Address 1</span>
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
                                    <span>City</span>
                                    <input type="text" name="city" value="<?php print $city;?>">
                                    <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_city;?></div>
                                </label>
                            </div>
                            <div class="input_wrap">
                                <label>
                                    <span>State</span>
                                    <select name="zone_id" id="" class="form-control">
                                    </select>
                                    <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_zone;?></div>
                                </label>
                            </div>
                        </div>
                        <div class="inputs_row clearfix">
                            <div class="input_wrap">
                                <label>
                                    <span>Postcode or ZIP</span>
                                    <input type="text" name="postcode" value="<?php print $postcode;?>">
                                    <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_postcode;?></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="security clearfix">
                <h5>Security</h5>
                <div class="cart_inputs">
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>Password</span>
                                <input type="password" name="password" value="<?php print $password;?>">
                                <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_password;?></div>
                            </label>
                        </div>
                        <div class="input_wrap">
                            <label>
                                <span>Confirm password</span>
                                <input type="password" name="confirm" value="<?php print $confirm;?>">
                                <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $error_confirm;?></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="email" value="<?php print $new_user_email;?>">
            <input type="hidden" name="type" value="new_user">
            <input type="hidden" name="company" value="">
        </form>    
        <div class="clearfix">
            <div class="bag-bottom clearfix">
                <a href="javascript:void(0)" onclick="$('#customer_info_form').submit();" class="dark_btn">Next step</a>
            </div>
        </div>
    <?php
    }
    ?>

</div>

<?php
if($list_addresses)
{
?>
    <div class="popup"></div>
    
    <div class="add_shipping_address" id="add_shipping_address">
        <div class="caption text-center" >Add your shipping address</div>
        <div class="cart_inputs">
        	<form method="post" action="<?php print $add_url;?>" id="add_address">
                <div class="inputs_group">
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>First name</span>
                                <input type="text" name="firstname">
                                <div class="alert_error" style="display:none;" id="error_firstname"></div>
                            </label>
                        </div>
                        <div class="input_wrap">
                            <label>
                                <span>Last name</span>
                                <input type="text" name="lastname">
                                <div class="alert_error" style="display:none;" id="error_lastname"></div>
                            </label>
                        </div>
                    </div>
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>Country</span>
                                <select name="country_id" id="" class="form-control">
                                    <option value=""><?php echo $text_select; ?></option>
                                    <?php foreach ($countries as $country) { ?>
                                    	<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="alert_error" style="display:none;" id="error_country"></div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="inputs_group">
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>Address 1</span>
                                <input type="text" name="address_1">
                                <div class="alert_error" style="display:none;" id="error_address_1"></div>
                            </label>
                        </div>
                        <div class="input_wrap">
                            <label>
                                <span>Address 2</span>
                                <input type="text" name="address_2">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="inputs_group">
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>City</span>
                                <input type="text" name="city">
                                <div class="alert_error" style="display:none;" id="error_city"></div>
                            </label>
                        </div>
                        <div class="input_wrap">
                            <label>
                                <span>State</span>
                                <select name="zone_id">
                                </select>
                                <div class="alert_error" style="display:none;" id="error_zone"></div>
                            </label>
                        </div>
                    </div>
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>Postcode or ZIP</span>
                                <input type="text" name="postcode">
                                <div class="alert_error" style="display:none;" id="error_postcode"></div>
                            </label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="type" value="new_address" />
                <input type="hidden" name="shipping_page" value="1" />
                <input type="hidden" name="company" value="">
            </form>            
            <div class="bottom_btn text-center">
                <a href="javascript:void(0)" onclick="$('.popup, #add_shipping_address').hide();" class="light_btn">Cancel</a>
            	<a href="javascript:void(0)" class="dark_btn add_address_btn">Save changes</a>
            </div>
        </div>
    </div>
        
    <div class="add_shipping_address" id="edit_shipping_address">
        <div class="caption text-center" >Edit shipping address</div>
        <div class="cart_inputs">
        	<form action="<?php print $update_url;?>" method="post" id="edit_address">
                <div class="inputs_group">
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>First name</span>
                                <input type="text" name="firstname">
                                <div class="alert_error" style="display:none;" id="error_firstname"></div>
                            </label>
                        </div>
                        <div class="input_wrap">
                            <label>
                                <span>Last name</span>
                                <input type="text" name="lastname">
                                <div class="alert_error" style="display:none;" id="error_lastname"></div>
                            </label>
                        </div>
                    </div>
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>Country</span>
                                <select name="country_id" id="" class="form-control">
                                    <option value=""><?php echo $text_select; ?></option>
                                    <?php foreach ($countries as $country) { ?>
                                            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="alert_error" style="display:none;" id="error_country"></div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="inputs_group">
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>Address 1</span>
                                <input type="text" name="address_1">
                                <div class="alert_error" style="display:none;" id="error_address_1"></div>
                            </label>
                        </div>
                        <div class="input_wrap">
                            <label>
                                <span>Address 2</span>
                                <input type="text" name="address_2">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="inputs_group">
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>City</span>
                                <input type="text" name="city">
                                <div class="alert_error" style="display:none;" id="error_city"></div>
                            </label>
                        </div>
                        <div class="input_wrap">
                            <label>
                                <span>State</span>
                                <select name="zone_id">
                                </select>
                                <div class="alert_error" style="display:none;" id="error_zone"></div>
                            </label>
                        </div>
                    </div>
                    <div class="inputs_row clearfix">
                        <div class="input_wrap">
                            <label>
                                <span>Postcode or ZIP</span>
                                <input type="text" name="postcode">
                                <div class="alert_error" style="display:none;" id="error_postcode"></div>
                            </label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="address_id" value="">
                <input type="hidden" name="shipping_page" value="1" />
                <input type="hidden" name="type" value="edit_address">
                <input type="hidden" name="company" value="">
            </form>
        </div>
        <div class="bottom_btn text-center">
            <a href="javascript:void(0)" onclick="$('.popup, #edit_shipping_address').hide();" class="light_btn">Cancel</a>
            <a href="javascript:void(0)" class="dark_btn update_address_btn">Save changes</a>
        </div>
        <div class="remove-addres text-center">
            <a href="javascript:void(0)" onclick="$('#delete_address').submit();">
                Remove this address
                <img src="catalog/view/theme/ormary-new/images/del.png" alt="Delete">
            </a>
            <form action="<?php print $delete_url;?>" method="post" id="delete_address">
	        	<input type="hidden" name="address_id" value="" />
                <input type="hidden" name="shipping_page" value="1" />
            </form>            
        </div>
    </div>   
<?php
}
?>  
   
          
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
</script> 
