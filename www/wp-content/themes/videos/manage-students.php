<?php if (is_user_logged_in()): ?>

<h3>Manage Existing Student Accounts</h3>


<h3>Create New Student Account</h3>
<?php customloginpages_show_errors($errors); ?>

	<form class="loginform" name="registerform" id="registerform" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>&redirect_to=blahblahblah" method="post">
		<p>
			<label><?php _e('Username') ?>:</label>
			<input tabindex="1" type="text" name="user_login" id="user_login" class="input" value="<?php echo attribute_escape(stripslashes($user_login)); ?>" size="20" tabindex="10" />
		</p>
		<p>
			<label><?php _e('E-mail') ?>:</label>
			<input tabindex="2" type="text" name="user_email" id="user_email" class="input" value="<?php echo attribute_escape(stripslashes($user_email)); ?>" size="25" tabindex="20" />
		</p>
		<?php do_action('register_form'); ?>
		<p id="reg_passmail"><?php _e('A password will be e-mailed to the student.') ?></p>
		<p class="submit"><input tabindex="4" type="submit" name="wp-submit" id="wp-submit" value="<?php _e('Register'); ?>" tabindex="100" /></p>
	</form>
<?php endif; ?>
