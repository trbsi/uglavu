<?php

$listing_source = blocksy_get_posts_listing_source();

blocksy_output_font_css([
	'font_value' => blocksy_akg_or_customizer(
		'cardTitleFont',
		$listing_source,
		blocksy_typography_default_values([
			'size' => [
				'desktop' => '20px',
				'tablet'  => '20px',
				'mobile'  => '18px'
			],
			'variation' => 'n7',
			'line-height' => '1.3'
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.entry-card .entry-title'
]);

blocksy_output_colors([
	'value' => blocksy_akg_or_customizer('cardTitleColor', $listing_source),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-title',
			'variable' => 'linkInitialColor'
		],
		'hover' => [
			'selector' => '.entry-title',
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'cardExcerptSize',
	'value' => blocksy_akg_or_customizer('cardExcerptSize', $listing_source, [
		'mobile' => 16,
		'tablet' => 16,
		'desktop' => 16,
	])
]);

blocksy_output_colors([
	'value' => blocksy_akg_or_customizer('cardExcerptColor', $listing_source),
	'default' => [
		'default' => ['color' => 'var(--fontColor)']
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-excerpt',
			'variable' => 'cardExcerptColor'
		]
	],
]);

blocksy_output_font_css([
	'font_value' => blocksy_akg_or_customizer(
		'cardMetaFont',
		$listing_source,
		blocksy_typography_default_values([
			'size' => [
				'desktop' => '12px',
				'tablet'  => '12px',
				'mobile'  => '12px'
			],
			'variation' => 'n6',
			'line-height' => '1.3',
			'text-transform' => 'uppercase',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.entry-card .entry-meta'
]);

blocksy_output_colors([
	'value' => blocksy_akg_or_customizer('cardMetaColor', $listing_source),
	'default' => [
		'default' => [ 'color' => 'var(--fontColor)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-meta',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.entry-meta',
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => blocksy_akg_or_customizer('cardButtonTextColor', $listing_source),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-button',
			'variable' => 'buttonTextInitialColor'
		],

		'hover' => [
			'selector' => '.entry-button',
			'variable' => 'buttonTextHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => blocksy_akg_or_customizer('cardButtonColor', $listing_source),
	'default' => [
		'default' => [ 'color' => 'var(--buttonInitialColor)' ],
		'hover' => [ 'color' => 'var(--buttonHoverColor)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-button',
			'variable' => 'buttonInitialColor'
		],

		'hover' => [
			'selector' => '.entry-button',
			'variable' => 'buttonHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => blocksy_akg_or_customizer('cardBackground', $listing_source),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'variable' => 'cardBackground'
		],
	],
]);

blocksy_output_border([
	'css' => $css,
	'selector' => '[data-cards="boxed"] .entry-card',
	'variableName' => 'border',
	'value' => blocksy_akg_or_customizer('cardBorder', $listing_source, [
		'width' => 1,
		'style' => 'none',
		'color' => [
			'color' => 'rgba(44,62,80,0.2)',
		],
	])
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'cardsGap',
	'value' => blocksy_akg_or_customizer('cardsGap', $listing_source, [
		'mobile' => 30,
		'tablet' => 30,
		'desktop' => 30,
	])
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'cardSpacing',
	'value' => blocksy_akg_or_customizer('card_spacing', $listing_source, [
		'mobile' => 25,
		'tablet' => 35,
		'desktop' => 35,
	])
]);

// Box shadow
blocksy_output_box_shadow([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '[data-cards="boxed"] .entry-card',
	'value' => blocksy_akg('cardShadow', $listing_source, blocksy_box_shadow_value([
		'enable' => true,
		'h_offset' => 0,
		'v_offset' => 12,
		'blur' => 18,
		'spread' => -6,
		'inset' => false,
		'color' => [
			'color' => 'rgba(34, 56, 101, 0.04)',
		],
	])),
	'responsive' => true
]);


// TODO: extract here based on current screen when we multiply archive_order
// options
$archive_order = blocksy_akg_or_customizer(
	'archive_order',
	$listing_source,
	[
		[
			'id' => 'post_meta',
			'enabled' => true,
			'meta' => [
				'categories' => true,
				'author' => false,
				'date' => false,
				'comments' => false,
			],
		],

		[
			'id' => 'title',
			'enabled' => true,
		],

		[
			'id' => 'featured_image',
			'enabled' => true,
		],

		[
			'id' => 'excerpt',
			'enabled' => true,
		],

		[
			'id' => 'post_meta',
			'enabled' => true,
			'meta' => [
				'categories' => false,
				'author' => true,
				'date' => true,
				'comments' => true,
			],
		],
	]
);

if ($archive_order) {
	foreach ( $archive_order as $single_component ) {
		if ( $single_component['id'] === 'post_meta' ) {
			if (
				blocksy_akg('meta/author', $single_component, 'no')
				&&
				(blocksy_akg('has_author_avatar', $single_component, 'no') === 'yes')
			) {
				$css->put(
					':root',
					'--avatarSize: ' . blocksy_akg('avatar_size', $single_component, 30) . 'px'
				);
			}
		}
	}
}

