        </div>
        <footer>
            <div class="container-fluid footer_top">
                <div class="container">
                    <div class="social-icons clearfix">
                        <a href="https://www.facebook.com/ormary?fref=ts">
                        	<i class="fa fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/Ormary_Ltd">
                        	<i class="fa fa-twitter"></i>
                        </a>
                        <a href="#">
                        	<i class="fa fa-google-plus"></i>
                        </a>
                        <a href="http://www.pinterest.com/ormarystyle/">
                        	<i class="fa fa-pinterest"></i>
                        </a>
                        <a href="#">
                        	<i class="fa fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        	<div class="container footer_middle">
        		<div class="col-md-3 col-sm-3">
                    <ul>
                    	<li class="caption"><a href="<?php echo $home; ?>">Ormary.com</a></li>
                    	<li><a href="<?php echo $informations[4]['href'];?>">About</a></li>
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="<?php echo $informations[3]['href'];?>">Privacy Policy</a></li>
                        <li><a href="<?php echo $informations[5]['href'];?>">Terms and Conditions</a></li>
                        <li><a href="<?php echo $sitemap; ?>">Sitemap</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-3">
                    <ul>
                        <li class="caption"><a href="/index.php?route=product/category&path=0&featured=1">Shopping</a></li>
                        <?php
                        foreach($categories as $c)
                        {                        
                            print '<li><a href="'.$c['href'].'">'.$c['name'].'</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-3">
                    <ul>
                        <li class="caption">Customer Service</li>
                        <li><a href="<?php echo $contact; ?>">Help & Contact Us</a></li>
                        <li>Delivery Information</li>
                        <li><a href="<?php echo $return; ?>">Returns and Exchanges</a></li>
                        <li>Payment Security</li>
                        <li>FAQs</li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-3">
                    <ul>
                        <li class="caption">Member Services</li>
                        <?php if (!$logged) { ?>
                        	<li><a href="#" class="open_sign_in_popup">Sign in</a></li>
                            <li><a href="<?php echo $this->url->link('account/register', '', 'SSL');?>" class="open_ormary">Join Ormary</a></li>
                        <?php } else { ?> 
                            <li><a href="<?php echo $account; ?>">My Ormary</a></li>
                            <li><a href="<?php echo $wishlist; ?>">My Wardrobe</a></li>
                            <li><a href="<?php echo $home; ?>">My Fashionfeed</a></li>
                        <?php } ?>     
                        <li>
<!--                            <div class="sign_up">
                            	<input type="text" placeholder="Sign up to newsletter" class="">
                            	<input type="submit" value=" ">
                            </div>-->
                        </li>
                    </ul>
                </div>
        	</div>
            <div class="container footer_bottom text-center">
            	<a href="#">
            		<img src="catalog/view/theme/ormary-new/images/pay1.png" alt="">
            	</a>
            	<a href="#">
            		<img src="catalog/view/theme/ormary-new/images/pay2.png" alt="">
            	</a>
            </div>
        	<div class="copyright  text-center">
            	©2014 Ormary  All rights reserved
            </div>
        </footer>

	
        <script type="text/javascript" src="catalog/view/javascript/common.js"></script>    

        <script src="catalog/view/javascript/ormary-js/jquery-ui-1.10.4.custom.js"></script>
        <script src="catalog/view/javascript/ormary-js/bootstrap.min.js"></script>
        <script src="catalog/view/javascript/ormary-js/bootstrap-hover-dropdown.js"></script>
        <script src="catalog/view/javascript/ormary-js/idangerous.swiper-2.1.min.js"></script>
        <script src='catalog/view/javascript/ormary-js/jquery.elevatezoom.js'></script>
        <script src="catalog/view/javascript/ormary-js/iscroll.js"></script>
        <script src="catalog/view/javascript/ormary-js/main.js"></script>
	</body>
</html>