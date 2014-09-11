<?php echo $header; ?>
<?php echo $content_top; ?>

<div class="container content my_ormary_profile_page">
    <h4>Profile editing</h4>
    <div class="col-md-3 clearfix aside">
    	<div class="profile_steps light_font">
 			<a href="<?php echo $this->url->link('account/edit', '', 'SSL');?>">Basic information</a>
            <a href="<?php echo $address_url;?>">Address information</a>
            <a href="<?php echo $this->url->link('account/password', '', 'SSL');?>" class="active">Password</a>
        </div>
    </div>
    <div class="col-md-9 clearfix nopadding profile_password">
    	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="account_pass_form">
            <div class="wrap_input">
                <div class="title">
                    Old password*
                </div>
                <input type="password" class="light_font" name="old_password">
				<div class="alert_error" style="display:none;" id="oldpass-error"><div class="title">&nbsp;</div><label >Please enter your current password</label></div>
            </div>
            <div class="wrap_input">
                <div class="title">
                    New password*
                </div>
                <input type="password" class="light_font" name="password" value="<?php echo $password; ?>">
				<div class="alert_error" style="display:none;" id="pass-error"><div class="title">&nbsp;</div><label >Please enter a valid password</label></div>
            </div>
            <div class="wrap_input">
                <div class="title">
                Confirm new password*
                </div>
                <input type="password" class="light_font" name="confirm" value="<?php echo $confirm; ?>">
				<div class="alert_error" style="display:none;" id="confirm-error"><div class="title">&nbsp;</div><label >Password doesn't match</label></div>
            </div>
            <div class="wrap_link">
               <a href="javascript::void(0)" onclick="validate();" class="black_btn">Save profile</a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript"><!--
 function validate()
  {
  event.preventDefault();
		$.ajax({
			url: 'index.php?route=account/password/ajaxValidate',
			type: 'post',
			data: $('#account_pass_form input[name=\'old_password\'], #account_pass_form input[name=\'password\'], #account_pass_form input[name=\'confirm\']'),
			dataType: 'json',
			success: function(json) {
				if (json['error'].length != 0) 
				{					
					if(json['error']['password'])
					{
						$('#account_pass_form #pass-error').show();	
					}
					else
					{
						$('#account_pass_form #pass-error').hide();
					}
					
					if(json['error']['confirm'])
					{
						$('#account_pass_form #confirm-error').show();	
					}
					else
					{
						$('#account_pass_form #confirm-error').hide();
					}
					
					if(json['error']['incorrect'])
					{
						$('#account_pass_form #oldpass-error').show();	
					}
					else
					{
						$('#account_pass_form #oldpass-error').hide();
					}
					
				} 
				else
				{
					$('#account_pass_form').submit();
				}	
			}
			});
  }
--></script>

<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>