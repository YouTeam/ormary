<?php if (!$this->customer->isLogged()) { ?>
<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
	
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="module_login"> 
	<b><?php echo $entry_email_address; ?></b><br />
    <span style="text-align: left;"><input type="text" name="email" /></span>
    <br />
    <b><?php echo $entry_password; ?></b><br />
    <input type="password" name="password" />
        <br />
    <div style="float:left; text-align: right;"><a href="<?php echo $this->url->link('account/login', '', 'SSL');?>" class="button"><span><?php echo $button_create; ?></span></a></div>
    <div style="float:left; text-align: right;"><a onclick="$('#module_login').submit();" class="button"><span><?php echo $button_login; ?></span></a></div>
    <br style="clear:both;"/>
    </form>
  </div>
 </div>
  <script type="text/javascript"><!--
  $('#module_login input').keydown(function(e) {
	  if (e.keyCode == 13) {
		  $('#module_login').submit();
	  }
  });
  //--></script>
<?php } ?>
