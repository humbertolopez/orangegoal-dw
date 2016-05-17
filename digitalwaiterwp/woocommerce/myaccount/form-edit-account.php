<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<section id="tellusmore" class="block">
	<div class="block">
		<div class="restaurant-front">
			<img src="<?php echo get_template_directory_uri(); ?>/img/restaurant.png">
		</div>
		<div class="waiter-title">
			<h1>And now, tell us a little more about your restaurant.</h1>
			<h2>To create a really good meal, you need the best ingredients.</h2>
		</div>
		<div class="waiter-title">
			<p>With marketing, it’s the same. We need the freshest info to get impressive results. We’ll ask you general information about your brand, that’ll help us a lot to find out how’s your restaurant is perceived, its strengths and online presence.</p>			
		</div>
	</div>
</section>
<section id="aboutrestaurant" class="block">
	<div class="restaurantinfo" class="block">
	<?php wc_print_notices(); ?>
		<form class="edit-account" action="" method="post">
			<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
			<p class="form-row form-row-first">
				<label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?></label>
				<input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
			</p>
			<p class="form-row form-row-last">
				<label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?></label>
				<input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
			</p>
			<div class="clear"></div>
			<p class="form-row form-row-wide">
				<label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="email" class="input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
			</p>
			<?php do_action( 'woocommerce_edit_account_form' ); ?>
			<fieldset>
				<legend><?php _e( 'Password Change', 'woocommerce' ); ?></legend>
				<p>If you're using your facebook account to login, you can leave blank this area.</p>
				<p class="form-row form-row-wide">
					<label for="password_current"><?php _e( 'Current Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
					<input type="password" class="input-text" name="password_current" id="password_current" />
				</p>
				<p class="form-row form-row-wide">
					<label for="password_1"><?php _e( 'New Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
					<input type="password" class="input-text" name="password_1" id="password_1" />
				</p>
				<p class="form-row form-row-wide">
					<label for="password_2"><?php _e( 'Confirm New Password', 'woocommerce' ); ?></label>
					<input type="password" class="input-text" name="password_2" id="password_2" />
				</p>
			</fieldset>
			<div class="clear"></div>
			<p>
				<?php wp_nonce_field( 'save_account_details' ); ?>		
				<input type="submit" class="button" name="save_account_details" value="<?php esc_attr_e( 'Save changes!', 'woocommerce' ); ?>" />
				<input type="hidden" name="action" value="save_account_details" />
			</p>
			<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
		</form>
	</div>
</section>
