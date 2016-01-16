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
	
	<table cellspacing="0">

		<tr class="cart-subtotal">
			<td class="submit-subtotal-cart"><div class="submit-subtotal-cart-back"><span class="subtotal-cart-back"><?php _e( 'Subtotal', 'woocommerce' ); ?></span> <?php wc_cart_totals_subtotal_html(); ?></div></td>
			<td><?php do_action( 'woocommerce_proceed_to_checkout' ); ?></td>
		</tr>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
