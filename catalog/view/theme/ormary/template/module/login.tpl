<?php if (!$this->customer->isLogged()) { ?>
<div class="popup" style="display:none;"></div>
<div class="wrap_sign_in">
	<div class="sign_in_popup">
		<div class="caption">
            <span>SHOP THE WORLD’S</span>
            <span>NEWEST FASHION HERE</span>
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
            	<img src="/ormary/catalog/view/theme/ormary/images/facebook_gag.png" alt="">
            </div>
		</div>
	</div>
</div>
  
  
<div class="sign_up_popup">
	<div class="caption">
    	<span>SHOP THE WORLD’S</span>
    	<span>NEWEST FASHION HERE</span>
    </div>
	<div class="form">
        <form action="<?php print $this->url->link('account/register', '', 'SSL');?>" id="registration-first-form" method="post">
        <input type="text" placeholder="Choose username" name="firstname">
        <input type="text" placeholder="E-mail" name="email">
        <input type="password" placeholder="Password" name="password">
        <input type="submit" value="CREATE AN ACCOUNT" class="open_wizard2">
        <input type="hidden" value="" name="following_designers" id="following_designers"/>
        </form>
	</div>
	<div class="facebook">
		<div>
        	<img src="catalog/view/theme/ormary/images/facebook_gag.png" alt="">
        </div>
	</div>
</div>
    <!--
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
    -->
<div class="wrap_do_you_like">
	<div class="do_you_like">
		<div class="caption text-center">
			You need to select at least three designers
			<a href="#" class='open_wizard3' style="display:none;">Skip</a>
		</div>
		<a href="#" class="designer" id="0">
            <div class="des-img" id="">
                <img src="" alt="" id="designer_image"> 
            </div>
        	<span id="designer_name"></span>
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
 
 
 
 
  <script type="text/javascript"><!--
  $('#module_login input').keydown(function(e) {
	  if (e.keyCode == 13) {
		  $('#module_login').submit();
	  }
  });
  function loginClick()
  {
  $('#module_login').submit();
  }
  //--></script>
<?php } ?>
