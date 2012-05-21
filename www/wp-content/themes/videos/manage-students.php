<?php if (is_user_logged_in() && wp_get_current_user()->roles[0] == 'corporate_subscriber'): ?>

<p style="color:#FF0000;">
<?php
if (isset($_POST['user_login'], $_POST['user_email'], $_POST['wp-submit'])) {
	do {
		$user_login = sanitize_user($_POST['user_login']);
		$user_email = apply_filters('user_registration_email', $_POST['user_email']);

		if (!validate_username($user_login)) {
			_e('That username is invalid');
		} elseif (username_exists($user_login)) {
			_e('That username is taken');
		} elseif (!is_email($user_email)) {
			_e('That email is not valid');
		} elseif (email_exists($user_email)) {
			_e('That email is already registered');
		} else {
			do_action('register_post', $user_login, $user_email);

			$random_password = wp_generate_password(8, false);
			$user_id = wp_insert_user(array(
				'user_login' => $user_login,
				'user_email' => $user_email,
				'user_pass' => $random_password,
				'role' => 'corporate_student',
			));
			if (!$user_id) {
				_e('User could not be created');
			} else {
				add_user_meta($user_id, 'corporate_subscriber_id', get_current_user_id());
				wp_new_user_notification($user_id, $random_password);
				_e('Student account created.  The user\'s password has been sent to them via email');
			}
		}
	} while (false);
}
?>
</p>

<p style="color: #FF0000;">
<?php

global $wpdb;

if (isset($_GET['delete_student'])) {
	$delete_id = intval($_GET['delete_student']);
	$rows = $wpdb->get_results("SELECT $wpdb->users.ID, $wpdb->users.user_email FROM $wpdb->users INNER JOIN $wpdb->usermeta ON $wpdb->users.ID = $wpdb->usermeta.user_id WHERE $wpdb->usermeta.meta_key = 'corporate_subscriber_id' AND $wpdb->usermeta.meta_value = " . get_current_user_id() . " AND $wpdb->users.ID = $delete_id");
	if (count($rows)) {
		$user = $rows[0];
		include(ABSPATH . 'wp-admin/includes/user.php');
		wp_delete_user($delete_id);
		_e('User ' . $user->user_email . ' deleted');
	}
}
?>
</p>

<h3>Manage Existing Student Accounts</h3>

<table style="width: 500px;">
	<thead>
		<tr>
			<td style="width: 40%;">Username</td>
			<td style="width: 40%;">Email</td>
			<td style="width: 20%;">Delete</td>
		</tr>
	</thead>
	<tbody>
<?php

$rows = $wpdb->get_results("SELECT $wpdb->users.ID, $wpdb->users.user_login, $wpdb->users.user_email FROM $wpdb->users INNER JOIN $wpdb->usermeta ON $wpdb->users.ID = $wpdb->usermeta.user_id WHERE $wpdb->usermeta.meta_key = 'corporate_subscriber_id' AND $wpdb->usermeta.meta_value = " . get_current_user_id());

$count = 0;
foreach ($rows as $user): $count++; ?>
		<tr>
			<td><?php _e($user->user_login); ?></td>
			<td><?php _e($user->user_email); ?></td>
			<td><a href="?delete_student=<?php _e($user->ID); ?>">Delete</a></td>
		</tr>
<?php endforeach;
if ($count == 0): ?>
		<tr>
			<td colspan="3">No student accounts created</td>
		</tr>
<?php endif; ?>
	</tbody>
</table>

<h3>Create New Student Account</h3>

	<form class="loginform" name="registerform" id="registerform" action="<?php echo site_url('/managestudents/') ?>" method="post">
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
<?php else: ?>
	<script>window.location = <?php echo json_encode(get_site_url(null, '/products-page/your-account')); ?>;</script>
<?php endif; ?>
