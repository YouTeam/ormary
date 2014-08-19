<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($shipping_methods) { ?>
<table class="radio" style="height:1px; visibility:hidden;">
  <?php foreach ($shipping_methods as $shipping_method) { ?>
  <tr>
    <td colspan="3"><b><?php echo $shipping_method['title']; ?></b></td>
  </tr>
  <?php if (!$shipping_method['error']) { ?>
  <?php foreach ($shipping_method['quote'] as $quote) { ?>
  <tr class="highlight">
    <td><?php if ($quote['code'] == $code || !$code) { ?>
      <?php $code = $quote['code']; ?>
      <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" checked="checked" />
      <?php } else { ?>
      <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" />
      <?php } ?></td>
    <td><label for="<?php echo $quote['code']; ?>"><?php echo $quote['title']; ?></label></td>
    <td style="text-align: right;"><label for="<?php echo $quote['code']; ?>"><?php echo $quote['text']; ?></label></td>
  </tr>
  <?php } ?>
  <?php } else { ?>
  <tr>
    <td colspan="3"><div class="error"><?php echo $shipping_method['error']; ?></div></td>
  </tr>
  <?php } ?>
  <?php } ?>
</table>
<div class="block clearfix shipping_methods">
          <div class="caption">
            Shipping methods
          </div>
		  <?php foreach ($shipping_methods as $shipping_method) { foreach ($shipping_method['quote'] as $quote) { ?>
          <div class="clearfix">
            <div class="shipping wrap_radio">
               <?php echo $quote['title']; ?>
            </div>
            <div class="business_days">
              <img src="">
            </div>
            <div class="price">
              <?php echo $quote['text']; ?>
            </div>
          </div>
		  <?php }} ?>
        </div>
<br />
<?php } ?>
<div class="block clearfix order_review">
          Is the a gift? Write a personal message.
		  <div>
<textarea name="comment" ><?php echo $comment; ?></textarea></div>
</div>
<!--<br />
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-shipping-method" class="button" />
  </div>
</div>
-->