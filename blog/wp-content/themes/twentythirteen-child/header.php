<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
                <iframe class="headerfromstore" src="http://www.ormary.com/index.php?route=information/headerforblog"  scrolling="no"></iframe>
               
                <?php if ( is_single() ) : ?>
                <a href="http://www.ormary.com/blog" class="back-to-blog-home">x Back to blog home</a>	
                
<?php endif; // is_single() ?>
	<div id="page" class="hfeed site">
            

            
            <div id="main" class="site-main">
                
                <h2 class="blogmainheader"><a href="http://www.ormary.com/blog">The Ormary Blog</a></h2>