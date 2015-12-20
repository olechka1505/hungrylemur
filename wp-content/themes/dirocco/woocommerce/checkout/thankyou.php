<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'woocommerce' );
			else
				_e( 'Please attempt your purchase again.', 'woocommerce' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

		<p><?php //echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?></p>
		
		<!--
		<ul class="order_details">
			<li class="order">
				<?php //_e( 'Order Number:', 'woocommerce' ); ?>
				<strong><?php //echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php //_e( 'Date:', 'woocommerce' ); ?>
				<strong><?php// echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php //_e( 'Total:', 'woocommerce' ); ?>
				<strong><?php //echo $order->get_formatted_order_total(); ?></strong>
			</li>
			<?php //if ( $order->payment_method_title ) : ?>
			<li class="method">
				<?php //_e( 'Payment Method:', 'woocommerce' ); ?>
				<strong><?php //echo $order->payment_method_title; ?></strong>
			</li>
			<?php //endif; ?>
		</ul>
		<div class="clear"></div>		
		-->
		
	<?php endif; ?>

	<p class="order-number-main"><?php _e( 'Order Number:', 'woocommerce' ); ?> <?php echo $order->get_order_number(); ?></p>
	
	<div class="col-12 col-md-12 col-sm-12 col-xs-12 padding-0">
	
	<h2 class="order-received-title">Shipping address</h2>

	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 padding-0">
	
	<?php
    //if ( $order->billing_first_name )
	echo '<p class="order-received-shipping">' . $order->billing_first_name. " " .$order->billing_last_name. '</p>';
	echo '<p class="order-received-shipping">' . $order->billing_address_1. '</p>';
	echo '<p class="order-received-shipping">' . $order->billing_address_2. '</p>';
	echo '<p class="order-received-shipping">' . $order->billing_postcode. '</p>';
	?>
	
	</div>
	
			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

		<?php endif; ?>
	
	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 padding-0">
	
	<table class="shop_table order_details thankyou-page">
    <tbody>
        <?php
        if ( sizeof( $order->get_items() ) > 0 ) {

            foreach( $order->get_items() as $item ) {
                $_product     = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
                $item_meta    = new WC_Order_Item_Meta( $item['item_meta'], $_product );

                ?>
                <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
                    <td class="product-thumbnail">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $_product->is_visible() ) {
								echo $thumbnail;
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
							}
						?>
					</td>
					<td class="product-name">
						<?php
							if ( ! $_product->is_visible() ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
							}

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
							}
						?>
					</td>
					<td class="product-name">
						NON-PRESCRIPTION
					</td>
                    <td class="product-total">
                        <?php echo $order->get_formatted_line_subtotal( $item ); ?>
                    </td>
                </tr>
                <?php

                if ( $order->has_status( array( 'completed', 'processing' ) ) && ( $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) ) ) {
                    ?>
                    <tr class="product-purchase-note">
                        <td colspan="3"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?></td>
                    </tr>
                    <?php
                }
            }
        }

        do_action( 'woocommerce_order_items_table', $order );
        ?>
    </tbody>
</table>

</div>
</div>
	
	<?php //do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php //do_action( 'woocommerce_thankyou', $order->id ); ?>

<?php else : ?>

	<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

<?php endif; ?>
