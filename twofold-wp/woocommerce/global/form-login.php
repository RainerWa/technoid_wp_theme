<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form method="post" class="woocommerce-form woocommerce-form-login login customer_login" <?php echo ( $hidden ) ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>

	<p class="form-row form-row-first">
		<label for="username"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
		<input type="text" class="input-text" name="username" id="username" autocomplete="username" required aria-required="true" />
	</p>
	<p class="form-row form-row-last">
		<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
		<input class="input-text woocommerce-Input" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
	</p>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<p class="lost_password">
		<label for="rememberme" class="inline">
			<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'woocommerce' ); ?>
		</label>
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
	</p>

	<p class="form-row">
		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
		<input type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
	</p>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
