<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
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

<!--<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />-->
<link rel="stylesheet" type="text/css" href="catalog/view/theme/ormary/stylesheet/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/ormary/stylesheet/style.css" />

<link rel="stylesheet" type="text/css" href="catalog/view/theme/ormary/stylesheet/idangerous.swiper.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/ormary/fonts/fonts.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<link href="catalog/view/theme/ormary/stylesheet/font-awesome.css" rel="stylesheet">
<!--
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
-->
<!--<script src="catalog/view/javascript/ormary-js/jquery-ui-1.10.4.custom.js"></script>-->



    <!-- Include all compiled plugins (below), or include individual files as needed -->

<!--    <script src="catalog/view/javascript/ormary-js/main.js"></script>-->

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
       		<div class="container" id="container">
         		<div class="col-lg-6 col-md-5 left_side clearfix" id="header">
 					<?php if ($logo) { ?>
  						<div id="logo" class="logo">
                        	<a href="<?php echo $home; ?>">
                            	<img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
                            </a>
                        </div>
  					<?php } ?>
 					<?php //echo $language; ?>
 					<?php //echo $currency; ?>
					<?php //echo $cart; ?>
  					<div class="search" id="search" role="search">
						<input type="text" name="search" class="search_inp light_font" placeholder="Search" value="<?php echo $search; ?>">
    					<button type="submit" class="search_btn"></button>
  					</div>
 				</div>
  				<div id="welcome" class="navbar-right right_side clearfix">
					<?php if (!$logged) { ?>
                    
<!--						<div class="join">
							<a href="<?php echo $this->url->link('account/register', '', 'SSL');?>" >JOIN ORMARY</a>
	   						<span class="separator"></span>
							<a href="#" class="open_ormary">SIGN IN</a>
						</div>-->
                        
                        <div class="join clearfix">
                            <ul>
                                <li>
                                	<a href="<?php echo $this->url->link('account/register', '', 'SSL');?>" class="open_ormary">JOIN ORMARY</a>
                                </li>
                                <li>
                                	<a href="#" class="open_sign_in_popup">SIGN IN</a>
                                </li>
                            </ul>
                        </div>
                        
                        
                    <?php } else { ?>
                    
						<ul>
                            <li>
                                <a href="<?php echo $account; ?>" class="account">
                                    <div class="account_avatar">
                                        <img src="<?php echo $this->url->img_link($this->customer->getProfileImgURL());?>" alt="Account">
                                    </div>
                                    <span><?php echo $account_firstname ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $home; /*$this->url->link('account/fashionfeed', '', 'SSL')*/ ?>" class="stylefeed">
                                    <span>Fashionfeed</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $wishlist; ?>" class="wardrobe">
                                    <span>Wardrobe</span>
                                    <span class="number">0</span>
                                </a>
                            </li>
                            <li class="open_cart_dropdown">
                                <a href="<?php echo $shopping_cart; ?>" class="cart">
                                    <span>Cart</span>
                                    <span class="number">0</span>
                                </a>	
                            </li>
                            <li class="open_cart_dropdown">
                                <a href="<?php echo $this->url->link('account/logout', '', 'SSL') ?>" class="cart">Logout</a>	
                            </li>
                        </ul>  
                    
                    
                    
                    
                    
<!--                        <div class="account">
                            <a href="<?php echo $account; ?>"><img src="<?php echo $this->url->img_link($this->customer->getProfileImgURL());?>" alt="Account"></a>
                            <a href="<?php echo $account; ?>"><?php echo $account_firstname ?></a>
                        </div>
                        <div class="stylefeed">
                            <a href="<?php echo $this->url->link('account/fashionfeed', '', 'SSL') ?>">Fashionfeed</a>
                        </div>
                        <div class="wardrobe">
                            <a href="<?php echo $wishlist; ?>">Wardrobe</a>
                            <span class="number">0</span>
                        </div>
                        <div class="cart">
                            <a href="<?php echo $shopping_cart; ?>">Cart</a>
                            <span class="number">0</span>
                        </div>
                        <div class="cart">
                            <a href="<?php echo $this->url->link('account/logout', '', 'SSL') ?>">Logout</a>
                        </div>-->
        
                    <?php } ?>
  				</div>
			</div>
		</div>
<?php if ($categories) { ?>
<div class="container-fluid">
        <div class="row">
          <div class="navbar navbar-default main_menu" id="menu">
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
				<li><a href="<?php echo $this->url->link('product/manufacturer');?>">JUST IN</a></li>
                <li><a href="<?php echo $this->url->link('product/manufacturer');?>">DESIGNERS</a></li>
    <?php foreach ($categories as $category) { ?>
    <li ><a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category['name']; ?><b class="caret"></b></a>
      <?php if ($category['children']) { ?>
        <?php for ($i = 0; $i < count($category['children']);) { ?>
        <ul class="dropdown-menu orm_sub_dropdown-menu">
          <li class="menu-item light_font"><a href="<?php echo $category['href']; ?>">All <?php print strtolower($category['name']); ?></a></li>
          <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
          <?php for (; $i < $j; $i++) { ?>
          <?php if (isset($category['children'][$i])) { ?>
          <li class="menu-item light_font"><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>
      <?php } ?>
    </li>
    <?php } ?>
	<li><a href="#">BLOG</a></li>
  <li><a href="#">ABOUT</a></li>
  </ul>
  
	<?php //echo $currency; ?>
</div>
</div></div></div></div>
<?php } ?>
<?php if ($error) { ?>
    
    <div class="warning"><?php echo $error ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
    
<?php } ?>
<div id="notification"></div>
</header>