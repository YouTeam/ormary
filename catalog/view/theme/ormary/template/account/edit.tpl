<?php echo $header; ?>

<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>



    <div class="container content my_ormary_profile_page">
    	<?php echo $content_top; ?>
    	<h4>Profile editing</h4>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="account_form">
            <div class="col-md-3 clearfix aside">
                <div class="profile_steps light_font">
            		<a href="<?php echo $this->url->link('account/edit', '', 'SSL');?>" class="active">Basic information</a>
					<a href="<?php echo $address_url;?>">Address information</a>
            		<a href="<?php echo $this->url->link('account/password', '', 'SSL');?>">Password</a>
                </div>
            </div>
            <div class="col-md-9 clearfix nopadding basic_information">
                <div class="orm_avatar">
                   <img src="<?php echo $this->url->img_link($profile_img_url); ?>" alt="Avatar"/>
                </div>
                <div class="change_avatar">
                    <a href="#">Change avatar</a>
                    <span>Accepted formats: jpeg, png, gif    max size 900 kb</span>
                    <input type="hidden" name="MAX_FILE_SIZE" value="900000" />
					<input name="ufile" id="ufile" type="file" />
                </div>
                
                <div class="wrap_input clearfix">
                    <div class="title">
                        First name*
                    </div>
                    <input type="text" class="light_font" name="firstname" value="<?php echo $firstname; ?>" />
                    <?php if ($error_firstname) { ?>
                    	<span style="font-size:10px;float:right"><?php echo $error_firstname; ?></span>
                    <?php } ?>
                </div>
                
                <div class="wrap_input clearfix">
                    <div class="title">
                        Last name*
                    </div>
                    <input type="text" class="light_font" name="lastname" value="<?php echo $lastname; ?>" />
                    <?php if ($error_lastname) { ?>
                    <span style="font-size:10px;float:right"><?php echo $error_lastname; ?></span>
                    <?php } ?>
                </div>
                
                <div class="wrap_input clearfix">
                    <div class="title">
                        User name*
                    </div>
                    <span>http://www.ormary.com/</span>
                    <input type="text" class="user_name light_font" name="user_link" value="<?php print $user_link;?>">
                </div>
                
                <div class="wrap_input clearfix">
                    <div class="title">
                        Interested in 
                    </div>
                    <div class="wrap_radio">
                        <input type="radio" name="interest" id="interested_w" <?php print $interest['womens'];?> value="1">
                        <label class="filter-label" for="interested_w">
                            Women’s fashion
                        </label>
                    </div>
                    <div class="wrap_radio">
                        <input type="radio" name="interest" id="interested_m" <?php print $interest['mens'];?> value="2" >
                        <label class="filter-label" for="interested_m">
                            Men’s fashion
                        </label>
                    </div>
                </div>
                
                <div class="wrap_input clearfix">
                    <div class="title">
                        Your email*
                    </div>
                    <input type="text" class="light_font" name="email" value="<?php echo $email; ?>" />
                    <?php if ($error_email) { ?>
                    	<span style="font-size:10px;float:right"><?php echo $error_email; ?></span>
                    <?php } ?>
                    <div class="wrap_checkbox">
                        <input type="checkbox" id='subscribe' value="1" name="newsletter" <?php print $newsletter; ?>>
                        <label for="subscribe">Subscribe to newsletter</label>
                    </div>
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
                
                <!--<div class="wrap_select country_select">
                    <div class="title">Country*</div>
                    <select name="" id="">
                        <option value=""></option>
                    </select>
                </div>
                
                <div class="wrap_select">
                    <div class="title">City*</div>
                    <select name="" id="">
                        <option value=""></option>
                    </select>
                </div>-->
                
                <div class="wrap_input clearfix">
                    <div class="title">
                        Your website
                    </div>
                    <input type="text" class="light_font" name="website" value="<?php print $website;?>">
                </div>
                
                <div class="wrap_input clearfix">
                    <div class="title">
                        Biography
                    </div>
                    <textarea name="biography" placeholder='Tell about yourself' class="light_font"><?php echo $biography; ?></textarea>
                </div>
    			<input type="hidden" name="fax" value="" />
                
                <div class="wrap_link">
                    <a href="<?php echo $back; ?>" class="black_btn" style="float:left"><?php echo $button_back; ?></a>
    				<a href="javascript::void(0)" onclick="$('#account_form').submit();" class="black_btn" style="float:left; margin-left:15px;">Save profile</a>
                </div>
                
                
                <div class="disable_my_account">
                    <div class="caption">Account disabling</div>
                    <div class="prevention">
                        By disabling your account, your Fashionfeed will be stopped, and you will be logged out. All of your Wardrobe items and profile settings will be saved. <br> Your account will be re-activated upon next login. 
                    </div>
                    <div class="wrap_link">
                        <a href="#" class="black_btn">disable my account</a>
                    </div>
                </div>
            </div>
		</form>
    </div>

  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>