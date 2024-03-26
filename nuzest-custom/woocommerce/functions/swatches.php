<?php

add_action('woocommerce_swatches_before_picker_item','nz_wc_swatches_before_picker_item', 10);
function nz_wc_swatches_before_picker_item($item) {
	echo '<div class="option-outer-wrapper">';
	echo '<div class="option-inner-wrapper">';
}

add_action('woocommerce_swatches_after_picker_item','nz_wc_swatches_after_picker_item', 10);
function nz_wc_swatches_after_picker_item($item) {
	echo '</div>';
	echo '<label>'.$item->term->name.'</label>';
	echo '</div>';
}
