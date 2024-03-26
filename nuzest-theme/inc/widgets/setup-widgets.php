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

create_widget( __('Blog Sidebar', 'nuzest-theme'), 'blog-sidebar', __('Displays on the right-hand side of blog pages', 'nuzest-theme') );
create_widget( __('Page Sidebar', 'nuzest-theme'), 'page-sidebar', __('Displays on the right-hand side of pages using "Page Sidebar"', 'nuzest-theme') );
create_widget( __('Footer Left', 'nuzest-theme'), 'footer-left', __('Displays at the bottom of all pages - left-hand side', 'nuzest-theme') );
create_widget( __('Footer Right', 'nuzest-theme'), 'footer-right', __('Displays at the bottom of all pages - right-hand side', 'nuzest-theme') );


?>