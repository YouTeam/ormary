<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    
    <div class="entry-meta">
			<?php ormary_entry_date(); ?>
			
        
                        <?php /* ormary_entry_number_of_comments(); */ ?>
			  
        

		</div><!-- .entry-meta -->
            
    
    
    <div class="blogrollcontent"
    <header class="entry-header">
            
        
        
        		<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<?php endif; // is_single() ?>
          
            


                <div class="rollauthor">
                    
                    
                    <?php 
                        $author = get_the_author(); 
                        
                        echo '//By ' . $author;
                    ?>
                </div>
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
		<div class="entry-thumbnail">
                    
                    <?php
echo                     "<img src='".wp_get_attachment_url( get_post_thumbnail_id($post->ID) )."'  class='attachment-post-thumbnail wp-post-image' />";
?>		
</div>
		<?php endif; ?>
		
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
            <?php if ( is_single() ) : ?><?php
            		the_content( __( '' ) );
?>
            
            <?php

  $custom_fields = get_post_custom($post->ID);
  $my_custom_field = $custom_fields['SHOP THE COLLECTION'];
  foreach ( $my_custom_field as $key => $value ) {
      
      echo "<a href='/".$value."' class='post-shop-the-collection' >SHOP THE COLLECTION</a>";
      
  }

?>
            
            <?php else: ?>
            
            
		<?php get_the_ormary_excerpt() ; ?>... <div class="read-more"><a href="<?php echo  get_permalink()  ?>">Read More</a></div>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                
                	<?php endif; // is_single() ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

        
</div>
</article><!-- #post -->
