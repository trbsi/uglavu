<?php

$listing_source = blocksy_get_posts_listing_source();

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'cardTitleSize',
	'value' => blocksy_akg_or_customizer('cardTitleSize', $listing_source, [
		'mobile' => 18,
		'tablet' => 20,
		'desktop' => 20,
	])
]);

$cardTitleColor = blocksy_get_colors( blocksy_akg_or_customizer( 'cardTitleColor',
	$listing_source,
	[
		'default' => [ 'color' => 'var(--paletteColor4)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.entry-title',
	"--linkInitialColor: {$cardTitleColor['default']}"
);

$css->put(
	'.entry-title',
	"--linkHoverColor: {$cardTitleColor['hover']}"
);

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

$cardExcerptColor = blocksy_get_colors( blocksy_akg_or_customizer(
	'cardExcerptColor',
	$listing_source,
	[ 'default' => [ 'color' => 'rgba(44,62,80,0.9)' ] ]
));

$css->put(
	'.entry-excerpt',
	"--cardExcerptColor: {$cardExcerptColor['default']}"
);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.entry-card',
	'variableName' => 'metaFontSize',
	'value' => blocksy_akg_or_customizer('cardMetaSize', $listing_source, [
		'mobile' => 12,
		'tablet' => 12,
		'desktop' => 12,
	])
]);

$cardMetaColor = blocksy_get_colors( blocksy_akg_or_customizer(
	'cardMetaColor',
	$listing_source,
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.entry-meta',
	"--linkInitialColor: {$cardMetaColor['default']}"
);

$css->put(
	'.entry-meta',
	"--linkHoverColor: {$cardMetaColor['hover']}"
);

$card_background = blocksy_get_colors( blocksy_akg_or_customizer(
	'cardBackground',
	$listing_source,
	[ 'default' => [ 'color' => '#ffffff' ] ]
));

$css->put(
	':root',
	"--cardBackground: {$card_background['default']}"
);

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

