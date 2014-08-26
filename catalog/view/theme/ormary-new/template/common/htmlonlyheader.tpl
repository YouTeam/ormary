<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
    <head>
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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
        
        <style>
footer {
margin-top: 30px;
}


</style>

<script>

$(document).ready( function () {
    $('footer a').each ( function () {
        var _this = $(this);
        _this.attr('target' , '_top')
    }) 

})

</script>
    </head>




    <body>
   
       