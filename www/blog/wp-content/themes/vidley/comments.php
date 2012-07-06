<?php

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
<div id="comments">
	<div id="comments-meta">
		<p><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</p>
	</div>

	<ol class="commentlist">
		<?php wp_list_comments('avatar_size=48'); ?>
	</ol>
</div>

<div id="leave-reply">
	<p>Use the Form Below to Leave a Reply</p>
</div>

<?php else :?>
<?php if ( comments_open() ) : ?>

<!-- If comments are open, but there are no comments. -->

<div id="comments">
	<div id="comments-meta">
		<p><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</p>
	</div>
</div>

<?php else :?>

<!-- If comments are closed. -->

<?php endif; ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>

<div id="respond">
	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<?php if ( is_user_logged_in() ) : ?>
		<div class="comment-details">
			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out</a></p>
		</div>
	<?php else : ?>
		<div class="comment-details">
			<p>
				Your Name: (Required)<br>
				<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
			</p>
			
			<p>
				Email Address: (Required)<br>
				<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
			</p>
			
			<p>
				Website:<br>
				<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" tabindex="3" />
			</p>
		</div>
	<?php endif; ?>
	
		<div class="comment-text">
			<p>
				Your Comments:<br>
				<textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea>
			</p>
		
			<p>
				<input name="submit" type="submit" id="submit" tabindex="5" value="Submit" /><?php comment_id_fields(); ?>
			
				<div class="cancel-comment-reply">
					<?php cancel_comment_reply_link('Cancel'); ?>
				</div>
			</p>
		</div>
		
		<?php do_action('comment_form', $post->ID); ?>
	</form>
	<?php endif; ?>
</div> <!-- respond -->

<?php endif; ?>