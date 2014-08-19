<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>

<div class="container content my_ormary_page">
<?php echo $content_top; ?>
      <h4>My Ormary</h4>
        <div class="col-md-3 clearfix aside clothing_aside">
         <div class="orm_avatar">
            <img src="<?php print $image_url; ?>" alt="Avatar">
            <a href="<?php echo $edit; ?>" class="orm_avatar_hover">
              <span>Change image</span>
            </a>
          </div>
        </div>
        <div class="col-md-9 clearfix nopadding section">
          <div class="orm_profile">
            <div class="title">
              <?php echo $firstname." ".$lastname; ?>
            </div>
            <div class="sub-info light_font">
            <?php 
            	if(isset($website))
                {
            ?>	
              <span class="site">
                <a href="<?php print $website;?>" target="_blank"><?php print $website;?></a>
              </span>
              <?php }?>
              <span class="country"><?php echo $country; ?></span>
            </div>
            <div class="about light_font">
              <?php echo $biography; ?> 
            </div>
            <a href="<?php echo $edit; ?>" class="edit_my_profile">Edit my profile</a>
          </div>
          <div class="criteria clearfix">
            <a href="#" class="active following_designers_to">Following designers<span class="number"><?php print $follows_count; ?></span></a>
            <a href="#" class="recommended_designers_to">Recommended designers<span class="number2"><?php print $recomended_designers_count; ?></span></a>
            <a href="#" class="my_orders_to">My orders</a>
          </div>
          <div>
            <div class="following_designers active">

              <?php
                foreach($my_follows as $fl)
                {
                ?>
                  <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="wrap_designer_box">
                      <div class="designer_box_img">
                        <a href="#">
                          <img src="image/<?php print $fl['image'];?>" alt="<?php print $fl['name'];?>">
                        </a>
                      </div>
                      <div class="designer_box_title">
                        <a href="/index.php?route=product/manufacturer/info&manufacturer_id=<?php print $fl['mid']?>"><?php print $fl['name'];?></a>
                      </div>
                      <div class="unfollow_btn">
                        <span href="#" class="unfollow" id="<?php print $fl['mid']?>">Unfollow</span>
                      </div>
                    </div>
                  </div>
              <?php }?>
              
            </div>
            <div class="recommended_designers">
                <?php
                foreach($recomended_designers as $rd)
                {
                ?>
                  <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="wrap_designer_box">
                      <div class="designer_box_img">
                        <a href="#">
                          <img src="image/<?php print $rd['image'];?>" alt="<?php print $rd['name'];?>">
                        </a>
                      </div>
                      <div class="designer_box_title">
                        <a href="/index.php?route=product/manufacturer/info&manufacturer_id=<?php print $rd['mid']?>"><?php print $rd['name'];?></a>
                      </div>
                      <div class="unfollow_btn">
                         <span href="#" class="unfollow" id="<?php print $fl['mid']?>">Unfollow</span>
                      </div>
                    </div>
                  </div>
              <?php }?>
              
            </div>
            <div class="my_orders">
              <table>
                <thead>
                  <tr>
                    <td>Order No</td>
                    <td>Date</td>
                    <td>Order total</td>
                    <td>Status</td>
                  </tr>
                </thead>
                <tbody>
                	<?php 
                    foreach($my_orders as $o)
                    {
                    ?>
                  <tr>
                    <td><?php print $o['order_id'];?></td>
                    <td class="date"><?php print $o['date_added'];?></td>
                    <td class="price">&pound;<?php print $o['total'];?></td>
                    <td class="in_progress"><?php print $o['status']?></td>
                  </tr>
                  	<?php 
                    }
                  	?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 