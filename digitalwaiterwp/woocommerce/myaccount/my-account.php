<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<section id="thanks" class="block">
	<div class="block">
		<div class="waiter-window">
			
		</div>
		<div class="waiter-title">
			<h1>And now....<br>your diagnostic is getting ready.</h1>
			<p><img src="<?php echo get_template_directory_uri(); ?>/img/progressbar.png"></p>		
			<p>We are baking it specially for you. We’ll ask the chef to hurry, but this diagnostic is handmade by our team and may take a while. We’ll contact you by e-mail when it’s ready to you to devour.</p>
		</div>
	</div>
</section>
<?php wc_print_notices(); ?>
<section id="meanwhile">
	<div class="wrapper">
		<h2>Meanwhile, take a look at our website. Follow us at twitter or make yourself an orangegoal fan at facebook!</h2>
		<ul class="block">
			<li><a href="http://www.orangegoal.com"><img src="<?php echo get_template_directory_uri(); ?>/img/website.png"></a></li>
			<li><a href="https://www.facebook.com/Orangegoal-191623731221163/"><img src="<?php echo get_template_directory_uri(); ?>/img/facebook.png"></a></li>
			<li><a href="https://twitter.com/orange_goal"><img src="<?php echo get_template_directory_uri(); ?>/img/twitter.png"></a></li>
		</ul>
		<p class="myaccount_user">
			<?php
			printf(
				__( 'Hey <strong>%1$s</strong>! (not %1$s? <a href="%2$s">Sign out</a>).', 'woocommerce' ) . ' ',
				$current_user->display_name,
				wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
			);

			printf( __( 'You can come back here anytime and <a href="%s">add or edit your business info</a>.', 'woocommerce' ),
				wc_customer_edit_account_url()
			);
			?>
		</p>
	</div>
</section>
<?php do_action( 'woocommerce_before_my_account' ); ?>

<!-- <?php wc_get_template( 'myaccount/my-downloads.php' ); ?> 

<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php wc_get_template( 'myaccount/my-address.php' ); ?> 

<?php do_action( 'woocommerce_after_my_account' ); ?>
