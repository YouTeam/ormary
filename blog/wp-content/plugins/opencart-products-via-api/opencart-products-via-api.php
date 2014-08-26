<?php
/*
  Plugin Name: OpenCart Products Via Api
  Plugin URI:
  Description: Get products from your opencart store via the API.
  Version: 1.0
  Author: Andrew Johnson
  Author URI:
  License: GPL2
 */



if (!class_exists('OpencartProductsViaAPI_Widget')) :

    class OpencartProductsViaAPI_Widget extends WP_Widget {

        function OpencartProductsViaAPI_Widget() {

            // Widget settings
            $widget_ops = array('classname' => 'opencartproductsviaapi-widget', 'description' => 'Display products from your Opencart store.');

            // Create the widget
            $this->WP_Widget('opencartproductsviaapi-widget', 'OpencartProductsViaApi', $widget_ops);
        }

        function widget($args, $instance) {


            extract($args);

            global $interval;

            // User-selected settings
            $title = apply_filters('widget_title', $instance['title']);
            $api_url = $instance['api_url'];
            $category_id = $instance['category_id'];
            $posts = $instance['posts'];
            $interval = $instance['interval'];
            $date = $instance['date'];
            $datedisplay = $instance['datedisplay'];
            $datebreak = $instance['datebreak'];
            $clickable = $instance['clickable'];
            $hideerrors = $instance['hideerrors'];
            $encodespecial = $instance['encodespecial'];

            // Before widget (defined by themes)
            echo $before_widget;


            // START OF BIG COMMERCE FEATURED PRODUCTS APP

            $result = 'RESULT BC';


           add_filter('wp_feed_cache_transient_lifetime', array(&$this, 'setInterval'));

            // Get current upload directory
            $upload = wp_upload_dir();
            $cachefile = $upload['basedir'] . '/opencartproductsviaapi_' . $username . '.txt';



            if (!file_exists($cachefile) || (file_exists($cachefile) && (filemtime($cachefile) + $interval) < time()) || 1 == 1) :
                
            
            
                
      
     //           $products = BigCommerce_Api::getProducts();
       //         $productsCount = BigCommerce_Api::getProductsCount();

                // need to get the products and the product count
                
                
                $request = $api_url . '&id='.$category_id.'&limit='.$posts;
       
                $json = file_get_contents($request);
              $json = (  json_decode($json, true) ); 
                $products = $json['products'];
            
                $productsCount = '';

           //     {"id":"42", name":"Apple Cinema 30"", "price":"$119.50", "thumb":"http:\/\/opencarttest\/image\/cache\/data\/demo\/apple_cinema_30-80x80.jpg"}     
                
                
                $list = '<div class="slide-show slide-show-render slide-show-render-full flexslider Panel" data-swap-frequency="5000" id="ProductSlideShow">';

                $list .= '<ol class="bc-featured slides">';

                foreach ($products as $product) {
                    $image = $product->images[0];
                    $imageName = $image->image_file;
                    $price = explode('.', $product->price);
                    $price = $price[0];


                    $li = "<li ><a href='/index.php?route=product/product&product_id=" . $product['id'] . "'><img src='" . $product['thumb'] . "'/></a><h3>" . $product->name . "</h3><h4>" . $price . "</h4></li>";
                    $list .= $li;
                }

                $list .= "</ol></div>";

 



                // Save updated feed to cache file
           //     @file_put_contents($cachefile, $list);

            else:

                if (file_exists($cachefile)) :
                    $list = @file_get_contents($cachefile);
                endif;

            endif;

            $button = "<div class='shop-now-btn'><a class='' id='shop-now' href='".$link_to."'><span class='screen-offset'>Register</span></a></div>";
$flexslider =  '<script src="/blog/wp-content/themes/twentythirteen/js/jquery.flexslider-min.js"></script>';
                           $script = "<script type='text/javascript' charset='utf-8'>";
                            $script .= "console.log('s');";
                $script .= "$(document).ready(function() {";
                $script .= "$('#ProductSlideShow').flexslider({";
                $script .= "slideshowSpeed: 10000,";
                $script .= "animation: 'slide',";
                $script .= "pauseOnHover: true,";
                $script .= "controlNav: false,";
                $script .= "directionNav: true";
                $script .= "});";
                $script .= "});";
               
                
                $script .= "</script>";



            
            echo $list;
            echo $button;
            echo $flexslider;
        //    echo $script;



            // After widget (defined by themes)
            echo $after_widget;
        }

        // Callback helper for the cache interval filter
        function setInterval() {

            global $interval;

            return $interval;
        }

        function update($new_instance, $old_instance) {

            $instance = $old_instance;

            $instance['title'] = $new_instance['title'];
            $instance['api_url'] = $new_instance['api_url'];
            $instance['category_id'] = $new_instance['category_id'];
            $instance['posts'] = $new_instance['posts'];
            $instance['interval'] = $new_instance['interval'];
            $instance['date'] = $new_instance['date'];
            $instance['datedisplay'] = $new_instance['datedisplay'];
            $instance['datebreak'] = $new_instance['datebreak'];
            $instance['clickable'] = $new_instance['clickable'];
            $instance['hideerrors'] = $new_instance['hideerrors'];
            $instance['encodespecial'] = $new_instance['encodespecial'];
            
            
            // Delete the cache file when options were updated so the content gets refreshed on next page load
            $upload = wp_upload_dir();
            $cachefile = $upload['basedir'] . '/_opencartproductsviaapi_' . '.txt';
            @unlink($cachefile);

            return $instance;
        }

        function form($instance) {

            

          
            // Set up some default widget settings
            $defaults = array('title' => 'Featured Products', 'api_url' => '', 'category_id' => '', 'posts' => 5, 'interval' => 18000000, 'date' => 'j F Y', 'datedisplay' => true, 'datebreak' => true, 'clickable' => true, 'hideerrors' => true, 'encodespecial' => false);
            $instance = wp_parse_args((array) $instance, $defaults);
            ?>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
                <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('api_url'); ?>">API URL:</label>
                <input class="widefat" type="text" id="<?php echo $this->get_field_id('api_url'); ?>" name="<?php echo $this->get_field_name('api_url'); ?>" value="<?php echo $instance['api_url']; ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('category_id'); ?>">Category ID:</label>
                <input class="widefat" type="text" id="<?php echo $this->get_field_id('category_id'); ?>" name="<?php echo $this->get_field_name('category_id'); ?>" value="<?php echo $instance['category_id']; ?>">
            </p>
           

            <p>
                <label for="<?php echo $this->get_field_id('posts'); ?>">Number of products to display</label>
                <input class="widefat" type="text" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>">
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('posts'); ?>">Update interval</label>
                <input class="widefat" type="text" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" value="<?php echo $instance['interval']; ?>">
            </p>

            
            



            <?php
        }

    }

    endif;





// Register the plugin/widget
if (class_exists('OpencartProductsViaAPI_Widget')) :

    function loadOpencartProductsFromAPIWidget() {

        register_widget('OpencartProductsViaAPI_Widget');
    }

    add_action('widgets_init', 'loadOpencartProductsFromAPIWidget');

endif;
?>