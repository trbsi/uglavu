<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blocksy
 */

if ( post_password_required() ) {
	return;
}

$entity_singular = 'comment';
$entity_plural = 'comments';

$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );

$form_options = [
	'format' => 'xhtml',
	'class_form'        => 'ct-respond-form ',
	'title_reply'       => __( 'Leave a Reply', 'blocksy' ),
	'cancel_reply_link' => __( 'Cancel Reply', 'blocksy' ),

	// Title reply
	'title_reply_before' => '<div id="reply-title" class="comment-reply-title">',
	'title_reply_after'  => '</div>',

	// Cancel reply
	'cancel_reply_before' => '<span class="ct-cancel-reply">',
	'cancel_reply_after'  => '</span>',

	// Logged in as
	'logged_in_as' => '',

	// Comment notes
	'comment_notes_before' => '',

	// Input fields
	'fields' => [
		// Author input
		'author' =>
		'<div class="ct-respond-form-inputs">
		<div class="comment-form-author">
		<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
		<label for="author">' . __( 'Name', 'blocksy' ) . ' <b class="required">*</b></label>
		</div>',

		// Email input
		'email' =>
			'<div class="comment-form-email">
			<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
			<label for="email">' . __( 'Email', 'blocksy' ) . ' <b class="required">*</b></label>
			</div>',

		'url' =>
			'<div class="comment-form-url">
			<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
			<label for="url">' . __( 'Website', 'blocksy' ) . '</label>
			</div></div>',
	],

	// Textarea
	'comment_field' =>
		'<div class="ct-respond-form-textarea">
		<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea>
		<label for="comment">' . __( 'Add Comment', 'blocksy' ) . '</label>
		</div>' . (function_exists('blocksy_ext_cookies_checkbox') ? blocksy_ext_cookies_checkbox() : ''),

	// submit button
	'submit_button' => '<button type="submit" name="%1$s" id="%2$s" class="%3$s" value="%4$s">%4$s</button>',

];


?>


<div class="ct-comments" id="ct-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="ct-comments-title">
			<?php comments_number( esc_html__( 'No comments yet', 'blocksy' ), __( 'One comment', 'blocksy' ), __( '% Comments', 'blocksy' ) ); ?>
		</h2>

		<ol class="ct-comment-list">
			<?php
				wp_list_comments(
					[
						'short_ping'  => true,
						'avatar_size' => 50,
						'callback' => 'blocksy_custom_comment_template',
					]
				);
			?>
		</ol>

		<?php
			// Are there comments to navigate through?
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			?>
			<nav class="ct-comment-navigation-container" role="navigation">
				<h4 class="screen-reader-text section-heading">
				<?php esc_html_e( 'Comment navigation', 'blocksy' ); ?>
				</h4>

				<div class="ct-comments-navigation">
					<span class="prev">
					<?php previous_comments_link( __( '&larr; Older Comments', 'blocksy' ) ); ?>
					</span>

					<span class="next">
					<?php next_comments_link( __( 'Newer Comments &rarr;', 'blocksy' ) ); ?>
					</span>
				</div>
			</nav>
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments">
				<?php esc_html_e( 'Comments are closed.', 'blocksy' ); ?>
			</p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form( $form_options ); ?>

</div>
