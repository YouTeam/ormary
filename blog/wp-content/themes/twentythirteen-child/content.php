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
			
        
                        <?php ormary_entry_number_of_comments(); ?>
			  
        

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
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>
		
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php get_the_ormary_excerpt() ; ?>... <div class="read-more"><a href="<?php echo  get_permalink()  ?>">Read More</a></div>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

        
</div>
</article><!-- #post -->
