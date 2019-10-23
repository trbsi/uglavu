<?php
/**
 * Images generators
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

function blocksy_has_lazyload() {
	if (class_exists('WP_Smush_Lazy_Load')) {
		if (WP_Smush_Settings::get_instance()->get('lazy_load')) {
			return false;
		}
	}

	if (class_exists('Jetpack') && Jetpack::is_module_active('lazy-images')) {
		return false;
	}

	return get_theme_mod('has_lazy_load', 'yes') === 'yes';
}

/**
 * Output image container for an attachment.
 *
 * @param array $args various params that the function accepts.
 */
function blocksy_image( $args = [] ) {
	$post = get_post(); //CUSTOM

	$args = wp_parse_args(
		$args,
		[
			'attachment_id' => null,
			'ratio' => '1/1',
			'class' => '',
			'ratio_blocks' => true,
			'tag_name' => 'div',
			'html_atts' => [],
			'inner_content' => '',
			'lazyload' => blocksy_has_lazyload(),
			'lazyload_type' => get_theme_mod('lazy_load_type', 'fade'),
			'size' => 'medium',
		]
	);

	//CUSTOM START
	if (!empty($post->og_url)) {
		$args['html_atts']['href'] = $post->og_url;
		$args['html_atts']['target'] = '_blank';
	}
	//CUSTOM END

	$classes = $args['class'];

	$attachment_exists = wp_attachment_is_image( $args['attachment_id'] );

	$other_html_atts = '';

	$args['html_atts']['class'] = 'ct-image-container' . (
		empty( $classes ) ? '' : ' ' . $classes
	);

	if ( $args['lazyload'] && $attachment_exists ) {
		$args['html_atts']['class'] .= ' ct-lazy';

		if ($args['lazyload_type'] === 'none') {
			$args['html_atts']['class'] .= ' ct-lazy-static';
		}

		if ($args['lazyload_type'] === 'default') {
			$args['inner_content'] .= '<span data-loader="circles"><span></span><span></span><span></span></span>';
		}
	}

	if ( ! $attachment_exists ) {
		$args['html_atts']['class'] .= ' ct-no-image';
	}

	if ( $args['ratio_blocks'] ) {
		$args['inner_content'] .= blocksy_generate_ratio($args['ratio']);
	}

	if ( isset( $args['html_atts']['class'] ) ) {
		$other_html_atts .= 'class="' . $args['html_atts']['class'] . '" ';
		unset( $args['html_atts']['class'] );
	}

	foreach ( $args['html_atts'] as $attr => $value ) {
		$other_html_atts .= $attr . '="' . $value . '" ';
	}

	$other_html_atts = trim( $other_html_atts );
	$other_html_atts .= ' ' . blocksy_schema_org_definitions('image');

	//CUSTOM START
	if (!empty($post->og_url)) {
		$image = sprintf('<img width="640" height="640" 
			class="attachment-medium_large size-medium_large" 
			alt="" sizes="(max-width: 640px) 100vw, 640px" 
			data-lazy="%1$s" data-lazy-set="%1$s 768w, %1$s 150w, %1$s 300w, %1$s 1024w" 
			data-object-fit="~">', $post->og_image);
	} else {
		$image = blocksy_get_image_element( $args );
	}
	//CUSTOM END

	//CUSTOM + EDIT START
	return '<' . $args['tag_name'] . ' ' . $other_html_atts . '>' .
		$image .
		$args['inner_content'] .
	'</' . $args['tag_name'] . '>';
	//CUSTOM + EDIT END
}


/**
 * Output image element for all the cases.
 *
 * @param array $args various params that the function accepts.
 */
function blocksy_get_image_element( $args ) {
	if ( ! wp_attachment_is_image( $args['attachment_id'] ) ) {
		return ''; }

	$parser = new Blocksy_Attributes_Parser();

	$image = wp_get_attachment_image(
		$args['attachment_id'],
		$args['size']
	);

	$has_srcset = strpos( $image, 'srcset' ) !== false;

	$output = '';

	if ( $args['lazyload'] ) {
		$output = '<noscript>' . $image . '</noscript>';

		$image = $parser->rename_attribute_from_images(
			$image,
			'src',
			'data-lazy'
		);


		if ( $has_srcset ) {
			$image = $parser->rename_attribute_from_images(
				$image,
				'srcset',
				'data-lazy-set'
			);
		}
	}

	$output = $parser->add_attribute_to_images(
		$image, 'data-object-fit', '~'
	) . $output;

	return $output;
}

/**
 * Generate ratio div based on ratio.
 *
 * @param string $ratio 1/1 | 1/2 | 4/3 | 3/4 ...
 */
function blocksy_generate_ratio( $ratio ) {
	$result = 0;

	if ( 'original' === $ratio ) {
		$result = 1;
	} else {
		$computed_ratio = explode( '/', $ratio );
		$result = (int) ( $computed_ratio[1] ) / (int) ( $computed_ratio[0] );
	}

	$style = 'padding-bottom: ' . round( $result * 100, 1 ) . '%';
	return '<div class="ct-ratio" style="' . $style . '"></div>';
}

/**
 * Generate an image container based on image URL.
 *
 * @param string $image_src URL to the image.
 * @param array $args various params that the function accepts.
 */
function blocksy_simple_image( $image_src, $args = [] ) {
	$args = wp_parse_args(
		$args,
		[
			'ratio' => '1/1',
			'class' => '',
			'ratio_blocks' => true,
			'tag_name' => 'div',
			'html_atts' => [],
			'img_atts' => [],
			'inner_content' => '',
			'lazyload' => blocksy_has_lazyload(),
			'lazyload_type' => get_theme_mod('lazy_load_type', 'fade'),
			'size' => 'medium',
		]
	);

	$original = 'ct-image-container';
	$image_attr = 'src';

	$other_img_atts = '';

    if (! isset($args['img_atts']['alt'])) {
      $args['img_atts']['alt'] = __('Default image', 'blocksy');
    }

	foreach ( $args['img_atts'] as $attr => $value ) {
		$other_img_atts .= $attr . '="' . $value . '" ';
	}

	if ( $args['lazyload'] ) {
		$original .= ' ct-lazy';

		if ($args['lazyload_type'] === 'none') {
			$original .= ' ct-lazy-static';
		}

		$args['inner_content'] .= '<noscript>';
		$args['inner_content'] .= '<img ' . $image_attr . '="' . $image_src . '" data-object-fit="~" ' . $other_img_atts . '>';
		$args['inner_content'] .= '</noscript>';

		$image_attr = 'data-lazy';

		if ($args['lazyload_type'] === 'default') {
			$args['inner_content'] .= '<span data-loader="circles"><span></span><span></span><span></span></span>';
		}
	}

	if (! isset($args['html_atts']['class'])) {
		$args['html_atts']['class'] = $original;
	} else {
		$args['html_atts']['class'] = $original . ' ' . $args['html_atts']['class'];
	}

	$other_html_atts = '';

	foreach ( $args['html_atts'] as $attr => $value ) {
		$other_html_atts .= $attr . '="' . $value . '" ';
	}

	$other_html_atts = trim( $other_html_atts );

	if ( $args['ratio_blocks'] ) {
		$args['inner_content'] .= blocksy_generate_ratio($args['ratio']);
	}

	return '<' . $args['tag_name'] . ' ' . $other_html_atts . '>' .
		'<img ' . $image_attr . '="' . $image_src . '" data-object-fit="~" ' . $other_img_atts . '>' .
		$args['inner_content'] .
	'</' . $args['tag_name'] . '>';
}
