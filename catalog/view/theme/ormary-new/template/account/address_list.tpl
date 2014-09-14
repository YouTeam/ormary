<?php echo $header; ?>
<?php echo $content_top; ?>

<div class="container content my_ormary_profile_page">
	<h4>Profile address editing</h4>
    <div class="col-md-3 clearfix aside">
    	<div class="profile_steps light_font">
			<a href="<?php echo $this->url->link('account/edit', '', 'SSL');?>">Basic information</a>
            <a href="<?php echo $address_url;?>"  class="active">Address information</a>
            <a href="<?php echo $this->url->link('account/password', '', 'SSL');?>">Password</a>
        </div>
    </div>
    
    <div class="col-md-9 clearfix nopadding">
    	<div class="address_info row clearfix">
        	<?php
            $i=1;
            foreach($addresses as $addr)
            {
            ?>
                <div class="col-sm-4 address_info_block" id="<?php print $addr['address_id'];?>">
                    <div class="title">
                    Address <?php print $i;?>
                    </div>
                    <?php print $addr['country'];?> <br>
                    <?php print $addr['address_1'];?> <br>
                    <?php print $addr['address_2'];?> <br>
                    <?php print $addr['city'];?> <br>
                    -- <br>
                    <?php print $addr['postcode']?><br>
                    <a href="javascript:void(0)" class="edit_btn" id="open_edit_shipping_address">Edit</a>
                </div>
            <?php
            	$i++;
            }
            ?>
    	</div>
        <a class="dark_btn add_address_btn" href="javascript:void(0)" id="open_add_shipping_address" >Add new address</a>
    </div>
</div>    

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
        <form action="<?php print $page_url;?>" method="post" id="edit_address">
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
            <input type="hidden" name="company" value="">
            <input type="hidden" name="address_id" value="">
            <input type="hidden" name="type" value="edit_address">
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
        </form>
    </div>
</div>


<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>



<script type="text/javascript">

$('select[name=\'country_id\']').bind('change', function() {

	$.ajax({
		url: 'index.php?route=account/address/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			//$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
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
