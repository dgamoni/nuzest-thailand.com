<?php



function storeMetaInit() {

	add_meta_box( "store_fields", "Store Details", "store_details_meta_box", "store", "normal", "default" );

	//    add_meta_box('post_map_tab', __('Map', 'post_textdomain'), 'map_tab_box', 'store');

	add_action( 'save_post', 'save_store_custom_fields' );

	add_action( 'admin_enqueue_scripts', 'store_admin_assets' );

}
add_action( 'admin_init', 'storeMetaInit' );




function storeMetaColumns( $columns ) {

	$columns = array(
		'cb' 			=> '<input type="checkbox" />',
		'title' 		=> __( 'Title' ),
		'store_type' 	=> __( 'Store Type' )
	);

	return $columns;
}
add_filter( 'manage_edit-store_columns', 'storeMetaColumns' );




function storeSortableColumns( $columns ) {

	$columns[ 'title' ] = 'title';
	$columns[ 'store_type' ] = 'store_type';

	return $columns;
}
add_filter( 'manage_edit-store_sortable_columns', 'storeSortableColumns' );




function storeManageColumns( $column, $post_id ) {

	global $post;

	switch ( $column ) {

		case 'store_type':

			$store_type = wp_get_post_terms( $post_id, 'store_type' );
			print_r( $store_type[ 0 ]->name );

			break; /* Just break out of the switch statement for everything else. */

		default:

			break;
	}
}
add_action( 'manage_store_posts_custom_column', 'storeManageColumns', 10, 2 );




function store_orderby_store_type_clauses( $clauses, $wp_query ) {

	global $wpdb;

	if ( isset( $wp_query->query[ 'orderby' ] ) && 'store_type' == $wp_query->query[ 'orderby' ] ) {


		$clauses[ 'join' ] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;


		$clauses[ 'where' ] .= " AND (taxonomy = 'store_type' OR taxonomy IS NULL)";
		$clauses[ 'groupby' ] = "object_id";
		$clauses[ 'orderby' ] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
		$clauses[ 'orderby' ] .= ( 'ASC' == strtoupper( $wp_query->get( 'order' ) ) ) ? 'ASC' : 'DESC';

	}

	return $clauses;
}

add_filter( 'posts_clauses', 'store_orderby_store_type_clauses', 10, 2 );




/**
 * METABOX CONTENT
 */

function store_details_meta_box( $post ) {

	$address = get_post_meta( $post->ID, 'street_address', true );

	$location = get_post_meta( $post->ID, 'location', true );

	$city = get_post_meta( $post->ID, 'city', true );

	$state = get_post_meta( $post->ID, 'state', true );

	$zip_code = get_post_meta( $post->ID, 'zip_code', true );

	$phone = get_post_meta( $post->ID, 'phone', true );

	$fax = get_post_meta( $post->ID, 'fax', true );

	$url = get_post_meta( $post->ID, 'url', true );

	if ( !$location || ( $location[ 'lat' ] == 0 && $location[ 'lng' ] == 0 ) ) {

		$location[ 'lat' ] = '47.6291351';

		$location[ 'lng' ] = '-122.3441147';

	}

	?>

	<div class="row">

		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSCQ_udpx7yD22jSakK9D69WdZUOc-jCQ&libraries=places&callback=initAutocomplete" async defer></script>

		<input id="pac-input" class="controls" type="text" placeholder="Search Box" style="margin-top:9px; width:350px;height:31px;"/>

		<label>
			<?= __('Location') ?>: </label><br/>

		<input class="location" name="location" type="hidden" value="<?= (float)$location['lat'] ?>,<?= (float)$location['lng'] ?>"/>

		<div id="map_canvas" style="width: 100%;height: 500px;"></div>

	</div>


	<div class="row">

		<label>
			<?= __('Address') ?>: </label><br/>

		<input type="text" name="street_address" value="<?= $address ?>"/>

	</div>


	<div class="row">

		<label>
			<?= __('City') ?>: </label><br/>

		<input type="text" name="city" value="<?= $city ?>"/>

	</div>


	<div class="row">

		<label>
			<?= __('State') ?>: </label><br/>

		<input type="text" name="state" value="<?= $state ?>"/>

	</div>


	<div class="row">

		<label>
			<?= __('Zip_code') ?>: </label><br/>

		<input type="text" name="zip_code" value="<?= $zip_code ?>"/>

	</div>


	<div class="row">

		<label>
			<?= __('Phone') ?>: </label><br/>

		<input type="text" name="phone" value="<?= $phone ?>"/>

	</div>


	<div class="row">

		<label>
			<?= __('Fax') ?>: </label><br/>

		<input type="text" name="fax" value="<?= $fax ?>"/>

	</div>


	<div class="row">

		<label>
			<?= __('Url') ?>: </label><br/>

		<input type="text" name="url" value="<?= $url ?>"/>

	</div>

	<?php

}





/**
 * METABOX SAVE
 */


function save_store_custom_fields( $post ) {

	global $post;

	if ( !$post ) {
		return;
	}


	if ( $_POST[ 'location' ] ) {

		$location = explode( ',', $_POST[ 'location' ] );

		$location = [ 'lat' => $location[ 0 ], 'lng' => $location[ 1 ] ];

	}


	$location = isset( $location ) ? $location : $_POST[ 'location' ];

	update_post_meta( $post->ID, "street_address", $_POST[ 'street_address' ] );
	update_post_meta( $post->ID, "location", $location );
	update_post_meta( $post->ID, "city", $_POST[ 'city' ] );
	update_post_meta( $post->ID, "state", $_POST[ 'state' ] );
	update_post_meta( $post->ID, "zip_code", $_POST[ 'zip_code' ] );
	update_post_meta( $post->ID, "phone", $_POST[ 'phone' ] );
	update_post_meta( $post->ID, "fax", $_POST[ 'fax' ] );
	update_post_meta( $post->ID, "url", $_POST[ 'url' ] );

}





/**
 * METABOX ASSETS AND MISC
 */


function store_admin_assets() {

	global $post;

	if ( 'store' != $post->post_type ) {
		return;
	}

	wp_enqueue_script( 'location', get_template_directory_uri() . '/js/locationCustom.js', array( 'jquery' ) );

}