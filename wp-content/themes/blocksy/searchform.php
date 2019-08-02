<?php

/**
 * Search form
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

$any = [];

foreach (get_theme_mod('search_through', [
	'post' => true,
	'page' => false,
	'product' => false,
]) as $single_post_type => $enabled) {
	if (! $enabled) continue;
	$any[] = $single_post_type;
}

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="ct-search-input">
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'blocksy' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />

		<button class="search-submit">
			<i>
				<svg
					width="12px"
					height="12px"
					viewBox="0 0 24 24">

					<path d="M23.3,23.3c-0.9,0.9-2.3,0.9-3.2,0l-4-4c-1.6,1-3.6,1.7-5.7,1.7C4.7,21,0,16.3,0,10.5S4.7,0,10.5,0C16.3,0,21,4.7,21,10.5
					c0,2.1-0.6,4-1.7,5.7l4,4C24.2,21,24.2,22.5,23.3,23.3z M10.5,3C6.4,3,3,6.4,3,10.5S6.4,18,10.5,18c4.1,0,7.5-3.4,7.5-7.5
					C18,6.4,14.7,3,10.5,3z"/>
				</svg>
			</i>

			<span data-loader="circles"><span></span><span></span><span></span></span>
		</button>

		<?php if (count($any) === 1 && $any[0] === 'product') { ?>
			<input type="hidden" name="post_type" value="product">
		<?php } ?>
	</div>
</form>


