<?php

// Filter to replace default css class names for vc_row shortcode and vc_column
// https://kb.wpbakery.com/docs/developers-how-tos/change-css-class-names-in-output
add_filter( 'vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2 );
function custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
  if ( $tag == 'vc_row' ) {
		$class_string = str_replace( 'vc_row', 'row', $class_string );
    	$class_string = str_replace( 'vc_row-fluid', 'row-fluid', $class_string );
  }
  if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
		$class_string = str_replace( 'vc_column_container', 'column', $class_string );
		
		$class_string = preg_replace( '/vc_col-xs-(\d{1,2})/', 'col-xs-$1', $class_string );
    	$class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'col-sm-$1', $class_string );
		$class_string = preg_replace( '/vc_col-md-(\d{1,2})/', 'col-md-$1', $class_string );
		$class_string = preg_replace( '/vc_col-lg-(\d{1,2})/', 'col-lg-$1', $class_string );
		
		$class_string = preg_replace( '/vc_col-xs-offset-(\d{1,2})/', 'col-xs-offset-$1', $class_string );
		$class_string = preg_replace( '/vc_col-sm-offset-(\d{1,2})/', 'col-sm-offset-$1', $class_string );
		$class_string = preg_replace( '/vc_col-md-offset-(\d{1,2})/', 'col-md-offset-$1', $class_string );
		$class_string = preg_replace( '/vc_col-lg-offset-(\d{1,2})/', 'col-lg-offset-$1', $class_string );
  }
  return $class_string; 
} 

