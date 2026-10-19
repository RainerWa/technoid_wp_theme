<?php
/**
 * Template Name: Media Album (via media_category)
 * Description: Rendert Attachments aus media_category im nativen TwoFold-Album-Layout (via thb_* Funktionen/Hooks)
 */

get_header();

$thb_id = get_the_ID();

// --- Optionen wie beim Theme (du kannst auch feste Defaults setzen) ---
$photo_proof       = get_post_meta($thb_id, 'photo_proof', true);
$true_aspect_ratio = get_post_meta($thb_id, 'true_aspect_ratio', true) ? get_post_meta($thb_id, 'true_aspect_ratio', true) : 'off';
$album_share       = get_post_meta($thb_id, 'album_share', true) ? get_post_meta($thb_id, 'album_share', true) : 'on';

// --- Welche media_category soll angezeigt werden? ---
// Variante 1: per URL ?media_category=urlaub-2025
$slug = isset($_GET['media_category']) ? sanitize_title($_GET['media_category']) : '';

// Variante 2 (optional): per Custom Field auf der Seite (z.B. ACF/Textfeld "media_category_slug")
if (!$slug) {
    $maybe_slug = get_post_meta($thb_id, 'media_category_slug', true);
    if (!empty($maybe_slug)) {
        $slug = sanitize_title($maybe_slug);
    }
}

$term = $slug ? get_term_by('slug', $slug, 'media_category') : null;

// Meta-Text oben (wie Theme, nur für media_category)
$term = null;

if (is_tax('media_category')) {
    $qo = get_queried_object();
    if ($qo && !is_wp_error($qo) && isset($qo->term_id)) {
        $term = $qo; // WP_Term
    }
}

// 2) Fallback: per URL ?media_category=urlaub-2025
if (!$term && isset($_GET['media_category'])) {
    $slug = sanitize_title($_GET['media_category']);
    $term = get_term_by('slug', $slug, 'media_category');
}

// 3) Optional: Fallback per Seiten-Meta (ACF/Custom field)
if (!$term) {
    $maybe_slug = get_post_meta(get_the_ID(), 'media_category_slug', true);
    if (!empty($maybe_slug)) {
        $term = get_term_by('slug', sanitize_title($maybe_slug), 'media_category');
    }
}

// --- Attachments aus media_category holen (WICHTIG: nur IDs) ---
$album_photos_array = [];

if ($term) {
    $q = new WP_Query([
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'post_mime_type' => 'image',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'orderby'        => 'date',
            'order'          => 'ASC',
            'tax_query'      => [[
                    'taxonomy' => 'media_category',
                    'field'    => 'term_id',
                    'terms'    => [$term->term_id],
            ]],
    ]);

    if (!empty($q->posts)) {
        $album_photos_array = $q->posts;
    }
}

?>
    <div class="page-padding">
        <div class="side_padding">
            <div class="row align-center expanded">
                <div class="small-12 medium-10 large-6 columns text-center album-header post">

                    <?php if ($meta) : ?>
                        <aside class="post-meta"><?php echo esc_html($meta); ?></aside>
                    <?php endif; ?>

                    <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
                    <?php the_content(); ?>

                    <?php if ($album_share === 'on') { do_action('thb_share'); } ?>

                    <?php if (!$term) : ?>
                        <p style="margin-top: 1rem;">
                            <strong>Keine Medien-Kategorie gewählt.</strong><br>
                            Nutze z.B. <code>?media_category=urlaub-2025</code> in der URL
                            <?php if (!empty(get_post_meta($thb_id, 'media_category_slug', true))) : ?>
                                (oder setze <code>media_category_slug</code> als Seiten-Meta).
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>

                </div>
            </div>

            <div class="masonry isotope-grid row expanded <?php echo ($photo_proof === 'on') ? 'photo-proof-enabled' : ''; ?>">
                <?php
                if (!empty($album_photos_array)) {
                    $i = 0;

                    foreach ($album_photos_array as $photo_id) {
                        $rand      = wp_rand(0, 1000);
                        $full_url  = wp_get_attachment_image_src($photo_id, 'full');
                        $image_url = wp_get_attachment_image_src($photo_id, 'twofold-1'); // Theme-size wie im Original

                        // WICHTIG: hier kannst du "style1" lassen, weil das Theme damit die Kachel-Größen mischt.
                        // Wenn du eine andere Layout-Logik willst: ggf. style4 / styleX je nach Theme-Implementierung.
                        $column_size = function_exists('thb_get_column_size') ? thb_get_column_size('style4', $i) : '';
                        $proof_class = ($photo_proof === 'on' && function_exists('thb_proof_class')) ? thb_proof_class($photo_id) : '';

                        $aspect_ratio = '';
                        if ($true_aspect_ratio === 'on') {
                            $aspect_ratio = ($photo_id && $full_url) ? (($full_url[2] / $full_url[1]) * 100) . '%' : '100%';
                            $column_size .= ' thb-true-aspect';
                        }

                        if ($true_aspect_ratio === 'on') { ?>
                            <div class="item small-12 medium-6 <?php echo esc_attr($column_size); ?> columns">
                            <figure style="padding-bottom:<?php echo esc_attr($aspect_ratio); ?> !important">
                        <?php } else { ?>
                            <figure class="item small-12 medium-6 <?php echo esc_attr($column_size); ?> columns">
                        <?php } ?>

                        <?php
                        // GENAU wie im Theme: Renderer/Caption über Actions
                        do_action('thb_render_photo', $photo_proof, $proof_class, $photo_id, $image_url, $full_url, $rand, $true_aspect_ratio);
                        do_action('thb_display_caption', $rand, $photo_id, $full_url);
                        ?>

                        </figure>

                        <?php if ($true_aspect_ratio === 'on') { ?>
                            </div>
                        <?php }

                        $i++;
                    }
                } else {
                    if ($term) {
                        echo '<p class="small-12 columns">Keine Bilder in dieser Medien-Kategorie gefunden.</p>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

<?php
get_footer();
