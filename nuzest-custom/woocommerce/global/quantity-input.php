<?php
/**
 * Product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//ensure stepper always works, even if min/max not set
if ( !is_numeric( $min_value ) ) { $min_value = 0; }
if ( !is_numeric( $max_value ) ) { $max_value = 9999; }

?>

<div class="quantity">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			<label for="<?php echo esc_attr( $input_name ); ?>">Qty:</label>
		</div>
		<div class="col-sm-9 col-md-10">
			<a onclick="decQuantityStepper('<?php echo esc_attr( $input_name ); ?>')" class="btn btn-small btn-square qty-decrease">&ndash;</a>
			<input type="number" 
				step="<?php echo esc_attr( $step ); ?>" 
				<?php if ( is_numeric( $min_value ) ) : ?>min="<?php echo esc_attr( $min_value ); ?>"<?php endif; ?> 
				<?php if ( is_numeric( $max_value ) ) : ?>max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?> 
				name="<?php echo esc_attr( $input_name ); ?>" 
				value="<?php echo esc_attr( $input_value ); ?>" 
				title="<?php _ex( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" 
				class="input-text qty text" 
				size="4" 
			/>
			<a onclick="incQuantityStepper('<?php echo esc_attr( $input_name ); ?>')" class="btn btn-small btn-square qty-increase">+</a>
		</div>
	</div>
</div>
