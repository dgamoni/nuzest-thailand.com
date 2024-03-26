<?php
//// Region Select Modal - allow visitor to navigate between global sites and store a browser cookie to remember their selection ////
?>

<div class="modal fade" id="regionSelect">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-center">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close') ?></span></button>
				<h2><?php _e('Select Location', 'nuzest-custom') ?></h2>
				<p><?php _e('Please note that changing locations will reset your shopping cart and details.', 'nuzest-custom') ?></p>
			</div>
			
			<div class="modal-body">
            
            	<div class="row map-row hidden-xs">
                	<div class="col-sm-12">
                    	<?php get_template_part( 'inc/content', 'map' ); ?>
                    </div>
                </div>
                
                <div class="row map-row instructions hidden-xs">
                	<div class="col-sm-12">
                    	<p><?php _e('{ Select a region above for online shopping }', 'nuzest-custom') ?></p>
                    </div>
                </div>
                
                <h3 class="m-region visible-xs" id="e-aus"><?php _e('Australasia', 'nuzest-custom') ?><span class="quick-arrow"></span></h3>
				<div class="row region-row" id="zone-aus">
					<h3 class="hidden-xs"><?php _e('Australasia', 'nuzest-custom') ?></h3>
					<a rel="nofollow" class="col-sm-6 region" id="reg-aus" href="http://www.nuzest.com.au" title="<?php _e('Australia', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('Australia', 'nuzest-custom') ?></span><span class="lang">ENG | AUD$</span></p></a>
					<a rel="nofollow" class="col-sm-6 region" id="reg-nz" href="http://www.nuzest.co.nz" title="<?php _e('New Zealand & Pacific Islands', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('New Zealand & Pacific Islands', 'nuzest-custom') ?></span><span class="lang">ENG | NZD$</span></p></a>
				</div>
                
                <h3 class="m-region visible-xs" id="e-asia"><?php _e('Asia, India & Russia', 'nuzest-custom') ?><span class="quick-arrow"></span></h3>
				<div class="row region-row" id="zone-asia">
					<h3 class="hidden-xs"><?php _e('Asia, India & Russia', 'nuzest-custom') ?></h3>
					<a rel="nofollow" class="col-sm-6 region" id="reg-hk" href="http://www.nuzest.hk" title="<?php _e('Hong Kong', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('Hong Kong', 'nuzest-custom') ?></span><span class="lang">ENG | HKD$</span></p></a>
					<a rel="nofollow" class="col-sm-6 region" id="reg-sg" href="http://www.nuzest.sg" title="<?php _e('Singapore', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('Singapore', 'nuzest-custom') ?></span><span class="lang">ENG | SGD$</span></p></a>
                    <!--<a rel="nofollow" class="col-sm-6 region" id="reg-jp" href="http://www.nuzest.jp" title="<?php _e('Japan', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('Japan', 'nuzest-custom') ?></span><span class="lang">JP | JPY¥</span></p></a>-->
                    <!--<a rel="nofollow" class="col-md-6 region" id="reg-ru" href="http://www.nuzest.ru" title="<?php _e('Russia', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('Russia', 'nuzest-custom') ?></span><span class="lang">ENG | RUBруб</span></p></a>-->
				</div>
                
                <h3 class="m-region visible-xs" id="e-eu"><?php _e('Europe', 'nuzest-custom') ?><span class="quick-arrow"></span></h3>
                <div class="row region-row" id="zone-eu">
					<h3 class="hidden-xs"><?php _e('Europe', 'nuzest-custom') ?></h3>
					<!--<a rel="nofollow" class="col-sm-6 region" id="reg-eu" href="http://www.nuzest.eu" title="<?php _e('European Union', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('European Union', 'nuzest-custom') ?></span><span class="lang">ENG | EU€</span></p></a>-->
                    <a rel="nofollow" class="col-sm-6 region" id="reg-uk" href="http://www.nuzest.co.uk" title="<?php _e('United Kingdom', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('United Kingdom', 'nuzest-custom') ?></span><span class="lang">ENG | GBP£</span></p></a>
                    <a rel="nofollow" class="col-sm-6 region" id="reg-sc" href="http://www.nuzest.de" title="<?php _e('Scandinavia', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('Scandinavia', 'nuzest-custom') ?></span><span class="lang">ENG | DKKkr</span></p></a>
                    <a rel="nofollow" class="col-sm-6 region" id="reg-is" href="http://www.nuzest.is" title="<?php _e('Iceland', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('Iceland', 'nuzest-custom') ?></span><span class="lang">ENG | ISKkr</span></p></a>
                    <a rel="nofollow" class="col-sm-6 region" id="reg-cz" href="http://www.nuzest.cz" title="<?php _e('Czech Republic', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('Czech Republic', 'nuzest-custom') ?></span><span class="lang">CZ | CZK</span></p></a>
                    <!--<a rel="nofollow" class="col-sm-6 region" id="reg-hu" href="http://www.nuzest.hu" title="<?php _e('Hungary', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('Hungary', 'nuzest-custom') ?></span><span class="lang">ENG | HUFFt</span></p></a>-->
				</div>
                
                <h3 class="m-region visible-xs" id="e-usa"><?php _e('Americas', 'nuzest-custom') ?><span class="quick-arrow"></span></h3>
                <div class="row region-row" id="zone-usa">
					<h3 class="hidden-xs"><?php _e('Americas', 'nuzest-custom') ?></h3>
					<a rel="nofollow" class="col-sm-6 region" id="reg-usa" href="http://www.nuzest-usa.com" title="<?php _e('North America & Canada', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('North America & Canada', 'nuzest-custom') ?></span><span class="lang">ENG | USD$</span></p></a>
                    <a rel="nofollow" class="col-md-6 region" id="reg-chl" href="#" title="<?php _e('Chile', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('Chile', 'nuzest-custom') ?></span><span class="lang">ENG | USD$</span></p></a>
				</div>
                
                <h3 class="m-region visible-xs" id="e-afme"><?php _e('Middle East & Africa', 'nuzest-custom') ?><span class="quick-arrow"></span></h3>
				<div class="row region-row" id="zone-afme">
					<h3 class="hidden-xs"><?php _e('Middle East & Africa', 'nuzest-custom') ?></h3>
					<a rel="nofollow" class="col-sm-6 region" id="reg-ae" href="#" title="<?php _e('United Arab Emirates', 'nuzest-custom') ?>"><p class="flag"></p><p class="regionName"><span class="name"><?php _e('United Arab Emirates', 'nuzest-custom') ?></span><span class="lang">ENG | GBP£</span></p></a>
				</div>
				
                <div class="row global-row" id="zone-int">
                    <a rel="nofollow" class="col-sm-12 region" id="reg-int" href="http://www.nuzest.com">
                    	<p><?php _e('Or proceed to our corporate website', 'nuzest-custom') ?></p><h3><span class="flag"></span><?php _e('Nuzest Corporate', 'nuzest-custom') ?></h3><p>(<?php _e('No e-commerce', 'nuzest-custom') ?>)</p>
                    </a>
				</div>
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
//// Region Select Return Modal - welcome returning regional users ////
?>

<div class="modal fade" id="regionReturn">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-center">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close') ?></span></button>
				<h2><?php _e('Welcome back', 'nuzest-custom') ?></h2>
			</div>
			<div class="modal-body text-center">
				<p><?php printf( _e('Last time you were browsing Nuzest, it was on the %s website. <br />Would you like to go there now?', 'nuzest-custom'),'<span class="prevRegion"></span>') ?></p>
				<a class="btn btn-primary btn-confirm solid"><?php _e('Yes', 'nuzest-custom') ?></a><a class="btn btn-primary btn-reject" data-dismiss="modal"><?php _e('No thanks', 'nuzest-custom') ?></a>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->