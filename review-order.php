<?php
/**
 * Review order form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div id="order_review">

	<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<div class="innercontainer">
<h2>Your Order Summary </h2>
<div class="baskit shop_table cart">

	<ul>

    	<li>

        	<div class="titlehead">

                <span class="shoppingPName">Item</span>

               <?php /*?> <th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th><?php */?>
                <span class="product-size"><?php _e( 'Size | Color', 'woocommerce' ); ?></span>

                <span class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></span>

                <span class="shoppingPqty"><?php _e( 'Quantity', 'woocommerce' ); ?></span>

                <span class="shoppingPtotal"><?php _e( 'Total', 'woocommerce' ); ?></span>

            </div>

		</li>

	<tbody>

		<?php do_action( 'woocommerce_before_cart_contents' ); ?>



		<?php

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );



			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

				?>

				<li class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

				<div class="productcountaner">

                	<div class="productimage">

                    	<?php

							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );



							if ( ! $_product->is_visible() )

								echo $thumbnail;

							else

								printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );

						?>

                    </div>
                    <div class="productdescription">
                    	<span><?php
							if ( ! $_product->is_visible() )
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
							else
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key ); ?>

							</span>
                        <?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove blue" title="%s">Remove PRODUCT</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
						?>
                    </div>
					<div class="product-size2">
						<?php // Meta data
							echo WC()->cart->get_item_data( $cart_item );

               				// Backorder notification
               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
						?>
					</div>



					<div class="product-price2">

						<?php

							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

						?>

					</div>



					<div class="productquantity">

						<?php
							echo '<span>'.$cart_item['quantity'].'</span>' ;

							/*if ( $_product->is_sold_individually() ) {

								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );

							} else {

								$product_quantity = woocommerce_quantity_input( array(

									'input_name'  => "cart[{$cart_item_key}][qty]",

									'input_value' => $cart_item['quantity'],

									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),

								), $_product, false );

							}*/



							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );

						?>

					</div>



					<div class="productPricefigure">

						<?php

							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );

						?>

					</div>

                    </div>

				</li>

				<?php

			}

		}



		do_action( 'woocommerce_cart_contents' );

		?>

		<li>

			<?php /*?><div class="actions productaddtocart">



				<?php if ( WC()->cart->coupons_enabled() ) { ?>

					<div class="coupon">



						<label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />



						<?php do_action('woocommerce_cart_coupon'); ?>



					</div>

				<?php } ?>

			</div><?php */?>

		</li>



		<?php do_action( 'woocommerce_after_cart_contents' ); ?>

    </ul>
</div>
</div>
<?php do_action( 'woocommerce_after_cart_table' ); ?>


</form>
<div class="agree_box">    	
    <img src="<?php bloginfo('template_url'); ?>/images/agree.png" alt="">
    <label>
        <span><input type="checkbox" checked="checked"></span>
        I agree to the Leather Australia <a target="_blank" href="<?php echo home_url(); ?>/terms-conditions">Terms &amp; Conditions</a> Proceed to place my order.                        
    </label>
</div>
<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

	<?php woocommerce_cart_totals(); ?>

	<?php woocommerce_shipping_calculator(); ?>

</div>
<div class="clear"></div>
	<?php do_action( 'woocommerce_review_order_before_payment' ); ?>

	<div id="payment">
    	<h5>YOUR PAYMENT DETAILS: <small>Fields with (*) are mandatory.</small></h5>
		<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="payment_methods methods">
			<?php
				$available_gateways = WC()->payment_gateways->get_available_payment_gateways();
				if ( ! empty( $available_gateways ) ) {

					// Chosen Method
					if ( isset( WC()->session->chosen_payment_method ) && isset( $available_gateways[ WC()->session->chosen_payment_method ] ) ) {
						$available_gateways[ WC()->session->chosen_payment_method ]->set_current();
					} elseif ( isset( $available_gateways[ get_option( 'woocommerce_default_gateway' ) ] ) ) {
						$available_gateways[ get_option( 'woocommerce_default_gateway' ) ]->set_current();
					} else {
						current( $available_gateways )->set_current();
					}

					foreach ( $available_gateways as $gateway ) {
						?>
						<li class="payment_method_<?php echo $gateway->id; ?>">
							<input id="payment_method_<?php echo $gateway->id; ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
							<label for="payment_method_<?php echo $gateway->id; ?>"><?php echo $gateway->get_title(); ?> <?php echo $gateway->get_icon(); ?></label>
							<?php
								if ( $gateway->has_fields() || $gateway->get_description() ) :
									echo '<div class="payment_box payment_method_' . $gateway->id . '" ' . ( $gateway->chosen ? '' : 'style="display:none;"' ) . '>';
									$gateway->payment_fields();
									echo '</div>';
								endif;
		?>
						</li>
						<?php
					}
				} else {

					if ( ! WC()->customer->get_country() )
						$no_gateways_message = __( 'Please fill in your details above to see available payment methods.', 'woocommerce' );
					else
						$no_gateways_message = __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' );

					echo '<p>' . apply_filters( 'woocommerce_no_available_payment_methods_message', $no_gateways_message ) . '</p>';

				}
			?>
		</ul>
		<?php endif; ?>

		

		<div class="clear"></div>

	</div>
    <?php get_sidebar('also'); ?>

	<?php do_action( 'woocommerce_review_order_after_payment' ); ?>

</div>
