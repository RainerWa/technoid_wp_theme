<?php
/*
Template Name: About
*/
?>
<?php get_header(); ?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
			$thb_id       = get_the_ID();
			$about_layout = get_post_meta( $thb_id, 'about_layout', true ) ? get_post_meta( $thb_id, 'about_layout', true ) : 'style1';
			get_template_part( 'inc/templates/about/' . $about_layout );
	endwhile;
endif;

get_footer();
