<?php
/**
 * Variable Product Add to Cart
 */
global $woocommerce, $product, $post;

$variation_params = woocommerce_swatches_get_variation_form_args();

do_action('woocommerce_before_add_to_cart_form'); ?>
<form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" 
      class="variations_form cart swatches" 
      method="post" 
      enctype='multipart/form-data' 
      data-product_id="<?php echo $post->ID; ?>" 
      data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>"
      	data-product_attributes="<?php echo esc_attr( json_encode( $variation_params['attributes_renamed'] ) ); ?>"
	data-product_variations_flat="<?php echo esc_attr( json_encode( $variation_params['available_variations_flat'] ) ); ?>"
      >
      
    <div class="variation_form_section">
        <?php
        $woocommerce_variation_control_output = new WC_Swatch_Picker($product->id, $attributes, $selected_attributes);
        $woocommerce_variation_control_output->picker();
        ?>
    </div>

 	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	<div class="single_variation_wrap" style="display:none;">
		<div class="single_variation"></div>
		<div class="variations_button">
        	<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" value="" />
			<label>Quantity:</label> <?php woocommerce_quantity_input(); ?>
            <hr />
            <div class="price_n_button">
                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <p class="price">Price: <?php echo $product->get_price_html(); ?></p>
                    <meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
                    <meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
                    <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
                </div>
                <button type="submit" class="single_add_to_cart_button button alt"><?php echo apply_filters('single_add_to_cart_text', __( 'Add to cart', 'woocommerce' ), $product->product_type); ?></button>
            </div>
		</div>
	</div>
	<div><input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" /></div>

	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>
