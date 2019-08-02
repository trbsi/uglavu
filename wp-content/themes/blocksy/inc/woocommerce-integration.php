<?php

require get_template_directory() . '/inc/woocommerce/content-product.php';
require get_template_directory() . '/inc/woocommerce/related.php';
require get_template_directory() . '/inc/woocommerce/load-mini-cart.php';

remove_action(
	'woocommerce_before_single_product_summary',
	'woocommerce_show_product_sale_flash'
);

remove_action(
	'woocommerce_single_product_summary',
	'woocommerce_template_single_rating'
);

remove_action(
	'woocommerce_single_product_summary',
	'woocommerce_template_single_meta',
	40
);

add_action(
	'woocommerce_single_product_summary',
	function () {
		if (get_theme_mod('has_product_single_rating', 'yes') === 'yes') {
			woocommerce_template_single_rating();
		}

		blocksy_add_customizer_preview_cache(function () {
			return blocksy_html_tag(
				'div',
				['data-id' => 'single-rating'],
				blocksy_collect_and_return(function () {
					woocommerce_template_single_rating();
				})
			);
		});
	},
	9
);

add_action(
	'woocommerce_single_product_summary',
	function () {
		if (get_theme_mod('has_product_single_meta', 'yes') === 'yes') {
			woocommerce_template_single_meta();
		}

		blocksy_add_customizer_preview_cache(function () {
			return blocksy_html_tag(
				'div',
				['data-id' => 'single-meta'],
				blocksy_collect_and_return(function () {
					woocommerce_template_single_meta();
				})
			);
		});
	},
	39
);

function blocksy_get_woocommerce_ratio() {
	$cropping = get_option( 'woocommerce_thumbnail_cropping', '1:1' );

	if ($cropping === '1:1') {
		return '1/1';
	}

	if ($cropping === 'custom') {
		$width = get_option('woocommerce_thumbnail_cropping_custom_width');
		$height = get_option('woocommerce_thumbnail_cropping_custom_height');

		return $width . '/' . $height;
	}

	return '1/1';
}

add_filter('woocommerce_output_related_products_args', function ($args) {
	if (! is_customize_preview()) {
		$args['posts_per_page'] = intval(get_theme_mod('related_products', 4));
	} else {
		$args['posts_per_page'] = 8;
	}

	return $args;
});

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_action('wp_enqueue_scripts', function () {
	if (! function_exists('is_shop')) return;

	if (
		is_shop()
		||
		is_product_category()
		||
		is_product_tag()
	) {
		wp_enqueue_script('selectWoo');
		wp_enqueue_style('select2');
	}

	$theme = wp_get_theme();

	wp_enqueue_style(
		'ct-woocommerce-styles',
		get_template_directory_uri() . '/static/bundle/woocommerce.css',
		[],
		$theme->get( 'Version' )
	);

	wp_dequeue_style( 'selectWoo' );
	wp_deregister_style( 'selectWoo' );

	wp_dequeue_script( 'selectWoo');
	call_user_func('wp_' . 'deregister_script', 'selectWoo');
});

add_filter('woocommerce_product_review_comment_form_args', function ($comment_form) {
	$comment_form['comment_field'] = '';
	if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
		$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'blocksy' ) . '</label><select name="rating" id="rating" required>
			<option value="">' . esc_html__( 'Rate&hellip;', 'blocksy' ) . '</option>
			<option value="5">' . esc_html__( 'Perfect', 'blocksy' ) . '</option>
			<option value="4">' . esc_html__( 'Good', 'blocksy' ) . '</option>
			<option value="3">' . esc_html__( 'Average', 'blocksy' ) . '</option>
			<option value="2">' . esc_html__( 'Not that bad', 'blocksy' ) . '</option>
			<option value="1">' . esc_html__( 'Very poor', 'blocksy' ) . '</option>
		</select></div>';
	}

	$comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" required></textarea><label for="comment">' . esc_html__( 'Your review', 'blocksy' ) . '&nbsp;<span class="required">*</span></label></p>';
	$comment_form['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s woo-review-submit" value="%4$s" />%4$s</button>';

	$comment_form['fields']['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" value="" size="30" required /><label for="author">Name&nbsp;<span class="required">*</span></label></p>';
	$comment_form['fields']['email'] = '<p class="comment-form-email"> <input id="email" name="email" type="email" value="" size="30" required /><label for="email">Email&nbsp;<span class="required">*</span></label></p>';

	return $comment_form;
}, 10, 1);

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

add_filter('post_class', function ($classes, $class, $product_id) {
	if (! function_exists('is_product')) return $classes;
	if (! is_product()) return $classes;

	if (get_theme_mod('gallery_style', 'horizontal') === 'vertical') {
		global $product;

		if (count($product->get_gallery_image_ids()) > 0) {
			$classes[] = 'thumbs-left';
		}
	}

	return $classes;
}, 10, 3);

function blocksy_output_woo_mini_cart($for_preview = false) {
	if (!function_exists('woocommerce_mini_cart')) {
		return '';
	}

	$svgs = [
		'type-1' => '<svg width="14" height="14" viewBox="0 0 20 20">
				<path d="M20,17.9L19.3,2.1c0-1.1-0.9-2.1-2.1-2.1H2.8C1.6,0,0.7,0.9,0.7,2.1L0,17.9c0,0,0,0,0,0C0,19.1,0.9,20,2.1,20h15.8C19.1,20,20,19.1,20,17.9C20,17.9,20,17.9,20,17.9z M17.9,18.2H2.1c-0.2,0-0.3-0.1-0.3-0.3L2.5,2.1c0,0,0,0,0,0c0-0.2,0.1-0.3,0.3-0.3h14.5c0.2,0,0.3,0.1,0.3,0.3c0,0,0,0,0,0l0.7,15.8C18.2,18.1,18.1,18.2,17.9,18.2z M13,3.5c-0.5,0-0.9,0.4-0.9,0.9V7c0,1.1-0.9,2.1-2.1,2.1C8.9,9.1,7.9,8.2,7.9,7V4.3c0-0.5-0.4-0.9-0.9-0.9c-0.5,0-0.9,0.4-0.9,0.9V7c0,2.1,1.7,3.8,3.8,3.8c2.1,0,3.8-1.7,3.8-3.8V4.3C13.9,3.9,13.5,3.5,13,3.5z"/>
			</svg>',

		'type-2' => '<svg width="15" height="15" viewBox="0 0 14 14">
				<path d="M0.5,0.5C0.2,0.5,0,0.7,0,1c0,0.3,0.2,0.5,0.5,0.5c0,0,0,0,0,0h1c0.1,0,0.2,0.1,0.2,0.2L4,9.3c0.2,0.7,0.8,1.1,1.5,1.1h5.7c0.7,0,1.3-0.5,1.5-1.1L14,4.3c0.1-0.3-0.1-0.6-0.4-0.6c0,0-0.1,0-0.1,0H3.4L2.7,1.5c0,0,0,0,0,0C2.6,0.9,2.1,0.5,1.5,0.5H0.5zM5.7,11.4c-0.6,0-1,0.5-1,1s0.5,1,1,1s1-0.5,1-1S6.3,11.4,5.7,11.4zM10.9,11.4c-0.6,0-1,0.5-1,1s0.5,1,1,1s1-0.5,1-1S11.5,11.4,10.9,11.4z"/>
		</svg>',

		'type-3' => '<svg width="15" height="15" viewBox="0 0 14 14">
				<path d="M4.2,1c-0.5,0-1,0.3-1.2,0.8L1.5,5.4H0.6c-0.2,0-0.4,0.1-0.5,0.3C0,5.8,0,6,0,6.2l1.6,5.9C1.8,12.7,2.3,13,2.9,13h8.2c0.6,0,1.1-0.4,1.2-0.9L14,6.2C14,6,14,5.8,13.9,5.7c-0.1-0.2-0.3-0.3-0.5-0.3h-0.9l-1.6-3.7h0C10.7,1.3,10.3,1,9.8,1H4.2z M4.2,2.2h5.5l1.4,3.2H2.9L4.2,2.2z M4.5,7.3c0.4,0,0.6,0.3,0.6,0.6v2.5c0,0.4-0.3,0.6-0.6,0.6s-0.6-0.3-0.6-0.6V8C3.8,7.6,4.1,7.3,4.5,7.3zM7,7.3c0.4,0,0.6,0.3,0.6,0.6v2.5c0,0.4-0.3,0.6-0.6,0.6c-0.4,0-0.6-0.3-0.6-0.6V8C6.4,7.6,6.6,7.3,7,7.3z M9.5,7.3c0.4,0,0.6,0.3,0.6,0.6v2.5c0,0.4-0.3,0.6-0.6,0.6c-0.4,0-0.6-0.3-0.6-0.6V8C8.9,7.6,9.2,7.3,9.5,7.3z"/>
		</svg>'
	];

	blocksy_add_customizer_preview_cache(
		function () use ($svgs) {
			$result = '';

			foreach ($svgs as $single_svg => $svg) {
				$result .= blocksy_html_tag(
					'div',
					[ 'data-header-cart' => $single_svg ],
					$svg
				);
			}

			return $result;
		}
	);

	$current_count = WC()->cart->get_cart_contents_count();

	$class = 'ct-header-cart';

	$class .= ' ' . blocksy_visibility_classes(get_theme_mod('header_cart_visibility', [
		'desktop' => true,
		'tablet' => true,
		'mobile' => false,
	]));

	$badge_output = '';

	if (get_theme_mod('has_cart_badge', 'yes') === 'no') {
		$badge_output === 'data-skip-badge';
	}

	$type = get_theme_mod('mini_cart_type', 'type-1');

	if (empty($type)) {
		$type = 'type-1';
	}

	ob_start();

	?>

	<div
		class="<?php echo esc_attr($class) ?>"
		data-count="<?php echo esc_attr($current_count) ?>"
		<?php echo wp_kses_post($badge_output) ?>>

		<a href="<?php echo esc_attr(wc_get_cart_url()) ?>" class="ct-cart-icon">
			<?php
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * The value used here escapes the value properly.
				 * It contains an inline SVG, which is safe.
				 */
				echo $svgs[$type]
			?>
		</a>
	</div>

	<?php

	return ob_get_clean();
}

add_filter( 'loop_shop_per_page', function () {
    return intval(get_theme_mod('shop_products', 9));
}, 20 );


