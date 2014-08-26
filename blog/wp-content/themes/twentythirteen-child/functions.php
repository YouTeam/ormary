<?php
if ( ! function_exists( 'ormary_entry_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own twentythirteen_entry_date() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function ormary_entry_date( $echo = true ) {
    




	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s"><div class="daynumber">%4$s</div><div class="month">%5$s</div><div class="year">%6$s</div></time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'twentythirteen' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date('j') ),
                esc_html( substr  ( get_the_date('F') , 0 , 3 ) ),
                esc_html( get_the_date('Y') )
                
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;




if ( ! function_exists( 'ormary_entry_number_of_comments' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own twentythirteen_entry_date() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function ormary_entry_number_of_comments( $echo = true ) {
    

    $comments = sprintf( '<div class="meta-number-of-comments">%1$s</div>',
		get_comments_number()
	);
    
    
    
    

	if ( $echo )
		echo $comments;

	return $date;
}
endif;




function get_the_ormary_excerpt($echo = true ){
$excerpt = get_the_content();
$excerpt = strip_shortcodes($excerpt);
$excerpt = strip_tags($excerpt);
$the_str = substr($excerpt, 0, 190);
	if ( $echo )
		echo $the_str;
return $the_str;
}