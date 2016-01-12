<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

$active = get_option('woosvi_activate');
$lightbox = get_option('woosvi_lightbox');
$class = "";
$divlens_open = '';
$divlens_close = '';
if ($active) {
    $class .= " woosvilens";
    $divlens_open = '<div class="magnifywoosvi">';
    $divlens_close = '</div>';
}
if ($lightbox) {
    $class .= " woosvilightbox";
}
?>
<div class="images woosvi_images<?php echo $class; ?>">

    <?php
    if (has_post_thumbnail()) {

        $image_title = esc_attr(get_the_title(get_post_thumbnail_id()));
        $image_caption = get_post(get_post_thumbnail_id())->post_excerpt;
        $image_link = wp_get_attachment_url(get_post_thumbnail_id());
        $image = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
            'title' => $image_title,
            'alt' => $image_title
        ));

        $attachment_count = count($product->get_gallery_attachment_ids());

        if ($attachment_count > 0) {
            $gallery = '[product-gallery]';
        } else {
            $gallery = '';
        }

        echo apply_filters('woocommerce_single_product_image_html', sprintf('%s<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>%s', $divlens_open, $image_link, $image_caption, $image, $divlens_close), $post->ID);
    } else {

        echo apply_filters('woocommerce_single_product_image_html', sprintf('<img src="%s" alt="%s" />', wc_placeholder_img_src(), __('Placeholder', 'woocommerce')), $post->ID);
    }
    ?>

    <?php do_action('woocommerce_product_thumbnails'); ?>

</div>
