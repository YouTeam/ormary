<?php echo $header; ?>
<div id="content">
<!--  <div class="breadcrumb">
    <?php //foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php //echo $breadcrumb['separator']; ?><a href="<?php //echo $breadcrumb['href']; ?>"><?php //echo $breadcrumb['text']; ?></a>
    <?php //} ?>
  </div>
  <?php //if ($error_warning) { ?>
  <div class="warning"><?php //echo $error_warning; ?></div>
  <?php //} ?>
  <?php //if ($success) { ?>
  <div class="success"><?php //echo $success; ?></div>
  <?php //} ?>-->
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
              
              
              
                        	<tr>
              <td><strong>Top Banner </strong></td>
              <td></td>
            </tr>
            <tr>
              <td><span class="required">*</span>Top Banner Text Top</td>
              <td><input type="text" name="block5_text1" value="<?php echo $block5_text1; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
			<tr>
              <td><span class="required">*</span>Top Banner Text bottom</td>
              <td><input type="text" name="block5_text2" value="<?php echo $block5_text2; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span>Top Banner Link</td>
              <td><input type="text" name="block5_link" value="<?php echo $block5_link; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td>Top Banner Image</td>
              <td><div class="image"><img src="<?php echo $block5_thumb; ?>" alt="" id="thumb5" /><br />
                  <input type="hidden" name="block5_image" value="<?php echo $block5_image; ?>" id="image5" />
                  <a onclick="image_upload('image5', 'thumb5');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb5').attr('src', '<?php echo $no_image; ?>'); $('#image5').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
            
            <tr>
              <td></td>
              <td></td>
            </tr>
              
              
              
              
          	<tr>
              <td><strong>Left Block </strong></td>
              <td></td>
            </tr>
            <tr>
              <td><span class="required">*</span>Left Block Text top</td>
              <td><input type="text" name="block1_text1" value="<?php echo $block1_text1; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
			<tr>
              <td><span class="required">*</span>Left Block Text bottom</td>
              <td><input type="text" name="block1_text2" value="<?php echo $block1_text2; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span>Left Block Link</td>
              <td><input type="text" name="block1_link" value="<?php echo $block1_link; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td>Left Block Image</td>
              <td><div class="image"><img src="<?php echo $block1_thumb; ?>" alt="" id="thumb1" /><br />
                  <input type="hidden" name="block1_image" value="<?php echo $block1_image; ?>" id="image1" />
                  <a onclick="image_upload('image1', 'thumb1');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb1').attr('src', '<?php echo $no_image; ?>'); $('#image1').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
            
            <tr>
              <td></td>
              <td></td>
            </tr>
            
            <tr>
              <td><strong>Middle Top Block </strong></td>
              <td></td>
            </tr>
            <tr>
              <td><span class="required">*</span>Middle Top Block Text top</td>
              <td><input type="text" name="block2_text1" value="<?php echo $block2_text1; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
			<tr>
              <td><span class="required">*</span>Middle Top Block Text bottom</td>
              <td><input type="text" name="block2_text2" value="<?php echo $block2_text2; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span>Middle Top Block Link</td>
              <td><input type="text" name="block2_link" value="<?php echo $block2_link; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td>Middle Top Block Image</td>
              <td><div class="image"><img src="<?php echo $block2_thumb; ?>" alt="" id="thumb2" /><br />
                  <input type="hidden" name="block2_image" value="<?php echo $block2_image; ?>" id="image2" />
                  <a onclick="image_upload('image2', 'thumb2');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb2').attr('src', '<?php echo $no_image; ?>'); $('#image2').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
            
            
            
             <tr>
              <td></td>
              <td></td>
            </tr>
            
            <tr>
              <td><strong>Right Top Block </strong></td>
              <td></td>
            </tr>
            <tr>
              <td><span class="required">*</span>Right Top Block Text top</td>
              <td><input type="text" name="block3_text1" value="<?php echo $block3_text1; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
			<tr>
              <td><span class="required">*</span>Right Top Block Text bottom</td>
              <td><input type="text" name="block3_text2" value="<?php echo $block3_text2; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span>Right Top Block Link</td>
              <td><input type="text" name="block3_link" value="<?php echo $block3_link; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td>Right Top Block Image</td>
              <td><div class="image"><img src="<?php echo $block3_thumb; ?>" alt="" id="thumb3" /><br />
                  <input type="hidden" name="block3_image" value="<?php echo $block3_image; ?>" id="image3" />
                  <a onclick="image_upload('image3', 'thumb3');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb3').attr('src', '<?php echo $no_image; ?>'); $('#image3').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
            
            
            
             <tr>
              <td></td>
              <td></td>
            </tr>
            
            <tr>
              <td><strong>Right Bottom Block </strong></td>
              <td></td>
            </tr>
            <tr>
              <td><span class="required">*</span>Right Bottom Block Text top</td>
              <td><input type="text" name="block4_text1" value="<?php echo $block4_text1; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
			<tr>
              <td><span class="required">*</span>Right Bottom Block Text bottom</td>
              <td><input type="text" name="block4_text2" value="<?php echo $block4_text2; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span>Right Bottom Block Link</td>
              <td><input type="text" name="block4_link" value="<?php echo $block4_link; ?>" size="40" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td>Right Bottom Block Image</td>
              <td><div class="image"><img src="<?php echo $block4_thumb; ?>" alt="" id="thumb4" /><br />
                  <input type="hidden" name="block4_image" value="<?php echo $block4_image; ?>" id="image4" />
                  <a onclick="image_upload('image4', 'thumb4');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb4').attr('src', '<?php echo $no_image; ?>'); $('#image4').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
            
          </table>
        </div>
        
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(text) {
						$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<?php echo $footer; ?>