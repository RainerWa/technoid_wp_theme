<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		if ( post_password_required() ) {
			get_template_part( 'inc/templates/password-protected' );
		} else {
			$thb_id      = get_the_ID();
			$home_layout = get_post_meta( $thb_id, 'home_layout', true ) ? get_post_meta( $thb_id, 'home_layout', true ) : 'style1';
			get_template_part( 'inc/templates/homepage/' . $home_layout );
		}
	endwhile;
endif;

get_footer();
