<?php echo $header; ?>

<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div id="content"class="container content my_ormary_profile_page"><?php echo $content_top; ?>
  
  <h4>Designer info</h4>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="account_form">
    <div class="col-md-3 clearfix aside">
        <div class="profile_steps light_font">
            <a href="<?php echo $this->url->link('account/edit', '', 'SSL');?>">Basic information</a>
			<a href="<?php echo $address_url;?>">Address information</a>
            <a href="<?php echo $this->url->link('account/password', '', 'SSL');?>">Password</a>
            <a href="<?php echo $this->url->link('account/designer_info', '', 'SSL');?>" class="active">Designer Info</a>
		</div>
	</div>
	<div class="col-md-9 clearfix nopadding section">
    
        <?php
        if($designer_bg_img_url != '')
        {
        ?>
     		<div class="orm_avatar">
      	      <img src="<?php echo $this->url->img_link($designer_bg_img_url); ?>" alt="Designer background image"/>
			</div>
         <?php
         }
         ?>
         
	  <div class="change_designer_bg">
		<a href="#">Set designers page background image</a>
		<span>Accepted formats: jpeg, png, gif    max size 2 MB</span>
		<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
		<input name="bfile" id="bfile" type="file" />
		
	  </div>
      
    
    <a href="<?php echo $back; ?>" class="black_btn" style="float:left"><?php echo $button_back; ?></a>
    <a href="javascript::void(0)" onclick="$('#account_form').submit();" class="black_btn" style="float:left; margin-left:15px;">Save profile</a>
    </div> 
	
  </form>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>