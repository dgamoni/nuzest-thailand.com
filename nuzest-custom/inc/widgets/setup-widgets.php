<?php

// Create Widgets
function create_widget( $name, $id, $description ) {

	register_sidebar(array(
		'name' => __( $name ),	 
		'id' => $id, 
		'description' => __( $description ),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<p class="h1">',
		'after_title' => '</p>'
	));

}

create_widget( __('Blog Sidebar', 'nuzest-custom-admin'), 'blog', __('Displays on the side of blog pages', 'nuzest-custom-admin') );

create_widget( __('Footer Left', 'nuzest-custom-admin'), 'footer-left', __('Displays at the bottom of all pages - left hand side', 'nuzest-custom-admin') );
create_widget( __('Footer Right', 'nuzest-custom-admin'), 'footer-right', __('Displays at the bottom of all pages - right hand side', 'nuzest-custom-admin') );

create_widget( __('Quick Cart', 'nuzest-custom-admin'), 'quick-cart', __('Show the shopping cart contents on hover', 'nuzest-custom-admin') );

create_widget( __('Contact Form Popup', 'nuzest-custom-admin'), 'contact-form', __('Displays form in a popup window on the Contact Us page', 'nuzest-custom-admin') );

?>