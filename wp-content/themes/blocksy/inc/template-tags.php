<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Blocksy
 */

/**
 * Single entry title.
 *
 * @param string $tag HTML tag.
 */
function blocksy_entry_title( $tag = 'h2' ) {
	ob_start();

	?>

	<<?php echo esc_attr( $tag ); ?> class="entry-title">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php the_title(); ?>
		</a>
	</<?php echo esc_attr( $tag ); ?>>

	<?php

	return ob_get_clean();
}

/**
 * Output entry excerpt.
 *
 * @param number $length Number of words allowed in excerpt.
 */
function blocksy_entry_excerpt($length = 40, $class = 'entry-excerpt', $post_id = null) {
	if ( empty( trim( get_the_excerpt($post_id) ) ) ) {
		return '';
	}

	$excerpt = null;

	if ( 'original' === $length ) {
		$excerpt = get_the_excerpt($post_id);
	}

	if ( ! $excerpt ) {
		ob_start();
		blocksy_trim_excerpt( get_the_excerpt($post_id), $length );
		$excerpt = ob_get_clean();
	}

	ob_start();

	?>

	<div class="<?php echo esc_attr($class) ?>">
		<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo wp_kses_post($excerpt);
		?>
	</div>

	<?php

	return ob_get_clean();
}

/**
 * Output post navigation.
 */
function blocksy_post_navigation( $check_for_preview = false ) {
	if ( ! get_previous_post_link() && ! get_next_post_link() ) {
		return '';
	}

	$container_class = 'post-navigation';

	$container_class .= ' ' . blocksy_visibility_classes(get_theme_mod('post_nav_visibility', [
		'desktop' => true,
		'tablet' => true,
		'mobile' => true,
	]));

	$next_post = get_adjacent_post( false, '', false );
	$previous_post = get_adjacent_post( false, '', true );

	$home_page_url = get_home_url();

	$post_slug = get_post_type() === 'post' ? __( 'Post', 'blocksy' ) : get_post_type_object( get_post_type() )->labels->singular_name;
	$post_slug = '<span>&nbsp;' . $post_slug . '</span>';

	$has_thumb = get_theme_mod(
		'has_post_nav_thumb',
		'yes'
	) === 'yes' || $check_for_preview;

	$has_title = get_theme_mod(
		'has_post_nav_title',
		'yes'
	) === 'yes' || $check_for_preview;

	if ( $next_post ) {
		$next_title = '';

		if ( $has_title ) {
			$next_title = $next_post->post_title;
		}

		$next_post_image_output = '';

		if ( $has_thumb ) {
			$next_post_image_output = blocksy_image(
				[
					'attachment_id' => get_post_thumbnail_id( $next_post ),
					'ratio' => '1/1',
				]
			);
		}
	}

	if ( $previous_post ) {
		$previous_title = '';
		if ( $has_title ) {
			$previous_title = $previous_post->post_title;
		}

		if ( $has_thumb ) {
			$previous_post_image_output = blocksy_image(
				[
					'attachment_id' => get_post_thumbnail_id( $previous_post ),
					'ratio' => '1/1',
				]
			);
		}
	}

	ob_start();

	?>

		<nav class="<?php echo esc_attr( $container_class ); ?>">
			<?php if ( get_next_post_link() ) { ?>
				<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="nav-item-prev">
					<?php if ( $has_thumb ) { ?>
						<figure>
							<span><svg width="20px" height="15px" viewBox="0 0 20 15"><polygon points="0,7.5 5.5,13 6.4,12.1 2.4,8.1 20,8.1 20,6.9 2.4,6.9 6.4,2.9 5.5,2 "/></svg></span>
							<?php
								// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								echo wp_kses_post($next_post_image_output);
							?>
						</figure>
					<?php } ?>

					<div class="item-content">
						<span>
							<?php
								echo wp_kses_post(sprintf(
									// translators: post title
									__( 'Previous %s', 'blocksy' ),
									$post_slug
								));
							?>
						</span>

						<?php if ( ! empty( $next_title ) ) { ?>
							<h4 class="item-title">
								<?php
									echo wp_kses_post($next_title);
								?>
							</h4>
						<?php } ?>
					</div>

				</a>
			<?php } else { ?>
				<div class="nav-item-prev"></div>
			<?php } ?>

			<?php if ( get_previous_post_link() ) { ?>
				<a href="<?php echo esc_url( get_permalink( $previous_post ) ); ?>" class="nav-item-next">
					<?php if ( $has_thumb ) { ?>
						<figure>
							<span><svg width="20px" height="15px" viewBox="0 0 20 15"><polygon points="14.5,2 13.6,2.9 17.6,6.9 0,6.9 0,8.1 17.6,8.1 13.6,12.1 14.5,13 20,7.5 "/></svg></span>
							<?php
								echo wp_kses_post($previous_post_image_output);
							?>
						</figure>
					<?php } ?>

					<div class="item-content">
						<span>
							<?php
								echo wp_kses_post(sprintf(
									// translators: post title
									__( 'Next %s', 'blocksy' ),
									$post_slug
								));
							?>
						</span>

						<?php if ( ! empty( $previous_title ) ) { ?>
							<h4 class="item-title">
								<?php
									echo wp_kses_post($previous_title);
								?>
							</h4>
						<?php } ?>
					</div>
				</a>
			<?php } else { ?>
				<div class="nav-item-next"></div>
			<?php } ?>

		</nav>

	<?php

	return ob_get_clean();
}

/**
 * Output related posts for a single post.
 *
 * @param number $per_page Number of posts to output.
 */
function blocksy_related_posts( $per_page = 4 ) {
	global $post;

	$post_type = get_post_type( $post );

	$terms = [
		'post' => [
			'categories' => 'category',
			'tags' => 'post_tag',
		],
		'fw-portfolio' => [
			'categories' => 'fw-portfolio-category',
			'tags' => 'fw-portfolio-category',
		],
		'product' => [
			'categories' => 'product_cat',
			'tags' => 'product_tag',
		],
	];

	// categories | tags
	$criteria = get_theme_mod('related_criteria', 'categories');
	$taxonomy = blocksy_akg( $post_type . '/' . $criteria, $terms );

	$all_taxonomy_ids = [];

	$all_taxonomies = get_the_terms( $post->ID, $taxonomy );

	if ( ! $all_taxonomies ) {
		return '';
	}

	foreach ( $all_taxonomies as $current_taxonomy ) {
		$all_taxonomy_ids[] = $current_taxonomy->term_id;
	}

	$query = new WP_Query(
		[
			'ignore_sticky_posts' => 0,
			'posts_per_page' => $per_page,
			'post__not_in' => [ $post->ID ],
			'post_type' => $post_type,
			'tax_query' => [
				[
					'field' => 'id',
					'taxonomy' => $taxonomy,
					'terms' => $all_taxonomy_ids,
				],
			],
		]
	);

	$label = get_theme_mod('related_label', __( 'Related Posts', 'blocksy' ));

	$columns = get_theme_mod( 'related_posts_columns', 3 );

	$class = 'ct-related-posts';

	$class .= ' ' . blocksy_visibility_classes(get_theme_mod('related_visibility', [
		'desktop' => true,
		'tablet' => false,
		'mobile' => false,
	]));

	if ( $query->have_posts() ) {
		?>
		<div class="<?php echo esc_attr($class) ?>">
			<div class="ct-container">
				<h4 class="ct-related-posts-label">
					<?php echo wp_kses_post($label); ?>
				</h4>

				<ul data-columns="<?php echo esc_attr( $columns ); ?>">
					<?php while ( $query->have_posts() ) { ?>
						<?php $query->the_post(); ?>

						<li>
							<?php
								echo wp_kses_post(blocksy_image(
									[
										'attachment_id' => get_post_thumbnail_id(),
										'ratio' => '4/3',
										'tag_name' => 'a',
										'size' => 'large',
										'html_atts' => [
											'href' => esc_url( get_permalink() ),
										],
									]
								));
							?>

							<h3 class="related-entry-title">
								<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
							</h3>

							<div class="related-entry-meta">
								<span>
									<?php echo esc_html( get_the_time( 'M j, Y' ) ); ?>
								</span>

								<?php if ( get_comments_number() > 0 ) { ?>
									<span>
										<?php echo wp_kses_post( get_comments_number_text( '', '1 Comment', '% Comments' ) ); ?>
									</span>
								<?php } ?>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>

		<?php
	}

	wp_reset_postdata();
}
