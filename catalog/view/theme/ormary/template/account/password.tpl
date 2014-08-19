<?php echo $header; ?>

<div class="container content my_ormary_profile_page">
	<?php echo $content_top; ?>
	<h4>Profile editing</h4>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="account_pass_form">
		<div class="col-md-3 clearfix aside">
			<div class="profile_steps light_font">
                <a href="<?php echo $this->url->link('account/edit', '', 'SSL');?>">Basic information</a>
                <a href="<?php echo $address_url;?>">Address information</a>
                <a href="<?php echo $this->url->link('account/password', '', 'SSL');?>" class="active">Password</a>
			</div>
		</div>
		<div class="col-md-9 clearfix nopadding profile_password">
            <div class="wrap_input">
            	<div class="title">
                	Old password*
                </div>
				<input type="password" class="light_font" name="old_password" />
			</div>
            <div class="wrap_input">
            	<div class="title">
            		New password*
            	</div>
            	<input type="password" class="light_font" name="password" value="<?php echo $password; ?>" />
            </div>
            <div class="wrap_input">
           		<div class="title">
            		Confirm new password*
            	</div>
            	<input type="password" class="light_font" name="confirm" value="<?php echo $confirm; ?>" />
            </div>
			<div class="wrap_link">
				<a href="<?php echo $this->url->link('account/account', '', 'SSL'); ?>" class="black_btn" style="float:left;"><?php echo $button_back; ?></a>
    			<a href="javascript::void(0)" onclick="$('#account_pass_form').submit();" class="black_btn" style="float:left; margin-left:15px;">Save profile</a>
			</div>
		</div>
	</form>        
</div>

<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>