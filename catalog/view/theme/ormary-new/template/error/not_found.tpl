<?php echo $header; ?>
<?php //echo $column_right; ?>
<?php echo $content_top; ?>

<div class="container content">
    <h4><?php echo $heading_title; ?></h4>
    <div class="col-md-2 clearfix aside clothing_aside">
    	<?php echo $column_left; ?>
    </div>
    <div class="col-md-10 clearfix nopadding">
    	<div class="section clearfix">
    		<div class="no_results">
                <div class="caption">
                Sorry, no results matched your search request.
                </div>
    			<div class="suggestions light_font">
                    <p>Suggestions:</p>
                    <p>1. Make sure all words are spelled correctly.</p>
                    <p>2. Reduce filter conditions for more results.</p>
                    <p>3. Try other keywords.</p>
                </div>
    		</div>
    	</div>
    </div>
</div>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>