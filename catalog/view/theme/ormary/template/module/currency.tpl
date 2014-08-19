<?php if (count($currencies) > 1) { ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
  <div id="currency">
  <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $currency_code ?> <b class="caret"></b></a>
				<ul class="dropdown-menu orm_sub_dropdown-menu">
                    <?php foreach ($currencies as $currency) { ?>
    <?php if ($currency['code'] != $currency_code) { ?>
        <?php if ($currency['symbol_left']) { ?>
		<li class="light_font"><a title="<?php echo $currency['title']; ?>" onclick="$('input[name=\'currency_code\']').attr('value', '<?php echo $currency['code']; ?>'); $(this).parent().parent().parent().submit();"><?php echo $currency['symbol_left']." ".$currency['code'];?></a></li>
    <?php } else { ?>
		<li class="light_font"><a title="<?php echo $currency['title']; ?>" onclick="$('input[name=\'currency_code\']').attr('value', '<?php echo $currency['code']; ?>'); $(this).parent().parent().parent().submit();"><?php echo $currency['symbol_right']." ".$currency['code']; ?></a></li>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    <input type="hidden" name="currency_code" value="" />
    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
  </div>
</form>
<?php } ?>
