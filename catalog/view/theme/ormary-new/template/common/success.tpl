<?php echo $header; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<?php echo $content_top; ?>

<div id="content" class="container content">
<!--	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
        	<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
	</div>-->
	<h4><?php echo $heading_title; ?></h4>
	<?php echo $text_message; ?>
	<div class="buttons">
		<div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
	</div>
</div>

<?php echo $content_bottom; ?>
<?php echo $footer; ?>