<?php

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }
	$arr = explode(",", $ip, 2);
	$ip = $arr[0];
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode");

    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
		$ipinfo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=" . $ip));
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
				case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

/*// Set Country codes and terminology //*/
$user_countrycode = ip_info("Visitor", "countrycode");
$user_country = ip_info("Visitor", "country");

$url = $_SERVER[HTTP_HOST];
//$url = "www.nuzest.com.au";

$distubutors = array(
	"NZ"=>"www.nuzest.co.nz", 
	"AU"=>"www.nuzest.com.au", 
	"US"=>"www.nuzest-usa.com", 
	"UK"=>"www.nuzest.co.uk", 
	"HK"=>"www.nuzest.hk", 
	"SG"=>"www.nuzest.sg", 
	"TH"=>"www.nuzest-thailand.com", 
	"AE"=>"www.nuzest.ae", 
	"RU"=>"www.nuzest.ru", 
	"CZ"=>"www.nuzest.cz", 
	//"IS"=>"www.nuzest.is", 
	"PL"=>"www.nuzest.pl", 
	"NO"=>"www.nuzest-scandinavia.com", 
	"FI"=>"www.nuzest.fi", 
	"DK"=>"www.nuzest.dk", 
	"HO"=>"www.nuzest.com");

function people($user_countrycode){
	switch($user_countrycode){
		case "NZ": return "a New Zealand"; break;
		case "AU": return "an Australian"; break;
		case "US": return "North American"; break;
		case "UK": return "a UK & European"; break;
		case "HK": return "a Hong Kong"; break;
		case "SG": return "a Singaporean"; break;
		case "TH": return "a Thai"; break;
		case "AE": return "a Middle Eastern"; break;
		case "RU": return "a Russian"; break;
		case "CZ": return "a Czech"; break;
		//case "IS": return "an Icelandic"; break;
		case "SE": return "a Scandinavian"; break;
		case "FI": return "a Scandinavian"; break;
		case "NO": return "a Scandinavian"; break;
		case "PO": return "a Polish"; break;
	}
}

foreach($distubutors as $key => $value){
	if($url == $value){
		$web_countrycode = $key;
	}
}

foreach($distubutors as $key => $value){
	$user_countrycode = preg_replace('/\s+/', '', $user_countrycode);
	$key = preg_replace('/\s+/', '', $key);
	if($user_countrycode == $key){
		$web_country = $value;
		break;
	}
	else{
		$web_country = "false";
	}
}

/*// Display messages on page load //*/

	if(!isset($_COOKIE["nz_region_pop"])) {
		if( $user_countrycode != $web_countrycode){	
			if($web_country != "false"){
				if(!isset($_COOKIE["nz_region"])) {
				?>
					<div class="modal fade cookie_control" id="change_country" role="dialog">
						<div class="modal-dialog" align="center">
							<div class="modal-content">
								<div class="modal-body">
									<p><?php _e("It looks like you're visiting from ".$user_country.". This website doesn't ship there but we have " . people($user_countrycode) ." online store, would you like to go there instead?"); ?></p>
									<p><a class="btn btn-primary stay-web-country" id="<?php echo $web_countrycode; ?>" data-dismiss="modal"><?php _e('Stay here', 'nuzest-theme'); ?></a>
									<a class="btn btn-primary solid back-to-user-country" id="<?php echo $user_countrycode; ?>" href="http://<?php echo $web_country; ?>"><?php _e('Redirect', 'nuzest-theme'); ?></a></p>
								</div>
							</div>
						</div>
					</div>
				<?php
				}
			}
			else{
				?>

					<div class="modal fade cookie_control" id="choose_country" role="dialog">
						<?php get_template_part( 'template-parts/content', 'region-map' ); ?>
					</div>

				<?php
			}
		} 
	}



	?>	
			<div class="modal fade" id="choose_country" role="dialog">
				<?php get_template_part( 'template-parts/content', 'region-map' ); ?>
			</div>