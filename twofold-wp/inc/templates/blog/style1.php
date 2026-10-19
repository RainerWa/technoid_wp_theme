<?php $blog_pagination_style = is_home() ? ot_get_option( 'blog_pagination_style', 'style1' ) : 'style1'; ?>
<div class="row isotope-grid masonry-blog <?php echo esc_attr( 'pagination-' . $blog_pagination_style ); ?>" data-count="<?php echo esc_attr( get_option( 'posts_per_page' ) ); ?>" data-security="<?php echo esc_attr( wp_create_nonce( 'thb_ajax' ) ); ?>">
<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'inc/templates/postbit/style1' ); ?>
<?php endwhile; endif; ?>
</div>
<?php do_action( 'thb_pagination' );
