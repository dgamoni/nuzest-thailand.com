<?php
$loop = 0;
foreach ( $picker->attributes as $name => $options ) : $loop++;
	$st_name = sanitize_title( $name );
	$hashed_name = md5( $st_name );
	$lookup_name = '';

	if ( isset( $picker->swatch_type_options[$hashed_name] ) ) {
		$lookup_name = $hashed_name;
	} elseif ( isset( $picker->swatch_type_options[$st_name] ) ) {
		$lookup_name = $st_name;
	}

	// @todo: is this ok with i18n? Will the attribute name change?
	$display_label = ($st_name !== "pa_flavour") ? true : false;
?>

	<div class="row">
	<?php if ($display_label): ?>
		<div class="col-sm-3 col-md-2">
			<label for="<?php echo $st_name; ?>"><?php echo WC_Swatches_Compatibility::wc_attribute_label( $name ); ?>:</label>
		</div>

		<div class="col-sm-9 col-md-10">

	<?php else: ?>
		<div>
	<?php endif; ?>

			<?php
			if ( isset( $picker->swatch_type_options[$lookup_name] ) ) {
				$picker_type = $picker->swatch_type_options[$lookup_name]['type'];
				if ( $picker_type == 'default' ) {
					$picker->render_default( $st_name, $options );
				} else {
					$picker->render_picker( $st_name, $options, $name );
				}
			} else {
				$picker->render_default( $st_name, $options );
			}
			?>

			<div class="clearfix" style="padding-bottom: 20px"></div>
		</div>
	</div>

<?php endforeach; ?>
