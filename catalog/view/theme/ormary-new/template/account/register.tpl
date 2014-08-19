<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div id="content"class="container content my_ormary_profile_page"><?php echo $content_top; ?>
  
  <h4>Register profile</h4>
  <p><?php echo $text_account_already; ?></p>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="orm_registration">
    <div class="col-md-9 clearfix nopadding section">
	  <div class="wrap_input">
		<div class="title">
		  First name*
		</div>
		<input type="text" class="light_font" name="firstname" value="<?php echo $firstname; ?>" />
            <?php if ($error_firstname) { ?>
            <span style="font-size:10px;float:right"><?php echo $error_firstname; ?></span>
            <?php } ?>
	  </div>
    <div class="wrap_input">
            <div class="title">
              Last name*
            </div>
            <input type="text" class="light_font" name="lastname" value="<?php echo $lastname; ?>" />
            <?php if ($error_lastname) { ?>
            <span style="font-size:10px;float:right"><?php echo $error_lastname; ?></span>
            <?php } ?>
        </div>
        <div class="wrap_input">
            <div class="title">
              Email*
            </div>
            <input type="text" class="light_font" name="email" value="<?php echo $email; ?>" />
            <?php if ($error_email) { ?>
            <span style="font-size:10px;float:right"><?php echo $error_email; ?></span>
            <?php } ?>
        </div>
        <div class="wrap_input clearfix">
            <div class="title">
              Phone number*
            </div>
            <input type="text" class="light_font" name="telephone" value="<?php echo $telephone; ?>" />
            <?php if ($error_telephone) { ?>
            <span style="font-size:10px;float:right"><?php echo $error_telephone; ?></span>
            <?php } ?>
        </div>
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
	
    <div style="display: <?php echo (count($customer_groups) > 1 ? 'inline-block' : 'none'); ?>;">
          <?php echo $entry_customer_group; ?>
          <?php foreach ($customer_groups as $customer_group) { ?>
            <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
            <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
            <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
            <br />
            <?php } else { ?>
            <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" />
            <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
            <br />
            <?php } ?>
            <?php } ?>
    </div>
    <div class="wrap_input">
            <div class="title">
			Password* </div>
            <input type="password" class="light_font" name="password" value="<?php echo $password; ?>" />
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?>
        </div>
        <div class="wrap_input">
            <div class="title">
			Confirm password*</div>
          <input type="password" class="light_font" name="confirm" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php } ?>
        </div>
      
    <div style="visibility:hidden">
      <?php echo $entry_newsletter; ?>
            <input type="radio" name="newsletter" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="newsletter" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <input type="text" class="light_font" name="fax" value="" />
            <input type="text" class="light_font" name="biography" value="" />
            <input type="file"  name="profile_image_url" value="" />
    </div>
    <?php if ($text_agree) { ?>
    <div style="text-align:left">
      <?php echo $text_agree; ?>
        <?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?>
        <input type="button" value="<?php echo $button_continue; ?>" class="open_wizard2" />
    </div>
    
    
	<div class="wrap_input" style="visibility:hidden">
      <span id="company-id-required" class="required">*</span> <?php echo $entry_company_id; ?>
      <input type="text" name="company_id" value="<?php echo $company_id; ?>" />
        <?php if ($error_company_id) { ?>
        <span class="error"><?php echo $error_company_id; ?></span>
        <?php } ?>
    </div>
    <div class="wrap_input" style="visibility:hidden">
      <span id="tax-id-required" class="required">*</span> <?php echo $entry_tax_id; ?>
      <input type="text" name="tax_id" value="<?php echo $tax_id; ?>" />
        <?php if ($error_tax_id) { ?>
        <span class="error"><?php echo $error_tax_id; ?></span>
        <?php } ?>
    </div>

    <?php } else { ?>
    <div class="buttons">
      <div class="right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
    <?php } ?>
    
    <input type="hidden" value="" name="following_designers" id="following_designers"/>
  </form>
  </div>
  <?php echo $content_bottom; ?>
  </div>
  </div>
  
  
    <!-- PopUp -->
<!-- <div class="popup"></div>
   <div class="sign_in_popup">
      <div class="caption">
        <span>SHOP THE WORLD’S</span>
        <span>NEWEST FASHION HERE</span>
      </div>
      <div class="form">
        <form action="">
          <input type="text" placeholder="Choose username">
          <input type="text" placeholder="E-mail">
          <input type="password" placeholder="Password">
          <input type="submit" value="LOGIN" class="open_wizard">
        </form>
      </div>
      <div class="facebook">
        <div>
          <img src="images/facebook_gag.png" alt="">
        </div>
      </div>
    </div>-->
  
  
  <!--  <div class="sign_up_popup">
      <div class="caption">
        <span>SHOP THE WORLD’S</span>
        <span>NEWEST FASHION HERE</span>
      </div>
      <div class="form">
        <form action="">
          <input type="text" placeholder="Choose username">
          <input type="text" placeholder="E-mail">
          <input type="password" placeholder="Password">
          <input type="submit" value="CREATE AN ACCOUNT" class="open_wizard">
        </form>
      </div>
      <div class="facebook">
        <div>
          <img src="images/facebook_gag.png" alt="">
        </div>
      </div>
    </div>
    <div class="interested_in">
      <div class="caption text-center">Interested in</div>
      <div class="choose_fashion clearfix">
        <a href="#" class="wfashion">Women’s <br> Fashion</a>
        <a href="#" class="mfashion">Men’s <br> Fashion</a>
      </div>
      <div class="bottom_btn">
        <a href="#" class="open_wizard2 light_btn">next</a>
      </div>
    </div>
    <div class="wrap_do_you_like">
      <div class="do_you_like">
        <div class="caption text-center">
          You need to select at least three designers
          <a href="#" class='open_wizard3' style="display:none;">Skip</a>
        </div>
        <a href="#" class="designer" id="<?php print $first_designer_order_id;?>">
          <div class="des-img" id="<?php print $first_designer['mid'];?>">
            <img src="<?php print $first_designer['image'];?>" alt="<?php print $first_designer['name']?>" id="designer_image"> 
          </div>
          <span id="designer_name"><?php print $first_designer['name']?></span>
          <span class="light_font">Designer</span>
        </a>
        <div class="designer_goods">
            <a href="#" class="des_slider_left">
              <img src="catalog/view/theme/ormary/images/des_slider_left.png" alt="">
            </a>
            <a href="#" class="des_slider_right">
              <img src="catalog/view/theme/ormary/images/des_slider_right.png" alt="">
            </a>
            <div class="swiper-container designer_goods_slider">
              <div class="swiper-wrapper">
              <?php
              foreach($first_designer['images'] as $dimage)
              {
				print '<div class="swiper-slide">
                  <img src="'.$dimage.'" alt="">
                </div>';
              
               }
               ?> 
              </div>
            </div>
        </div>
        <div class="bottom_btn">
          <a href="javascript:void(0)" class="light_btn like" id="no">no</a>
          <a href="javascript:void(0)" class="light_btn like" id="yes">yes</a>
        </div>
      </div>
    </div>
    <div class="wrap_you_are_following">
      <div class="you_are_following">
        <div class="caption text-center">
          You are following
        </div>
        <div class="bottom_btn">
          <a href="javascript:void(0)" class="light_btn">continue</a>
        </div>
      </div>
    </div>
    
    -->
  
  
  
  
  
  <?php echo $footer; ?>
<script type="text/javascript"><!--
$('input[name=\'customer_group_id\']:checked').live('change', function() {
	var customer_group = [];
	
<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group["company_id_display"]; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group["company_id_required"]; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group["tax_id_display"]; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group["tax_id_required"]; ?>';
<?php } ?>	

	if (customer_group[this.value]) {
		if (customer_group[this.value]['company_id_display'] == '1') {
			$('#company-id-display').show();
		} else {
			$('#company-id-display').hide();
		}
		
		if (customer_group[this.value]['company_id_required'] == '1') {
			$('#company-id-required').show();
		} else {
			$('#company-id-required').hide();
		}
		
		if (customer_group[this.value]['tax_id_display'] == '1') {
			$('#tax-id-display').show();
		} else {
			$('#tax-id-display').hide();
		}
		
		if (customer_group[this.value]['tax_id_required'] == '1') {
			$('#tax-id-required').show();
		} else {
			$('#tax-id-required').hide();
		}	
	}
});

$('input[name=\'customer_group_id\']:checked').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=account/register/country&country_id=' + this.value,
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
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		width: 640,
		height: 480
	});
});
//--></script> 
