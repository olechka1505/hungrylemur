<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
do_action('woocommerce_before_cart_totals');
?>
<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>
	
	 <?php 
	 
		$test = $woocommerce->cart->cart_contents_count;
		
	 
	 ?>
	<div class="col-md-4 col-xs-12 no-padding text-right pull-right">
			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td data-title="<?php wc_cart_totals_coupon_label( $coupon ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>
	</div>
	
	<table cellspacing="0">

		<?php /*foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td data-title="<?php wc_cart_totals_coupon_label( $coupon ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; */?>
		
		<tr class="cart-subtotal">
			<td class="submit-subtotal-cart"><div class="submit-subtotal-cart-back"><span class="subtotal-cart-back"><?php _e( 'Subtotal', 'woocommerce' ); ?></span> <?php wc_cart_totals_subtotal_html(); ?></div></td>
			<td><?php do_action( 'woocommerce_proceed_to_checkout' ); ?></td>
		</tr>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
