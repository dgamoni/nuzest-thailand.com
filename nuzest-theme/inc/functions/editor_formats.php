<?php

/* Add block formats to the visual editor */
function wpb_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');


function my_mce_before_init_insert_formats( $init_array ) {  
 
// Define the style_formats array
    $style_formats = array( 
		array(
			'title'	=> 'Content Blocks',
			'items'	=> array(
				array(  
					'title' => 'Content Block',  
					'block' => 'span',  
					'classes' => 'content-block',
					'wrapper' => true,
				), 
			)
		),
        array(  
            'title' => 'Buttons',  
            'items' => array(
				array(  
					'title' => 'Default button',  
					'inline' => 'a',   
					'classes' => 'btn',
					'wrapper' => true,
					'selector' => 'a',
				),
				array(  
					'title' => 'Green button',  
					'inline' => 'a', 
					'classes' => 'btn btn-primary',
					'wrapper' => true,
					'selector' => 'a',
				),
				array(  
					'title' => 'Green button solid',  
					'inline' => 'a',  
					'classes' => 'btn btn-primary solid',
					'wrapper' => true,
					'selector' => 'a',
				),
				array(  
					'title' => 'Orange button',  
					'inline' => 'a',   
					'classes' => 'btn btn-orange',
					'wrapper' => true,
					'selector' => 'a',
				),
				array(  
					'title' => 'Orange button solid',  
					'inline' => 'a',   
					'classes' => 'btn btn-orange solid',
					'wrapper' => true,
					'selector' => 'a',
				),
				array(  
					'title' => 'Purple button',  
					'inline' => 'a',   
					'classes' => 'btn btn-purple',
					'wrapper' => true,
					'selector' => 'a',
				),
				array(  
					'title' => 'Purple button solid',  
					'inline' => 'a',   
					'classes' => 'btn btn-purple solid',
					'wrapper' => true,
					'selector' => 'a',
				),
			)
    	),
		array(
			'title'	=> 'Fonts',
			'items'	=> array(
				array(  
					'title' => 'Viva Beautiful',  
					'block' => 'span',  
					'classes' => 'VivaBeautiful',
					'wrapper' => true,
					'selector' => 'p, h1, h2',
				), 
				array(  
					'title' => 'Baskerville',  
					'block' => 'span',  
					'classes' => 'Script',
					'wrapper' => true,
					'selector' => 'p, h1, h2, h3, h4, h5',
				), 
			)
		),
		array(
			'title'	=> 'Faux Headings',
			'items'	=> array(
				array(  
					'title' => 'Style as <h1>',  
					'inline' => 'span',  
					'classes' => 'h1',
					'wrapper' => true,
					'selector' => 'p, h2, h3, h4, h5',
				), 
				array(  
					'title' => 'Style as <h2>',  
					'inline' => 'span',  
					'classes' => 'h2',
					'wrapper' => true,
					'selector' => 'p, h1, h3, h4, h5',
				), 
				array(  
					'title' => 'Style as <h3>',  
					'inline' => 'span',  
					'classes' => 'h3',
					'wrapper' => true,
					'selector' => 'p, h1, h2, h4, h5',
				), 
				array(  
					'title' => 'Style as <h4>',  
					'inline' => 'span',  
					'classes' => 'h4',
					'wrapper' => true,
					'selector' => 'p, h1, h2, h3, h5',
				), 
				array(  
					'title' => 'Style as <h5>',  
					'inline' => 'span',  
					'classes' => 'h5',
					'wrapper' => true,
					'selector' => 'p, h1, h2, h3, h4',
				), 
			)
		),
	);  
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  
     
    return $init_array;  
   
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 
