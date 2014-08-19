<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php $heading_title = isset($information_description[1]) ? $information_description[1]['title'] : '';
	foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning;  ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a><a href="#tab-data"><?php echo $tab_data; ?></a><a href="#tab-design"><?php echo $tab_design; ?></a><?php if (strlen(stristr($heading_title,'about us')) > 0){?><a href="#tab-team">Team</a><a href="#tab-offices">Contact</a><?php }?></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                <td><input type="text" name="information_description[<?php echo $language['language_id']; ?>][title]" size="100" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['title'] : ''; ?>" />
                  <?php if (isset($error_title[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>
			  <?php if (strlen(stristr($heading_title,'about us')) > 0){?><tr>
			  <td>
			  Team Image
			  </td>
			  <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="team_thumb" /><br />
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="team_image" />
                  <a onclick="image_upload('team_image', 'team_thumb');">Browse</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#team_thumb').attr('src', ''); $('#team_image').attr('value', '');">Clear</a></div></td>
			  </tr>
			  <?php } ?>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_description; ?></td>
                <td><textarea name="information_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['description'] : ''; ?></textarea>
                  <?php if (isset($error_description[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>
            </table>
          </div>
          <?php } ?>
        </div>
        <div id="tab-data">
          <table class="form">
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $information_store)) { ?>
                    <input type="checkbox" name="information_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="information_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($store['store_id'], $information_store)) { ?>
                    <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_keyword; ?></td>
              <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_bottom; ?></td>
              <td><?php if ($bottom) { ?>
                <input type="checkbox" name="bottom" value="1" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="bottom" value="1" />
                <?php } ?></td>
            </tr>            
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
            </tr>
          </table>
        </div>
        <div id="tab-design">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_store; ?></td>
                <td class="left"><?php echo $entry_layout; ?></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="left"><?php echo $text_default; ?></td>
                <td class="left"><select name="information_layout[0][layout_id]">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($information_layout[0]) && $information_layout[0] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php foreach ($stores as $store) { ?>
            <tbody>
              <tr>
                <td class="left"><?php echo $store['name']; ?></td>
                <td class="left"><select name="information_layout[<?php echo $store['store_id']; ?>][layout_id]">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($information_layout[$store['store_id']]) && $information_layout[$store['store_id']] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php } ?>
          </table>
        </div>
		</form>
		<?php if (strlen(stristr($heading_title,'about us')) > 0){?>
		<div id="tab-team">
          <table class="list">
		  <tbody>
            <?php foreach ($members as $mid => $mem) { ?>
              <tr>
                <td class="left"><?php echo $mem['name']; ?></td>
                <td class="right">
					<a onclick="EditMember(<?php echo $mem['id']; ?>)">Edit</a>
					<a href="<?php echo $delete_member_action.$mem['id']; ?>">Delete</a>
                </td>
              </tr>
			  <tr id="member<?php echo $mem['id']; ?>row" style="display:none;">
			  <td colspan="2">
			  <form action="<?php echo $save_member_action; ?>" method="post" enctype="multipart/form-data" id="member<?php echo $mem['id']; ?>form">
				<input type="hidden" name="member_id" value="<?php echo $mem['id']; ?>"/>
				<table id="member<?php echo $mem['id']; ?>">
					<tr><td>Name</td><td><input name='name' type="text" value="<?php echo $mem['name']; ?>"/></td><td>Facebook (url)</td><td><input name='fb_url' type="text" value="<?php echo $mem['fb_url']; ?>"/></td></tr>
					<tr><td>Position</td><td><input name='position' type="text" value="<?php echo $mem['position']; ?>"/></td><td>Twitter (url)</td><td><input name='twi_url' type="text" value="<?php echo $mem['twi_url']; ?>"/></td></tr>
					<tr><td>Profile image</td><td>
					
					<div class="image"><img src="../image/<?php echo $mem['photo_url']; ?>" alt="" id="mem<?php echo $mem['id']; ?>photo" /><br />
                  <input type="hidden" name="image" value="<?php echo $mem['photo_url']; ?>" id="mem<?php echo $mem['id']; ?>image" />
                  <a onclick="image_upload('mem<?php echo $mem['id']; ?>image', 'mem<?php echo $mem['id']; ?>photo');">Browse</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#mem<?php echo $mem['id']; ?>photo').attr('src', ''); $('#mem<?php echo $mem['id']; ?>image').attr('value', '');">Clear</a></div></td>
					
					
					<td>LinkedIn (url)</td><td><input type="text" name='li_url' value="<?php echo $mem['li_url']; ?>" /></td></tr>
					<tr><td>Biography</td><td colspan="3"><textarea name='bio' style="width:100%; height: 50px;"><?php echo $mem['bio']; ?></textarea></td></tr>
					<tr><td colspan="4"><div class="buttons" style="float:right"><a onclick="$('#member<?php echo $mem['id']; ?>form').submit();" class="button">Save</a></div></td></tr>
				</table>
				</form>
				</td>
				</tr>
            <?php } ?>
			<tr id="new_member_row" style="display:none;">
			  <td colspan="2">
			  <form action="<?php echo $save_member_action; ?>" method="post" enctype="multipart/form-data" id="new_member_form">
				<input type="hidden" name="member_id" value="0"/>
				<table id="new_member">
					<tr><td>Name</td><td><input name='name' type="text" value=""/></td><td>Facebook (url)</td><td><input name='fb_url' type="text" value=""/></td></tr>
					<tr><td>Position</td><td><input name='position' type="text" value=""/></td><td>Twitter (url)</td><td><input name='twi_url' type="text" value=""/></td></tr>
					<tr><td>Profile image</td><td>
					
					<div class="image"><img src="" alt="" id="mem_photo" /><br />
                  <input type="hidden" name="image" value="" id="mem_image" />
                  <a onclick="image_upload('mem_image', 'mem_photo');">Browse</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#mem_photo').attr('src', ''); $('#mem_image').attr('value', '');">Clear</a></div></td>
					
					<td>LinkedIn (url)</td><td><input type="text" name='li_url' value=""/></td></tr>
					<tr><td>Biography</td><td colspan="3"><textarea name='bio' style="width:100%; height: 50px;"></textarea></td></tr>
					<tr><td colspan="4"><div class="buttons" style="float:right"><a onclick="$('#new_member_form').submit();" class="button">Save</a></div></td></tr>
				</table>
				</form>
				</td>
			</tr>
            </tbody>
          </table>
		  <div class="buttons" style="float:right"><a onclick="AddMember()" id="addMemberBtn" class="button">Add</a></div>
        </div>
		<div id="tab-offices">
          <table class="list">
		  <tbody>
            <?php foreach ($offices as $oid => $office) { ?>
              <tr>
                <td class="left"><?php echo $office['name']; ?></td>
                <td class="right">
					<a onClick="EditOffice(<?php echo $office['id']; ?>)">Edit</a>
					<a href="<?php echo $delete_office_action.$office['id']; ?>">Delete</a>
				</td>
              </tr>
			  <tr id="office<?php echo $office['id']; ?>row" style="display:none;">
			  <td colspan="2">
			  <form action="<?php echo $save_office_action; ?>" method="post" enctype="multipart/form-data" id="office<?php echo $office['id']; ?>form">
				<input type="hidden" name="office_id" value="<?php echo $office['id']; ?>"/>
				<table id="office<?php echo $office['id']; ?>" style="min-width:500px;">
					<tr><td>Name</td><td><input name='name' type="text" value="<?php echo $office['name']; ?>" style="width:100%;"/></td></tr>
					<tr><td>Contact info</td><td><textarea name='addr' style="width:100%; height: 250px;"><?php echo $office['addr']; ?></textarea></td></tr>
					<tr><td colspan="2"><div class="buttons" style="float:right"><a onclick="$('#office<?php echo $office['id']; ?>form').submit();" class="button">Save</a></div></td></tr>
				</table>
				</form>
				</td>
				</tr>
				<?php } ?>
			  <tr id="new_office_row" style="display:none;">
			  <td colspan="2">
			  <form action="<?php echo $save_office_action; ?>" method="post" enctype="multipart/form-data" id="new_office_form">
				<input type="hidden" name="office_id" value="0"/>
				<table id="new_office" style="min-width:500px;">
					<tr><td>Name</td><td><input name='name' type="text" value="" style="width:100%;"/></td></tr>
					<tr><td>Contact info</td><td><textarea name='addr' style="width:100%; height: 250px;"></textarea></td></tr>
					<tr><td colspan="2"><div class="buttons" style="float:right"><a onclick="$('#new_office_form').submit();"  class="button">Save</a></div></td></tr>
				</table>
				</form>
				</td>
				</tr>
            </tbody>
          </table>
		  <div class="buttons" style="float:right"><a onclick="AddOffice()" id="addOfficeBtn" class="button">Add</a></div>
        </div>
      <?php }?>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>

function EditMember(id){
	$('#member'+id +'row').css('display','block');
}

function AddMember(){
	$('#new_member_row').css('display','block');
	$('#addMemberBtn').css('display','none');
}

function EditOffice(id){
	$('#office'+id +'row').css('display','block');
}

function AddOffice(){
	$('#new_office_row').css('display','block');
	$('#addOfficeBtn').css('display','none');
}

//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: 'Image manager',
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
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs(); 
//--></script> 
<?php echo $footer; ?>