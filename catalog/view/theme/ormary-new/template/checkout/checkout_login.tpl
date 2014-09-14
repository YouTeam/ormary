<?php echo $header; ?>
<?php echo $content_top; ?>


<div class="container cart">
	<div class="bag-signin wrap-orm-form col-md-6">
		<div class="orm-form-caption">
       		Sign in
        </div>
        <div class="orm-form">
        	<form method="post" action="<?php print $form_action;?>" id="checkout_login">
                <div class="orm-form-top">
                    <h6 class="text-center">
                    Returning customer
                    </h6>
                    <input type="email" placeholder="Email" class="login-input" name="email" value="<?php print $email;?>">                    
                    
                    <input type="password" placeholder="Password" class="login-input" name="password" value="<?php print $password;?>">					
                    
                    <a href="<?php print $forgotten_pass_link;?>" class="forgotten_password">Forgotten your password?</a>
                    <div class="remember_me">
                        <label>
                            <input type="checkbox" name="remember_me">
                            Remember me
                        </label>
                    </div>   
                    <input type="hidden" name="form_type" value="login">     
                             
                </div>
                <div id="name-error" style="display: block; margin:0 0 5px 28px; float:left;" class="alert_error"><?php print $login_warning;?></div>   
                <div class="orm-form-bottom">
                    <a href="javascript:void(0)" class="dark_btn" id="checkout_login_submit" onclick="$('#checkout_login').submit();">Sign in</a>
                </div>
            </form>
		</div>
	</div>

	<div class="bag-new-to-ormary wrap-orm-form col-md-6">
        <div class="orm-form-caption">
        New to ormary?
        </div>
        <div class="orm-form">
        	<form method="post" action="<?php print $form_action;?>" id="checkout_signup">
                <div class="orm-form-top">
                    <h6 class="text-center">
                    First time with us? <br>
                    Enter your email to continue
                    </h6>
                    <input type="email" placeholder="Email" class="login-input" name="register_email" value="<?php print $register_email;?>">
                    <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $register_warning;?></div>
                    <div id="name-error" style="display: block; float:left;" class="alert_error"><?php print $register_email_error;?></div>
                    
                    <input type="hidden" name="form_type" value="register">                    
                </div>
                <div class="orm-form-bottom">
                    <a href="javascript:void(0)" class="dark_btn" id="checkout_login_submit"  onclick="$('#checkout_signup').submit();">Continue</a>
                </div>
			</form>
		</div>
	</div>
</div>
    
<?php echo $content_bottom; ?>
<?php echo $footer; ?>
