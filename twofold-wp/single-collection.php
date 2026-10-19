<?php get_header(); ?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
			<?php
			if ( post_password_required() ) {
				get_template_part( 'inc/templates/password-protected' ); } else {
				?>
							<?php
								$thb_id            = get_the_ID();
								$collection_layout = get_post_meta( $thb_id, 'collection_layout', true ) ? get_post_meta( $thb_id, 'collection_layout', true ) : 'style1';
								get_template_part( 'inc/templates/collections/' . $collection_layout );
							?>
						<?php } ?>
		<?php
	endwhile;
endif;
?>
<?php
get_footer();
