<?php 

	$locations = array(
		array(
			'region_name'          => __('Global' , 'nuzest-custom'),
			'distribution_company' => 'Nuzest Life Pty Ltd',
			'website'              => 'http://www.nuzest.com',
			'phone'                => '+61 (02) 9358 3855',
			'address_1'            => '405/24-30 Springfield Ave',
			'address_2'            => '',
			'city'                 => 'Potts Point',
			'state'                => 'NSW',
			'postcode'             => '2011',
			'country'              => 'Australia'
		),
		array(
			'region_name'          => __('Australia', 'nuzest-custom'),
			'distribution_company' => 'Nuzest Australia',
			'website'              => 'http://www.nuzest.com.au',
			'phone'                => '+61 1300 575 121',
			'address_1'            => 'Suite 112, Level 1',
			'address_2'            => '90-96 Bourke Road',
			'city'                 => 'Alexandria',
			'state'                => 'NSW',
			'postcode'             => '2015',
			'country'              => 'Australia'
		),
		array(
			'region_name'          => __('New Zealand', 'nuzest-custom'),
			'distribution_company' => 'Vital Health Co',
			'website'              => 'http://www.nuzest.co.nz',
			'phone'                => '+64 9 448 2773',
			'address_1'            => '36B Arrenway Drive',
			'address_2'            => '',
			'city'                 => 'Rosedale',
			'state'                => 'Auckland',
			'postcode'             => '0632',
			'country'              => 'New Zealand'
		),
		array(
			'region_name'          => __('UK & Europe', 'nuzest-custom'),
			'distribution_company' => 'The Bite Outlet Ltd',
			'website'              => 'http://www.nuzest.co.uk',
			'phone'                => '+44 (0)1306 646 554',
			'address_1'            => 'The Atrium',
			'address_2'            => 'Curtis Road',
			'city'                 => 'Dorking',
			'state'                => 'Surrey',
			'postcode'             => 'RH4 1XA',
			'country'              => 'United Kingdom'
		),
		array(
			'region_name'          => __('USA & Canada', 'nuzest-custom'),
			'distribution_company' => 'Nuzest USA',
			'website'              => 'http://www.nuzest-usa.com',
			'phone'                => '+1 206 249 9865',
			'address_1'            => '1100 Dexter Ave N,',
			'address_2'            => 'Ste 100',
			'city'                 => 'Seattle',
			'state'                => 'WA',
			'postcode'             => '98109',
			'country'              => 'United States of America'
		),
		array(
			'region_name'          => __('Hong Kong', 'nuzest-custom'),
			'distribution_company' => 'Concinnity Concept Limited',
			'website'              => 'http://www.nuzest.hk',
			'phone'                => '+852 9528 2436',
			'address_1'            => '12A Kam Wing Commercial Building',
			'address_2'            => '28 Minden Avenue',
			'city'                 => 'Tsim Sha Tsui',
			'state'                => 'Hong Kong',
			'postcode'             => '',
			'country'              => 'Hong Kong SAR'
		),
		array(
			'region_name'          => __('Singapore', 'nuzest-custom'),
			'distribution_company' => 'Le Bono Collection',
			'website'              => 'http://www.nuzest.sg',
			'phone'                => '+65 9649 8436',
			'address_1'            => '629 Aljunied Road,',
			'address_2'            => 'Cititech Industrial Building #07-13',
			'city'                 => '',
			'state'                => 'Singapore',
			'postcode'             => 'S389838',
			'country'              => 'Singapore'
		),
		array(
			'region_name'          => __('United Arab Emirates', 'nuzest-custom'),
			'distribution_company' => 'The Brand Collective',
			'website'              => 'http://www.nuzest.ae',
			'phone'                => '+971 50 437 1073',
			'address_1'            => 'Office 2009, Building 2',
			'address_2'            => 'Gold and Diamond Park',
			'city'                 => 'Sheik Zayed Road',
			'state'                => 'Dubai',
			'postcode'             => '',
			'country'              => 'United Arab Emirates'
		),
		array(
			'region_name'          => __('Iceland', 'nuzest-custom'),
			'distribution_company' => 'Liam & Partnere ehf ',
			'website'              => 'http://www.nuzest.is',
			'phone'                => '+46 (0)40 693 5960',
			'address_1'            => 'Grasarimi 12',
			'address_2'            => '',
			'city'                 => 'Reykjavík',
			'state'                => '',
			'postcode'             => '112',
			'country'              => 'Iceland'
		),
		array(
			'region_name'          => __('Scandinavia', 'nuzest-custom'),
			'distribution_company' => 'Maacann Group AB',
			'website'              => 'http://www.nuzest.dk',
			'phone'                => '+46 (0)40 693 5960',
			'address_1'            => 'Fosievägen 17',
			'address_2'            => '',
			'city'                 => 'Malmo',
			'state'                => 'Skåne län',
			'postcode'             => '214 31',
			'country'              => 'Sweden'
		),
	);

	/* translators: This must match the translated region name of the region you want to be primary on the contact page  */
	//$primary_location_region = _x('Global', 'Primary region name for this region', 'nuzest-custom');
	$primary_location_region = get_field( 'region_name', 'option' );
	
	
	//extract primary location from list
	$primary_location = null;
	foreach ($locations as $key => $location) {
		if ($location['region_name'] == $primary_location_region) {
			$primary_location = array_splice($locations, $key, 1);
			$primary_location = $primary_location[0];
		}
	}

	//print out a location details block
	function print_location_details($location, $is_primary = false) {
		if ( $location['region_name']) { echo '<h4>' . __('NuZest', 'nuzest-custom') . ' ' . $location['region_name'] . '</h4>'; }
		if ( $location['distribution_company'] ) { echo '<p class="lighter">(' . $location['distribution_company'] . ')</p>'; }
		if ( $location['website'] ) { echo '<p>' . $location['website'] . '</p>';} 
		if (!$is_primary) {
			//open expanding details div
			echo '<p class="expand">' . __('Details', 'nuzest-custom') .' <span class="glyphicon glyphicon-chevron-down"></span></p>';
			echo '<div class="details">';
		}
		if ( $location['phone'] ) { echo '<p>' . __('Phone', 'nuzest-custom') . '<br><span class="lighter">' . $location['phone'] . '</span></p>'; }

		$address_lines = array();
		if ( $location['address_1'] ) { $address_lines[] = $location['address_1']; }
		if ( $location['address_2'] ) { $address_lines[] = $location['address_2']; }

		$city_lines = array();
		if ( $location['city'] ) { $city_lines[] = $location['city'] ; }
		if ( $location['state'] ) { $city_lines[] = $location['state'] ; }
		if ( $location['postcode'] ) { $city_lines[] = $location['postcode'] ; }
		if (count($city_lines)) {
			$address_lines[] = implode(', ', $city_lines);
		}

		if ( $location['country'] ) { $address_lines[] = $location['country'] ; }

		if (count($address_lines)) {
			echo '<p>' . __('Address' , 'nuzest-custom') . '<br><span class="lighter">';
			echo implode('<br>', $address_lines);
			echo '</span></p>';
		}

		if (!$is_primary) {
			//close details div
			echo '</div>';
		}
	}
?>
<section id="contact" class="fill-bg-alt text-center">
	<div class="container">
		<div class="row">
			<div class="col-md-4 primary-location">
				<?php 
				if( $primary_location ) {
					print_location_details($primary_location, true);
					if( function_exists( 'ninja_forms_display_form' ) ) { 
						echo '<a id="contactFormBtn" class="btn btn-primary">' . __('Email Us', 'nuzest-custom') . '</a>'; 
					};
				} 
				?>
			</div>
			<div class="col-md-8 secondary-location">
				<div class="row">
				<?php
				$loc_count = 0;
				foreach ($locations as $key => $location) {
					$loc_count++;
					echo '<div class="col-md-6 location">';
					print_location_details($location);
					echo '</div>'; // close column
					if ( $loc_count % 2 == 0 ) {
						echo '</div><div class="row">';
					}
				}
				?>
				</div>
			</div>
		</div>
	</div>
</section>
