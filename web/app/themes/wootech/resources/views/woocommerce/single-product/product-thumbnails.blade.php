<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.1
 */
use Packages\Wordpress\Plugins\ACF\Functions as AcfFunctions;
use Packages\Wordpress\Theme\Functions as ThemeFunctions;

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product, $post;

// Get post meta.
$sectionPostMeta = AcfFunctions::getPostTypeMeta(
	$post->post_type,
	$post->ID
);

// Get posts.
$sectionRows = json_decode($sectionPostMeta['section_product_splash_content'], true);

$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids && $product->get_image_id() ) {
	foreach ( $attachment_ids as $attachment_id ) {
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
	}
}

// Do we have rows?
if (ThemeFunctions::hasValidArrayContents($sectionRows)) {
	echo '<br><br>';
	foreach ($sectionRows as $sectionRow) {
		echo implode('', [
			'<div data-thumb="' . $sectionRow['url'] . '" data-thumb-alt="" class="pr-4 woocommerce-product-gallery__image">',
			'<a href="' . $sectionRow['url'] . '">',
			'<img width="100" height="100" src="' . $sectionRow['url'] . '" class="" alt="" loading="lazy" title="' . $sectionRow['description'] . '" data-caption="" data-src="' . $sectionRow['url'] . '" data-large_image="' . $sectionRow['url'] . '" data-large_image_width="212" data-large_image_height="173" srcset="' . $sectionRow['url'] . ' 100w" sizes="(max-width: 100px) 100vw, 100px" />',
			'</a>',
			'</div>'
		]);
	}
}