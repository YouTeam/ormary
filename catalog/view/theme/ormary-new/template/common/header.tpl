<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
    <head>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    	<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    	<title><?php echo $title; ?></title>
    	<base href="<?php echo $base; ?>" />
        <?php if ($description) { ?>
        	<meta name="description" content="<?php echo $description; ?>" />
        <?php } ?>
        <?php if ($keywords) { ?>
        	<meta name="keywords" content="<?php echo $keywords; ?>" />
        <?php } ?>
        <?php if ($icon) { ?>
        	<link href="<?php echo $icon; ?>" rel="icon" />
        <?php } ?>
    	<?php foreach ($links as $link) { ?>
        	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
        <?php } ?>
        
        <?php foreach ($styles as $style) { ?>
        	<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
        <?php } ?>
        
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/ormary-new/stylesheet/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/ormary-new/stylesheet/style.css" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/ormary-new/stylesheet/fonts.css" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/ormary-new/stylesheet/font-awesome.css" />

    	<link rel="stylesheet" type="text/css" href="catalog/view/theme/ormary-new/stylesheet/idangerous.swiper.css" />
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <?php foreach ($scripts as $script) { ?>
        	<script type="text/javascript" src="<?php echo $script; ?>"></script>
        <?php } ?>
        
        <!--[if IE 7]> 
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
        <![endif]-->
        <!--[if lt IE 7]>
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
        <script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
        <script type="text/javascript">
        DD_belatedPNG.fix('#logo img');
        </script>
        <![endif]-->
        
        <?php if ($stores) { ?>
			<script type="text/javascript"><!--
                $(document).ready(function() {
                <?php foreach ($stores as $store) { ?>
                $('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
                <?php } ?>
                });
            //--></script>
        <?php } ?>
        
    	<?php echo $google_analytics; ?>
    </head>




    <body>
    	<div class="wrapper">
            <header>
            	<div class="container-fluid top_bar">
            		<div class="container">
            			<div class="col-lg-3 col-md-2 left_side clearfix">
            				<?php if ($logo) { ?>
            					<div id="logo" class="logo">
						 			<a href="<?php echo $home; ?>">
                                    	<img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
                                    </a>
                                </div>
							<?php } ?>
            			</div>
                        
                        <!-- SHIPPING AND REFUNDS STARTS -->
                        
              <div class="navbar navbar-static" id="shipping-refunds">
                <div class="navbar-inner">
                    
                    <ul role="navigation" class="nav">
                       
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">FREE UK DELIVERY ON ORDERS £125+</b></a>
                            <ul class="dropdown-menu top-shipping">
                                <li>
                                  <table cellpadding=0 cellspacing=0 border=0>
                                      <tr>
                                          <th colspan=2>UK</th>
                                        </tr>
                                      <tr>
                                          <td class="shippinglabel">Standard delivery<br>
on orders £125+<br>
(2 - 3 days)</td> 
                                          <td class="shippingvalue">FREE</td> 
 
                                        </tr>
                                        <tr class=last>
                                          <td class="shippinglabel">Standard Delivery<br>
(2 - 3 days)</td> 
                                          <td class="shippingvalue">£5</td> 
 
                                        </tr>
                                    </table>
                                    
                                    <table cellpadding=0 cellspacing=0 border=0>
                                      <tr>
                                          <th colspan=2>EU</th>
                                        </tr>
                                    
                                        <tr class=last>
                                          <td class="shippinglabel">Standard Delivery<br>
(4 - 7 days)</td> 
                                          <td class="shippingvalue">£10</td>  
 
                                        </tr>
                                    </table>
                                    
                                    <table cellpadding=0 cellspacing=0 border=0>
                                      <tr>
                                          <th colspan=2>US AND CANADA</th>
                                        </tr>
                                      
                                        <tr class=last>
                                          <td class="shippinglabel">Standard Delivery<br>
(4 - 7 days)</td> 
                                          <td class="shippingvalue">£20</td>  
 
                                        </tr>
                                    </table>
                                    
                                    <table cellpadding=0 cellspacing=0 border=0 class=last>
                                      <tr>
                                          <th colspan=2>REST OF WORLD</th>
                                        </tr>
                             
                                        <tr class=last>
                                          <td class="shippinglabel">Standard Delivery<br>
(4 - 10 days)</td>  
                                          <td class="shippingvalue">£30</td>  
 
                                        </tr>
                                    </table>
                                </li>
                                
                            </ul>
                        </li>
                        <li class="separator">|</li>
                        
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">FREE RETURNS</b></a>
                            <ul class="dropdown-menu top-refunds">
                                <li class="">
                                <h3>WE HAVE A SIMPLE RETURNS POLICY</h3>
                                
                                <p>If for any reason, you are not happy with your purchase from Ormary, we will refund it, no questions asked. All you have to do is let us know and return it to us within 14 days of receiving it.</p>
                                <p>We will, of course, exchange the item for you if you prefer. Note Earrings are non-refundable.</p>
                                <p>If you'd like some personal shopping assistance choosing something else call us on 020 3222 2029, we'd love to help.</p>
                                <p class=bottomcta><a href="/returns-and-exchanges" >CLICK HERE to Return an item</a></p>
                                </li>
                                
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
                        
            <!-- SHIPPING AND REFUNDS ENDS -->
                        
            			<div class="navbar-right right_side clearfix">
            				<div class="join clearfix">
                                <ul>
                                    <?php if (!$logged) { ?>
                                        <li>
                                            <a href="<?php echo $this->url->link('account/register', '', 'SSL');?>" class="open_ormary">JOIN ORMARY</a>
                                        </li>
                                        <li>
                                            <a href="#" class="open_sign_in_popup">SIGN IN</a>
                                        </li>
                                    <?php } else { ?>
                                        <li>
                                            <a href="<?php echo $feed; ?>" class="account dropdown-toggle">
                                                <div class="account_avatar">
                                                	<img src="<?php echo $this->customer->getProfileImgURL();?>" alt="<?php echo $account_firstname ?>">
                                                </div>
                                                <span><?php echo $account_firstname ?></span>
                                                <b class="caret"></b>
                                            </a>
                                            <ul class="dropdown-menu submenu">
                                                <li>
                                                	<a href="<?php echo $feed; ?>">Fashionfeed</a>
                                                </li>
                                                <li>
                                                	<a href="<?php echo $wishlist; ?>">Wardrobe</a>
                                                </li>
                                                <li>
                                                	<a href="<?php echo $account; ?>&tab=orders">Orders</a>
                                                </li>
                                                <li>
                                                	<a href="<?php echo $account; ?>">Profile</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                	<a href="<?php echo $this->url->link('account/logout', '', 'SSL') ?>" class="logout">Logout</a>
                                                </li>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                    
                                    <!--<li>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">&pound; <b class="caret"></b></a>
                                        <ul class="dropdown-menu currency">
                                            <li>
                                                <a href="#">&pound;</a>
                                            </li>
                                            <li>
                                                <a href="#">$</a>
                                            </li>
                                        </ul>
                                    </li>-->
                
                                    <?php print $cart;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
 
                <div class="container-fluid">
                    <div class="row">
                        <div class="navbar navbar-default main_menu">
                            <div class="container">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responsive_menu">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div class="collapse navbar-collapse" id="responsive_menu">
                                    <ul class="nav navbar-nav navbar-left">
                                        <li><a href="<?php echo $this->url->link('product/category', 'path=0');?>&featured=1">What's new</a></li>
                                        <li><a href="<?php echo $this->url->link('product/manufacturer');?>">DESIGNERS</a></li>
                                        
                                        <?php if ($categories) { ?>
                                            <?php foreach ($categories as $category) { ?>
                                                <li><a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown" onclick="window.location.href = '<?php echo $category['href']; ?>'"><?php echo $category['name']; ?><b class="caret"></b></a>
                                                    <?php if ($category['children']) { ?>
                                                        <ul class="dropdown-menu orm_sub_dropdown-menu">	
                                                            <li class="menu-item"><a href="<?php echo $category['href']; ?>">All <?php print strtolower($category['name']); ?></a></li>
                                                            <?php 
                                                                for ($i = 0; $i < count($category['children']);) 
                                                                { 
                                                                    $j = $i + ceil(count($category['children']) / $category['column']); 
                                                                    for (; $i < $j; $i++) 
                                                                    {
                                                                        if (isset($category['children'][$i])) 
                                                                        { 
                                                                ?>
                                                                            <li class="menu-item"><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
                                                                <?php 
                                                                        } 
                                                                    } 
                                                                } 
                                                            ?>
                                                        </ul>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                    <ul class="nav navbar-nav navbar-right">
                                        <form class="search" role="search" action="index.php?" method="get" id="orm_search_word">
                                            <input type="text" name="search_phrase" class="search_inp" placeholder="Search" value="<?php echo $search; ?>">
                                            <!--<input type="hidden" name="route" value="product/category">-->
                                            <button type="submit" class="search_btn"></button>
                                        </form>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                
                <?php if (!$logged) { ?>

  <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo $FBAPiKEY; ?>', // Set YOUR APP ID
      channelUrl : '', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });
 
 
   FB.Event.subscribe('auth.authResponseChange', function(response)
    {
     if (response.status === 'connected')
    {
        
        //SUCCESS
 
    }   
    else if (response.status === 'not_authorized')
    {
        //alert("not authorized");
 
        //FAILED
    } else
    {
        //alert("logged out");
 
        //UNKNOWN ERROR
    }
    });
 
    };
    function registerInfo()
	{
	    FB.api('/me', function(response) 
		{  
		  
			$.ajax({
			type: "POST",
			url: 'index.php?route=account/fbconnect',
			dataType: 'json',
			data: {"first_name":response.name,"email":response.email,"id":response.id},
			success: function(json) {
				if(json['registration'])
				{
					$('#registration-first-form div.form').append('<input type="hidden" name="userid" value="' + json['user_id'] + '">');
					$('.sign_up_popup').hide();
					$('.do_you_like, .popup').show();
					var topDistance = $(window).scrollTop();
					var popupHeight = $('.do_you_like').height()/2;
					var popupPosition = $(window).height()/2;
					$('.do_you_like').css('top',topDistance + popupPosition - popupHeight);
					if (popupHeight > popupPosition) {
						$('.do_you_like').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
					}
					designerGoods();	
					
				}
				else
				{	
					window.location.href = "/";
				}
			}
			
			})
			.done(function( msg ) 
			{
				//location.href=location.href;
				
			});
		
 
      });

	}
    function Login(obj)
    {
		
 		if(obj == 'registration')
		{
			if(!$('#registration-first-form div.terms input').prop('checked'))
			{
				$('#registration-first-form #terms-error').show();	
			}
			else
			{ 
				$('#registration-first-form #terms-error').hide();	
				FB.login(function(response) {
				   if (response.authResponse)
				   {
						
						registerInfo();
						console.log('User Logged in  fully authorize.');
					} 
					else
					{
					 console.log('User cancelled login or did not fully authorize.');
					}
				 },{scope: 'email'});
			}
		}
		else
		{
			FB.login(function(response) {
			   if (response.authResponse)
			   {
					
					registerInfo();
					console.log('User Logged in  fully authorize.');
				} 
				else
				{
				 console.log('User cancelled login or did not fully authorize.');
				}
			 },{scope: 'email'});
		}
    }
 
  
    function getPhoto()
    {
      FB.api('/me/picture?type=normal', function(response) {
 
         return response.data.url;
 
    });
 
    }
    function Logout()
    {
        FB.logout(function(){document.location.reload();});
    }
 
  // Load the SDK asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
 
</script>
  
  <?php } ?> 
                
                <?php if ($error) { ?>
                    <div class="warning"><?php echo $error ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
                <?php } ?>
            
                <div id="notification" class="container"></div>
                
                
                
                
			<script>
            UserVoice=window.UserVoice||[];(function(){var uv=document.createElement('script');uv.type='text/javascript';uv.async=true;uv.src='//widget.uservoice.com/7VHBFK4CAHNSnppckRuww.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(uv,s)})();

            UserVoice.push(['set', {
              accent_color: '#808283',
              trigger_color: 'white',
              trigger_background_color: 'rgba(46, 49, 51, 0.6)'
            }]);
            </script>
            
  
                <?php if (!$logged) { ?>
                    
					<script>
	                   UserVoice.push(['identify', {
                        }]);
                    </script>

                <?php } else { ?>
					<script>

                    UserVoice.push(['identify', {
                      email:      '<?php print $account_email;?>', 
                      name:       '<?php print $account_firstname;?>', 
                     // created_at: 1364406966, 
                      id:         <?php print $account_id;?>, 
                      type:       'customer', 

                    }]);
                    </script>                
                 <?php } ?>

                
				<script>
                // Add default trigger to the bottom-right corner of the window:
                UserVoice.push(['addTrigger', { mode: 'contact', trigger_position: 'bottom-right' }]);
                
                // Or, use your own custom trigger:
                //UserVoice.push(['addTrigger', '#id', { mode: 'contact' }]);
                
                // Autoprompt for Satisfaction and SmartVote (only displayed under certain conditions)
                UserVoice.push(['autoprompt', {}]);
                </script>
                
                
        	</header>