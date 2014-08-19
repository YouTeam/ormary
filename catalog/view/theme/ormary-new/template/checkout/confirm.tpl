<?php if (!isset($redirect)) { ?>
<div class="col-md-6 grand_total">
      <?php foreach ($totals as $total) { ?>
      <div class="clearfix">
        <span><?php echo $total['title']; ?></span>
        <span class="price"><?php echo $total['text']; ?></span>
      </div>
      <?php } ?>
    <a href="#" class="dark_btn open_shipping_address">Place order</a>
</div>
<div class="payment"><?php  echo $payment; ?></div>
<?php } else { ?>
<script type="text/javascript">
location = '<?php echo $redirect; ?>';
</script> 
<?php } ?>
<?php }?>