<?php
/**
 * Posts widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

$items = intval( blocksy_default_akg( 'posts_number', $atts, 5 ) );

$date_query = [];

$days = blocksy_default_akg( 'days', $atts, 'all_time' );

if ( $days && 'all_time' !== $days ) {
	$time = time() - ( intval( $days ) * 24 * 60 * 60 );

	$date_query = array(
		'after'     => date( 'F jS, Y', $time ),
		'before'    => date( 'F jS, Y' ),
		'inclusive' => true,
	);
}

$fw_cat_id = blocksy_default_akg( 'category', $atts, 'all_categories' );
$fw_cat_id = ( empty( $category ) || 'all_categories' === $category ) ? '' : $category;

$type = blocksy_default_akg( 'type', $atts, 'recent' );

$query = new WP_Query(
	[
		'post_type' => 'post',
		'order' => 'DESC',
		'posts_per_page' => $items,
		'date_query' => $date_query,
		'cat' => $fw_cat_id,
		'orderby' => ( 'recent' === $type ) ? 'post_date' : 'comment_count',
	]
);

// Post thumbnail
$has_thumbnail = false;

$type_output = '';

$posts_type = blocksy_default_akg('posts_type', $atts, 'small-thumbs');

if ($posts_type !== 'no-thumbs') {
	$has_thumbnail = true;
	$type_output = 'data-type="' . esc_attr($posts_type) . '"';
}

$data_thumbnail = '';


if ( $has_thumbnail ) {
	$data_thumbnail = ' data-thumbnail="true"';
}

// Post meta
$has_meta = blocksy_default_akg( 'display_date', $atts, 'no' ) === 'yes';


// Comments
$has_comments = blocksy_default_akg( 'display_comments', $atts, 'no' ) === 'yes';

// Widget title
$title = blocksy_default_akg( 'title', $atts, __( 'Posts', 'blc' ) );

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $before_widget;

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $before_title . wp_kses_post( $title ) . $after_title;

?>

<?php if ( $query->have_posts() ) { ?>
	<ul <?php echo $type_output ?> <?php echo wp_kses( $data_thumbnail, [] ); ?>>
		<?php while ( $query->have_posts() ) { ?>
			<?php $query->the_post(); ?>

			<li>
				<?php
				if ( $has_thumbnail ) {
					$size = 'thumbnail';
					$ratio = '1/1';

					if (
						$posts_type === 'large-small'
						&&
						$query->current_post === 0
					) {
						$size = 'medium';
						$ratio = '4/3';
					}

					echo wp_kses_post(
						blocksy_image(
							[
								'attachment_id' => get_post_thumbnail_id(),
								'ratio' => $ratio,
								'tag_name' => 'a',
								'size' => $size,
								'html_atts' => [
									'href' => get_permalink(),
								],
							]
						)
					);
				}
				?>

				<div class="ct-entry-content">
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="ct-post-title">
						<?php echo wp_kses_post(get_the_title()); ?>
					</a>

					<?php if ( $has_meta || $has_comments ) { ?>
						<div class="ct-entry-meta">
							<?php if ( $has_meta ) { ?>
								<span>
									<?php echo esc_attr( get_the_time( 'M j, Y' ) ); ?>
								</span>
							<?php } ?>

							<?php if ( $has_comments && get_comments_number() > 0 ) { ?>
								<span>
									<?php echo wp_kses_post( get_comments_number_text( '', '1 Comment', '% Comments' ) ); ?>
								</span>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</li>
		<?php } ?>
	</ul>
<?php } ?>

<?php wp_reset_postdata(); ?>

<?php
	echo wp_kses_post( $after_widget );
?>
