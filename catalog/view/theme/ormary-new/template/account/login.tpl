<?php echo $header; ?>
<!--<?php /*if ($success) { ?>
<div class="success"><?php //echo $success; ?></div>
<?php }*/ ?>
<?php /*if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php }*/ ?>-->
<div id="content"class="container content all_designers_page"><?php echo $content_top; ?>

  
  
  <div class="wrap_sign_in standalone">
	<div class="sign_in_popup" style="display: block">
		<div class="caption">
            <span>SHOP THE WORLD’S</span>
            <span>NEWEST FASHION</span>
        </div>
		<div class="form">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="module_login"> 
            <input type="text" name="email" placeholder="E-mail"/></span>
            <input type="password" name="password" placeholder="Password"/>
            <div class="forgotps">
            <a href="<?php print $this->url->link('account/forgotten', '', 'SSL');?>">Forgot your password?</a>
            </div>
            <input type="submit" value="LOGIN" class="open_wizard" onclick="loginClick()">
            </form>
		</div>
        
		<div class="facebook">
			<div>
            	 <a id="login_fb" href="javascript:void(0);" style="cursor:pointer;" onclick="Login('')"><img src="catalog/view/theme/ormary/images/facebook_gag.png" alt=""></a>            	
            </div>
		</div>
	</div>
</div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
//--></script> 
<?php echo $footer; ?>