<select 
	class="hidden"
	data-attribute-name="<?php echo 'attribute_' . $st_name; ?>"
	id="<?php echo esc_attr( $st_name ); ?>">
	<option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
	<?php if ( is_array( $options ) ) : ?>
		<?php
		$selected_value = (isset( $picker->selected_attributes[$lookup_name] )) ? $picker->selected_attributes[$lookup_name] : '';

		if ( isset( $_GET['attribute_' . $st_name] ) ) {
			$selected_value = esc_attr( $_GET['attribute_' . $st_name] );
		}

		// Get terms if this is a taxonomy - ordered
		if ( taxonomy_exists( $st_name ) ) :
			$args = array('menu_order' => 'ASC', 'hide_empty' => false);
			$terms = get_terms( $st_name, $args );

			foreach ( $terms as $term ) :

				if ( !in_array( $term->slug, $options ) ) {
					continue;
				}

				echo '<option value="' . esc_attr( md5( $term->slug ) ) . '" ' . selected( $selected_value, $term->slug ) . '>' . $term->name . '</option>';
			endforeach;
		else :
			foreach ( $options as $option ) :
				echo '<option value="' . md5( sanitize_title( $option ) ) . '" ' . selected( $selected_value, sanitize_title( $option ) ) . '>' . $option . '</option>';
			endforeach;
		endif;
		?>
	<?php endif; ?>
</select>

<?php 
	//use fake buttons that control the hidden default select above
?>
<?php if ( is_array( $options ) ) : 
	//product categories
	global $product;
	$cats = get_the_terms($product->id, 'product_cat');
?>
	<div class="input-group" role="group" data-toggle="buttons">
	<?php
		$selected_value = (isset( $picker->selected_attributes[$lookup_name] )) ? $picker->selected_attributes[$lookup_name] : '';

		if ( isset( $_GET['attribute_' . $st_name] ) ) {
			$selected_value = esc_attr( $_GET['attribute_' . $st_name] );
		}

		// Get terms if this is a taxonomy - ordered
		if ( taxonomy_exists( $st_name ) ) :
			$args = array('menu_order' => 'ASC', 'hide_empty' => false);
			$terms = get_terms( $st_name, $args );
			foreach ( $terms as $term ) :
				if ( !in_array( $term->slug, $options ) ) {
					continue;
				}
				echo '<div class="btn btn-square ';
				foreach ( $cats as $cat ) {
					echo 'btn-' . $cat->slug . ' ';
				}
				echo ($selected_value == $term->slug) ? 'active' : '';
				echo '">';
				echo '<input type="radio" ';
				echo 'name="__'. esc_attr( $st_name ) .'" ';
				echo 'onchange="jQuery(\'#'. esc_attr( $st_name ) .'\').val(\''. esc_attr( md5( $term->slug ) ) .'\').change()" ';
				echo '/>' .$term->name;
				echo '</div>';
			endforeach;
		else :
			foreach ( $options as $option ) :
				echo '<div class="btn btn-square ';
				echo ($selected_value == sanitize_title( $option )) ? 'active' : '';
				echo '">';
				echo '<input type="radio" ';
				echo 'name="__'. esc_attr( $st_name ) .'" ';
				echo 'onchange="jQuery(\'#'. esc_attr( $st_name ) .'\').val(\''. md5( sanitize_title( $option ) ) .'\').change()" ';
				echo '/>' . $option;
				echo '</div>';
			endforeach;
		endif;
	?>
	</div>
<?php endif; ?>