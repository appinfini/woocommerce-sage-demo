<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Get tags.
$tags = $product->tag_ids;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'max-w-sm bg-white rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700', $product ); ?>>
	<a href="{{ get_the_permalink() }}">
		{!! get_the_post_thumbnail($product->ID, 'medium', ["class"=>"w-full", "alt"=>"Sunset in the mountains"]) !!}
	</a>
	<div class="px-6 py-4">
		<a href="#">
			<h5 class="font-bold text-xl mb-2">{{ get_the_title() }}</h5>
		</a>
		<p class="text-gray-700 text-base py-2 mb-4">
			{!! strip_tags(get_the_excerpt()) !!}
		</p>
		<div class="flex justify-between items-center">
			<span class="text-4xl font-bold text-gray-900 dark:text-white">{!! $product->get_price_html() !!}</span>
			{!! do_action( 'woocommerce_after_shop_loop_item' ); !!}
		</div>
		<div class="pt-4 pb-2">
			@foreach ($tags as $tag)
				<span
					class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ get_term($tag)->name }}
				</span>
			@endforeach
		</div>
	</div>
</li>
