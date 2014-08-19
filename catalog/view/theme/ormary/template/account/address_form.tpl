<?php echo $header; ?>

<div class="container content my_ormary_profile_page">
	<?php echo $content_top; ?>
	<h4>Profile editing</h4>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="account_addr_form">
		<div class="col-md-3 clearfix aside">
			<div class="profile_steps light_font">
                <a href="<?php echo $this->url->link('account/edit', '', 'SSL');?>">Basic information</a>
                <a href="<?php echo $address_url;?>" class="active">Address information</a>
                <a href="<?php echo $this->url->link('account/password', '', 'SSL');?>">Password</a>
			</div>
		</div>
		<div class="col-md-9 clearfix nopadding section">
    		<div class="wrap_input">
                <div class="title">
                  Company
                </div>
                <input type="text" class="light_font" name="company" value="<?php echo $company; ?>" />
            </div>
            <div class="wrap_input">
                <div class="title">
                  Address*
                </div>
                <input type="text" class="light_font" name="address_1" value="<?php echo $address_1; ?>" />
                <?php if ($error_address_1) { ?>
                <span class="error"><?php echo $error_address_1; ?></span>
                <?php } ?>
            </div>
            <div class="wrap_input">
                <div class="title">
                  Address 2
                </div>
                <input type="text" class="light_font" name="address_2" value="<?php echo $address_2; ?>" />
            </div>
            <div class="wrap_input">
                <div class="title">
                  City*
                </div>
                <input type="text" class="light_font" name="city" value="<?php echo $city; ?>" />
                <?php if ($error_city) { ?>
                <span class="error"><?php echo $error_city; ?></span>
                <?php } ?>
            </div>
            <div class="wrap_input">
                <div class="title">
                  Post code*
                </div>
                <input type="text" class="light_font" name="postcode" value="<?php echo $postcode; ?>" />
                <?php if ($error_postcode) { ?>
                <span class="error"><?php echo $error_postcode; ?></span>
                <?php } ?>
            </div>
            <div class="wrap_select country_select">
                <div class="title">Country*</div>
                <select name="country_id">
                  <option value=""><?php echo $text_select; ?></option>
                  <?php foreach ($countries as $country) { ?>
                  <?php if ($country['country_id'] == $country_id) { ?>
                  <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                <?php if ($error_country) { ?>
                <span class="error"><?php echo $error_country; ?></span>
                <?php } ?>
            </div>
            <div class="wrap_select country_select">
                <div class="title">Region</div>
                <select name="zone_id">
                </select>
                <?php if ($error_zone) { ?>
                <span class="error"><?php echo $error_zone; ?></span>
                <?php } ?>
            </div>
 		
            <div style="display:none;">
                <input type="radio" name="default" value="1" checked="checked" />
            </div>
            <div class="wrap_input" style="display:none;">
                <div class="title">
                  First name*
                </div>
                <input type="text" class="light_font" name="firstname" value="<?php echo $firstname; ?>" />
                    <?php if ($error_firstname) { ?>
                    <span class="error"><?php echo $error_firstname; ?></span>
                    <?php } ?>
            </div>
            <div class="wrap_input" style="display:none;">
                <div class="title">
                  Last name*
                </div>
                <input type="text" class="light_font" name="lastname" value="<?php echo $lastname; ?>" />
                <?php if ($error_lastname) { ?>
                <span class="error"><?php echo $error_lastname; ?></span>
                <?php } ?>
            </div> 
            
            <div class="">
				<a href="<?php echo $this->url->link('account/account', '', 'SSL'); ?>" class="black_btn" style="float:left;"><?php echo $button_back; ?></a>
                <a href="javascript::void(0)" onclick="$('#account_addr_form').submit();" class="black_btn" style="float:left; margin-left:15px;">Save profile</a>
			</div>
		</div>
	</form>        
</div>


  
  
  <?php echo $content_bottom; ?></div>
  <?php echo $footer; ?>
<script type="text/javascript">

$('select[name=\'country_id\']').bind('change', function() {

	$.ajax({
		url: 'index.php?route=account/address/country&country_id=' + this.value,
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
</script> 
