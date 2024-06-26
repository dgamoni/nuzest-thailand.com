<?php
/**
 * Quick View Button
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo apply_filters( 'woocommerce_loop_quick_view_button', sprintf( '<a href="%s" title="%s" class="quick-view-button btn btn-primary"><span></span>%s</a>', esc_url( $link ), esc_attr( get_the_title() ), __( 'Quick Buy', 'wc_quick_view' ) ) );