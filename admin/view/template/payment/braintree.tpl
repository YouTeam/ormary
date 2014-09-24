<?php echo $header; ?>
<div id="content">

  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_test; ?></td>
            <td><?php if ($braintree_test) { ?>
              <input type="radio" name="braintree_test" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <input type="radio" name="braintree_test" value="0" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="braintree_test" value="1" />
              <?php echo $text_yes; ?>
              <input type="radio" name="braintree_test" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_merchantid; ?></td>
            <td><input type="text" name="braintree_merchantid" value="<?php echo $braintree_merchantid; ?>" /></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_publickey; ?></td>
            <td><input type="text" name="braintree_publickey" value="<?php echo $braintree_publickey; ?>" /></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_privatekey; ?></td>
            <td><input type="text" name="braintree_privatekey" value="<?php echo $braintree_privatekey; ?>" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 