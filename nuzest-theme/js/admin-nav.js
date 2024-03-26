// JavaScript Document
jQuery(document).ready(function($){
	
// Add label 'Mega Menu' to menu items
	
	// Iterate through all top level menu items
	jQuery('li.menu-item.menu-item-depth-0').each(function(){
		// If the ACF field 'nz_mega_menu' is checked
		if ( jQuery(this).find('.menu-item-settings .acf-fields div[data-name="nz_mega_menu"] input[type=checkbox]').attr('checked')){
			jQuery( "<span class='item-menu-type'>Mega menu</span>" ).insertBefore(jQuery(this).find(".item-type"));
		}
		
	});
	
});
