<?php
/*
Template Name: Contact
*/
?>
<?php get_header(); ?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
			$thb_id         = get_the_ID();
			$contact_layout = get_post_meta( $thb_id, 'contact_layout', true ) ? get_post_meta( $thb_id, 'contact_layout', true ) : 'style1';
			get_template_part( 'inc/templates/contact/' . $contact_layout );
	endwhile;
endif;

get_footer();
