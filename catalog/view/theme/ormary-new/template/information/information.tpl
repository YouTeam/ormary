<?php echo $header; ?>
<div id="content"><?php echo $content_top; ?>
 
  <div class="container content my_ormary_profile_page" style="margin-top:120px;">
  <div class="top_panel"><h4><?php echo $heading_title; ?></h4></div>
  <div class="col-md-12 clearfix nopadding about">
  <?php if (strlen(stristr($heading_title,'about us')) > 0){?>
          <h5>The Team</h5>
  <img src="./image/<?php echo $team_img_url; ?>" alt="Team"/>
  <p><?php echo $description; ?></p>
  
  <div class="members">
  <?php foreach($members as $mid => $mem)
	print '<div class="member clearfix">
	  <div class="photo">
		<img src="./image/'.$mem['photo_url'].'" >
	  </div>
	  <div class="about_member">
		<div class="name">'.$mem['name'].'</div>
		<div class="post">'.$mem['position'].'</div>
	  </div>
	  <div class="social">
		<a href="'.$mem['fb_url'].'">
		  <i class="fa fa-facebook"></i>
		</a>
		<a href="'.$mem['twi_url'].'">
		  <i class="fa fa-twitter"></i>
		</a>
		<a href="'.$mem['li_url'].'">
		  <i class="fa fa-linkedin"></i>
		</a>
	  </div>
	  <div class="view_bio">
		<a href="javascript:void()">View bio</a>
	  </div>
	  <div class="biography">
		<p>'.$mem['bio'].'</p>
	  </div>
	</div>';?>
  </div>
  
  <h5>Contacts</h5>
  
  <div class="office clearfix">
            <div class="office_img">
              <img src="./image/data/office.png" alt="Office">
            </div>
			<?php $escape = array("\r\n", "\n", "\r"); 
			foreach($offices as $oid => $office)
				print ' <div class="office_info">
					  <h6>'.$office['name'].'</h6>
					  '.str_replace($escape, '<br/>', $office['addr']).'
					</div>';?>	
          </div>
		  <?php }
		  else
		  {?>
		  <p><?php echo $description; ?></p>
		  <?php } ?>
  </div>
  </div>
 
</div>
<?php echo $footer; ?>