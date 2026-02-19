<?php get_header(); ?>

<h1><?php single_term_title(); ?></h1>

<?php
$current_term = get_queried_object();

$args = array(
	'post_type'      => 'attachment',
	'post_status'    => 'inherit',
	'posts_per_page' => -1,
	'tax_query'      => array(
		array(
			'taxonomy' => 'media_category',
			'field'    => 'term_id',
			'terms'    => $current_term->term_id,
		),
	),
);

$query = new WP_Query($args);

if ($query->have_posts()) :
	echo '<div class="media-grid">';
	while ($query->have_posts()) : $query->the_post();
		$image = wp_get_attachment_image(get_the_ID(), 'medium');
		echo '<div class="media-item">';
		echo $image;
		echo '</div>';
	endwhile;
	echo '</div>';
endif;

wp_reset_postdata();
?>

<?php get_footer(); ?>
