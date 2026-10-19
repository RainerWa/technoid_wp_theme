<?php
add_action( 'wp_ajax_thb_proof', 'thb_proof' );
add_action( 'wp_ajax_nopriv_thb_proof', 'thb_proof' );
function thb_proof() {
	check_ajax_referer( 'thb_proof_ajax', 'security' );
	ob_start();
	$id      = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
	$checked = filter_input( INPUT_POST, 'checked', FILTER_VALIDATE_BOOLEAN );

	$data            = wp_get_attachment_metadata( $id );
	$data['checked'] = $checked;

	wp_update_attachment_metadata( $id, $data );

	echo wp_json_encode( ob_get_clean() );
	wp_die();
}

function thb_more_posts() {
	check_ajax_referer( 'thb_ajax', 'security' );
	$page       = filter_input( INPUT_POST, 'page', FILTER_VALIDATE_INT );
	$ppp        = get_option( 'posts_per_page' );
	$blog_style = ot_get_option( 'blog_style', 'style3' );

	$args = array(
		'posts_per_page' => $ppp,
		'paged'          => $page,
		'post_status'    => 'publish',
	);

	$more_query = new WP_Query( $args );

	if ( $more_query->have_posts() ) :
		while ( $more_query->have_posts() ) :
			$more_query->the_post();
			get_template_part( 'inc/templates/postbit/' . $blog_style );
	endwhile;
endif;
	wp_die();
}
add_action( 'wp_ajax_nopriv_thb_ajax', 'thb_more_posts' );
add_action( 'wp_ajax_thb_ajax', 'thb_more_posts' );

function thb_collection_style4() {
	check_ajax_referer( 'thb_collection_style4_ajax', 'security' );
	$album = filter_input( INPUT_POST, 'albumid', FILTER_VALIDATE_INT );
	$args  = array(
		'p'         => $album,
		'post_type' => 'album',
	);

	$more_query = new WP_Query( $args );
	if ( $more_query->have_posts() ) :
		while ( $more_query->have_posts() ) :
			$more_query->the_post();
			get_template_part( 'inc/templates/collections/style4-detail' );
	endwhile;
endif;
	wp_die();
}
add_action( 'wp_ajax_nopriv_thb_collection_style4', 'thb_collection_style4' );
add_action( 'wp_ajax_thb_collection_style4', 'thb_collection_style4' );
