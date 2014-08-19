<div class="container orm_slider">
    <div class="swiper-container orm_main_slider">
    	<?php
        if(count($banners)>1)
        {
        ?>
        <a class="arrow-left" href="#"></a> 
        <a class="arrow-right" href="#"></a>
        <?php
        }
        ?>
        <div class="swiper-wrapper">
         	<?php foreach ($banners as $banner) { ?>
                <div class="swiper-slide">
                	<?php if ($banner['link']) { ?>
                    	<a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a>
                    <?php } else { ?>
                    	<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
                    <?php } ?>    
                </div>

           	<?php } ?>
    	</div>
    </div>
</div>