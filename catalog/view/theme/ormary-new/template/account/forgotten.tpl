<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div id="content" class="container content all_designers_page">
	<?php echo $content_top; ?>
	<h4><?php echo $heading_title; ?></h4>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    	<p><?php echo $text_email; ?></p>
    	<div class="">
            <table class="form">
            	<tr>
            		<td><?php echo $entry_email; ?></td>
            		<td><input type="text" name="email" value="" /></td>
            	</tr>
            </table>
    	</div>
    	<div class="buttons">
    		<div class="left">
            	<a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a>
            </div>
    		<div class="right">
    			<input type="submit" value="<?php echo $button_continue; ?>" class="button" />
    		</div>
    	</div>
    </form>
</div>  
</div>   
<?php echo $content_bottom; ?>
<?php echo $footer; ?>