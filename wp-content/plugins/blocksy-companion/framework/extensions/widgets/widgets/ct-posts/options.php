<?php
/**
 * Posts widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$categories = get_categories(
	[
		'type'    => 'post',
		'orderby' => 'name',
		'order'   => 'ASC',
	]
);

$category_choices = [
	'all_categories' => __( 'All categories', 'blc' ),
];

foreach ( $categories as $category ) {
	$category_choices[ $category->term_id ] = $category->name;
}

$options = [
	'title' => [
		'type' => 'text',
		'label' => __( 'Title', 'blc' ),
		'field_attr' => [ 'id' => 'widget-title' ],
		'design' => 'inline',
		'value' => __( 'Posts', 'blc' ),
	],

	'type' => [
		'type' => 'ct-select',
		'label' => __( 'Select Type', 'blc' ),
		'value' => 'recent',
		'design' => 'inline',
		'choices' => blocksy_ordered_keys(
			[
				'recent' => __( 'Recent Posts', 'blc' ),
				'popular' => __( 'Popular Posts', 'blc' ),
				'commented' => __( 'Most Commented Posts', 'blc' ),
			]
		),
	],

	'days' => [
		'type' => 'ct-select',
		'label' => __( 'Days', 'blc' ),
		'value' => 'all_time',
		'design' => 'inline',
		'choices' => blocksy_ordered_keys(
			[
				'all_time' => __( 'All Time', 'blc' ),
				'7' => __( '1 Week', 'blc' ),
				'30' => __( '1 Month', 'blc' ),
				'90' => __( '3 Months', 'blc' ),
				'180' => __( '6 Months', 'blc' ),
				'360' => __( '1 Year', 'blc' ),
			]
		),
	],

	'category' => [
		'type' => 'ct-select',
		'label' => __( 'Category', 'blc' ),
		'value' => 'all_categories',
		'choices' => blocksy_ordered_keys( $category_choices ),
		'design' => 'inline',
	],

	'posts_number' => [
		'type' => 'ct-number',
		'label' => __( 'Number of Posts', 'blc' ),
		'min' => 1,
		'max' => 30,
		'value' => 5,
		'design' => 'inline',
	],

	'display_date' => [
		'type'  => 'ct-switch',
		'label' => __( 'Show Date', 'blc' ),
		'value' => 'no',
	],

	'display_photo' => [
		'type'  => 'ct-switch',
		'label' => __( 'Show Thumbnail', 'blc' ),
		'value' => 'no',
	],

	'display_comments' => [
		'type'  => 'ct-switch',
		'label' => __( 'Show Comments', 'blc' ),
		'value' => 'no',
	],
];

