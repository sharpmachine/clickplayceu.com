<?php
/*
Plugin Name: Custom login pages
Plugin URI: http://onlinevortex.com/projects/custom-login-pages/
Description: Replaces login/logout/register pages
Version: 0.8
Author: Carlos Mendoza
Author URI: http://onlinevortex.com/

Copyright 2009 Carlos Mendoza (cmendoza@onlinevortex.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function customloginpages_login_init() {
	require( ABSPATH . '/wp-load.php' );

	if (isset($_REQUEST["action"])) {
		$action = $_REQUEST["action"];
	} else {
		$action = 'login';
	}
	switch($action) {
		case 'lostpassword' :
		case 'retrievepassword' :
			customloginpages_password();
			break;
		case 'register':
			customloginpages_show_registerform();
			break;
		case 'login':
		default:
			customloginpages_show_loginform();
			break;
	}
	die();
}

function customloginpages_login_css ( ) {
?>
	<style type="text/css">
	form.loginform p label {
		width: 150px;
		display: block;
		float: left;
		clear: both;
	}
	form.loginform p input.input {
		width: 150px;
		float: left;
		clear: right;
	}
	form.loginform p img {
		width: 155px;
		float: left;
	}
	form.loginform, form.loginform p {
		clear: both;
	}
	p.message, p#login_error {
		padding: 3px 5px;
	}
	p.message {
		background-color: lightyellow;
		border: 1px solid yellow;
	}
	p#login_error {
		background-color: lightcoral;
		border: 1px solid red;
		color: #000;
	}
	</style>
<?php
}

function customloginpages_show_errors($wp_error) {
	global $error;

	if ( !empty( $error ) ) {
		$wp_error->add('error', $error);
		unset($error);
	}

	if ( !empty($wp_error) ) {
		if ( $wp_error->get_error_code() ) {
			$errors = '';
			$messages = '';
			foreach ( $wp_error->get_error_codes() as $code ) {
				$severity = $wp_error->get_error_data($code);
				foreach ( $wp_error->get_error_messages($code) as $error ) {
					if ( 'message' == $severity )
						$messages .= '	' . $error . "<br />\n";
					else
						$errors .= '	' . $error . "<br />\n";
				}
			}
			if ( !empty($errors) )
				echo '<p id="login_error">' . apply_filters('login_errors', $errors) . "</p>\n";
			if ( !empty($messages) )
				echo '<p class="message">' . apply_filters('login_messages', $messages) . "</p>\n";
		}
	}
}

function customloginpages_title($title) {
	global $pagenow;
	if ($pagenow == "wp-login.php") {
		switch($_GET['action']) {
			case 'register':
				$title = "Register at ";
				break;
			case 'lostpassword':
				$title = "Retrieve your lost password for ";
				break;
			case 'login':
			default:
				$title = "Login at ";
				break;
		}
	} else if ($pagenow == "profile.php") {
		$title = "Your Profile at ";
	}
	$title .= get_bloginfo('name');
	return $title;
}

function customloginpages_head($clp_msg) {
	$customloginpagesoptions = get_option('customloginpages');
	$headertemplate = $customloginpagesoptions['headertemplatename'];
        if (!empty($headertemplate) && file_exists(STYLESHEETPATH . '/'.$headertemplate)){
	include(STYLESHEETPATH . '/'.$headertemplate);
        } elseif (file_exists(STYLESHEETPATH . '/header_cl.php')) {
	include(STYLESHEETPATH . '/header_cl.php');
        } else {
	include(STYLESHEETPATH . '/header.php');
        }
	$code = str_replace("%%title%%", $clp_msg, $clp_options['afterheadercode']);
	echo $code;
	echo "<h1>".__($clp_msg)."</h1>";
}

function customloginpages_footer() {
	global $pagenow, $user_ID;

	if ($pagenow == "wp-login.php") {
			// Show the appropriate options
			echo '<ul id="clnav">'."\n";
			if (isset($_GET['action']) && $_GET['action'] != 'login')
				echo '<li><a href="'.site_url('wp-login.php', 'login').'">'.__('Log in').'</a></li>'."\n";
			if (get_option('users_can_register') && $_GET['action'] != 'register')
				echo '<li><a href="'.site_url('wp-login.php?action=register', 'login').'">'.__('Register').'</a></li>'."\n";
			if ($_GET['action'] != 'lostpassword')
				echo '<li><a href="'.site_url('wp-login.php?action=lostpassword', 'login').'" title="'.__('Password Lost and Found').'">'.__('Lost your password?').'</a></li>'."\n";
			echo '</ul>'."\n";

			// autofocus the username field  ?>
			<script type="text/javascript">try{document.getElementById('user_login').focus();}catch(e){}</script>
		<?php
	} else if (isset($user_ID)){
		echo '<ul id="clnav">'."\n";
		if (function_exists('wp_logout_url')) {
			echo '<li><a href="'.wp_logout_url().'">'.__('Log out').'</a></li>'."\n";
		} else {
			echo '<li><a href="'.site_url('wp-login.php?action=logout', 'logout').'">'.__('Log out').'</a></li>'."\n";
		}
		echo '</ul>'."\n";
	}
        echo "</div>";
	$customloginpagesoptions = get_option('customloginpages');
	$footertemplate = $customloginpagesoptions['footertemplatename'];
        if (!empty($footertemplate) && file_exists(STYLESHEETPATH . '/'.$footertemplate)){
	include(STYLESHEETPATH . '/'.$footertemplate);
        } elseif (file_exists(STYLESHEETPATH . '/footer_cl.php')) {
	include(STYLESHEETPATH . '/footer_cl.php');
        } else {
	include(STYLESHEETPATH . '/footer.php');
        }
}

function customloginpages_password() {
	$errors = new WP_Error();
	if ( $_POST['user_login'] ) {
		$errors = retrieve_password();
		if ( !is_wp_error($errors) ) {
			wp_redirect('wp-login.php?checkemail=confirm');
			exit();
		}
	}

	if ( 'invalidkey' == $_GET['error'] )
		$errors->add('invalidkey', __('Sorry, that key does not appear to be valid.'));

	$errors->add('registermsg', __('Please enter your username or e-mail address. You will receive a new password via e-mail.'), 'message');
	do_action('lost_password');
	do_action('lostpassword_post');
	customloginpages_head("Lost Password");

	customloginpages_show_errors($errors);
?>
	<form class="loginform" name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post">
		<p>
			<label><?php _e('Username or E-mail:') ?></label>
			<input type="text" name="user_login" id="user_login" class="input" value="<?php echo attribute_escape(stripslashes($_POST['user_login'])); ?>" size="20" tabindex="10" />
		</p>
		<br/>
		<?php do_action('lostpassword_form'); ?>
		<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" value="<?php _e('Get New Password'); ?>" tabindex="100" /></p>
	</form>
<?php
	customloginpages_footer();
}

function customloginpages_show_registerform() {
	global $clo_pluginpath, $clp_options;
	if ( !get_option('users_can_register') ) {
		wp_redirect(get_bloginfo('wpurl').'/wp-login.php?registration=disabled');
		exit();
	}

	$user_login = '';
	$user_email = '';

	if ( isset($_POST['user_login']) ) {
	    require_once( ABSPATH . WPINC . '/registration.php');

	    $user_login = $_POST['user_login'];
	    $user_email = $_POST['user_email'];
	    $errors = register_new_user($user_login, $user_email);
	    if ( !is_wp_error($errors) ) {
		    wp_redirect('wp-login.php?checkemail=registered');
		    exit();
	    }
	}

	customloginpages_head("Register");
	customloginpages_show_errors($errors);
?>
	<form class="loginform" name="registerform" id="registerform" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" method="post">
		<p>
			<label><?php _e('Username') ?>:</label>
			<input tabindex="1" type="text" name="user_login" id="user_login" class="input" value="<?php echo attribute_escape(stripslashes($user_login)); ?>" size="20" tabindex="10" />
			<label><?php _e('E-mail') ?>:</label>
			<input tabindex="2" type="text" name="user_email" id="user_email" class="input" value="<?php echo attribute_escape(stripslashes($user_email)); ?>" size="25" tabindex="20" />
		</p>
		<?php do_action('register_form'); ?>
		<p id="reg_passmail"><?php _e('A password will be e-mailed to you.') ?></p>
		<p class="submit"><input tabindex="4" type="submit" name="wp-submit" id="wp-submit" value="<?php _e('Register'); ?>" tabindex="100" /></p>
	</form>
<?php
	customloginpages_footer();
}

function customloginpages_show_loginform() {
	if ( isset( $_REQUEST['redirect_to'] ) )
		$redirect_to = $_REQUEST['redirect_to'];
	else
		$redirect_to = admin_url();

	if ( is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;
	else
		$secure_cookie = '';

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if ( !is_wp_error($user) ) {
		// If the user can't edit posts, send them to their profile.
		if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' ) )
			$redirect_to = admin_url('profile.php');
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) )
		$errors = new WP_Error();

	customloginpages_head("Login");

	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress."));
	if	( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )			$errors->add('loggedout', __('You are now logged out.'), 'message');
	elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )	$errors->add('registerdisabled', __('User registration is currently not allowed.'));
	elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )	$errors->add('confirm', __('Check your e-mail for the confirmation link.'), 'message');
	elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )	$errors->add('newpass', __('Check your e-mail for your new password.'), 'message');
	elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )	$errors->add('registered', __('Registration complete. Please check your e-mail.'), 'message');

	customloginpages_show_errors($errors);

	// login form
	?>
	<form class="loginform" action="<?php bloginfo('wpurl'); ?>/wp-login.php" method="post" >
		<p>
			<label for="user_login"><?php _e('Username:') ?></label>
			<input name="log" value="<?php echo attribute_escape(stripslashes($_POST['log'])); ?>" class="mid" id="user_login" type="text" />
			<br/>
			<label for="user_pass"><?php _e('Password:') ?></label>
			<input name="pwd" class="mid" id="user_pass" type="password" />
			<br/>
			<input name="rememberme" class="checkbox" id="rememberme" value="forever" type="checkbox" checked="checked"/>
			<label for="rememberme"><?php _e('Remember me'); ?></label>
		</p>
		<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit" value="<?php _e('Login'); ?> &raquo;" />
			<input type="hidden" name="testcookie" value="1" />
		</p>
	</form>
	<?php
	customloginpages_footer();
}


global $pagenow;
/*
Only executes when the page requested is wp-login.php and the action is not logout
*/

if ( $pagenow == "wp-login.php"  && $_GET['action'] != 'logout' && !isset($_GET['key']) ) {
	add_action('init', 'customloginpages_login_init', 98);
	add_filter('wp_title','customloginpages_title');
	add_action('wp_head', 'customloginpages_login_css');
}


// register options
add_action('admin_init', 'customloginpages_options_init' );
function customloginpages_options_init(){
	register_setting( 'customloginpages_options', 'customloginpages' );
}

// Add menu page
add_action('admin_menu', 'customloginpages_add_page');
function customloginpages_add_page() {
	add_options_page('Custom login pages Options', 'Custom login pages', 'manage_options', 'customlogin', 'customloginpages_options');
}
// Draw the menu page itself
function customloginpages_options() {
	?>
	<div class="wrap">
	    <?php screen_icon(); ?>
		<h2>Custom login pages Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields('customloginpages_options'); ?>
			<?php $customloginpagesoptions = get_option('customloginpages'); ?>
			<table class="form-table">
			    <tr>
				<td colspan="2">These files should be on your theme directory</td>
			    </tr>
				<tr valign="top"><th scope="row">Custom login header template name</th>
					<td><input type="text" name="customloginpages[headertemplatename]" value="<?php echo $customloginpagesoptions['headertemplatename']; ?>" /></td>
				</tr>
				<tr valign="top"><th scope="row">Custom login footer template name</th>
					<td><input type="text" name="customloginpages[footertemplatename]" value="<?php echo $customloginpagesoptions['footertemplatename']; ?>" /></td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
	<?php
}

?>
