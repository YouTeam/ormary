<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div id="content" class="container content all_designers_page">
	<?php echo $content_top; ?>
	<h4 class="top_panel_margin"><?php echo $heading_title; ?></h4>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <p><?php echo $text_email; ?></p><br>
        <div class='twocol-formelement     '> 
<span><?php echo $entry_email; ?></span><br>
            		<input type="text" name="email" value="" />
            
                        </div>
                        
        <div class='twocol-formelement   last  '>    
            
        	<input style="margin-top: 17px; margin-left: -26px"  type="submit" value="RESET PASSWORD" class="button" />
</div>    		
            </form>
</div>  
</div>   
<?php echo $content_bottom; ?>
<?php echo $footer; ?>