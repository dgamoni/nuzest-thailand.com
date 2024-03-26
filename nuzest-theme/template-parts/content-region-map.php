<?php //modal map ?>


<div class="modal-dialog modal-lg" align="center">
	<div class="modal-content" align="center">
		<div class="modal-body">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><img src="<?php echo get_template_directory_uri();?>/images/nuzest-logo.png" width="100"></p>
			<h2><?php _e("CHOOSE YOUR LOCATION") ?></h2>
			<div class="region-line"></div>
			<div class="row">
				<div class="col-md-2 col-md-offset-1">
					<h4 class="continent">Americas</h4>
					<div class="countrylink" id="US"><a href="https://www.nuzest-usa.com"><span class="flag" id="flagus"></span><span class="country">USA</span></a>
					</div>
				</div>
				<div class="col-md-2">
					<h4 class="continent">Europe</h4>
					<div class="countrylink" id="UK"><a href="https://www.nuzest.co.uk"><span class="flag" id="flaguk"></span><span class="country">United Kingdom</span></a>
					</div>
					<div class="countrylink" id="CZ"><a href="https://www.nuzest.cz" id="CZ"><span class="flag" id="flagcr"></span><span class="country">Czech Republic</span></a>
					</div>
					<!--<div class="countrylink" id="IS"><a href="https://www.nuzest.is" id="IS"><span class="flag" id="flagis"></span>Iceland</a>
					</div>-->
					<div class="countrylink" id="NZ"><a href="https://www.nuzest.pl" id="NZ"><span class="flag" id="flagpl"></span><span class="country">Poland</span></a>
					</div>
					<div class="countrylink" id="NO"><a href="https://www.nuzest-scandinavia.com" id="NO"><span class="flag" id="flagsc"></span><span class="country">Scandinavia</span></a>
					</div>
				</div>
				<div class="col-md-2">
					<h4 class="continent">Asia, Russia</h4>
					<div class="countrylink" id="HK"><a href="https://www.nuzest.hk"><span class="flag" id="flaghk"></span><span class="country">Hong Kong</span></a>
					</div>
					<div class="countrylink" id="RU"><a href="https://www.nuzest.ru"><span class="flag" id="flagru"></span><span class="country">Russia</span></a>
					</div>
					<div class="countrylink" id="SG"><a href="https://www.nuzest.sg"><span class="flag" id="flagsg"></span><span class="country">Singapore</span></a>
					</div>
					<div class="countrylink" id="TH"><a href="https://www.nuzest-thailand.com"><span class="flag" id="flagth"></span><span class="country">Thailand</span></a>
					</div>
				</div>
				<div class="col-md-2">
					<h4 class="continent">Australasia</h4>
					<div class="countrylink" id="NZ"><a href="https://www.nuzest.co.nz"><span class="flag" id="flagnz"></span><span class="country">New Zealand</span></a>
					</div>
					<div class="countrylink" id="AU"><a href="https://www.nuzest.com.au"><span class="flag" id="flagau"></span><span class="country">Australia</span></a>
					</div>
				</div>
				<div class="col-md-2">
					<h4 class="continent">Middle East, Africa</h4>
					<div class="countrylink" id="AE"><a href="https://www.nuzest.ae"><span class="flag" id="flagae"></span><span class="country">United Arab Emirates</span></a>
					</div>
				</div>
			</div>
			<div class="row">
			<p><a class="stay-web-country" id="<?php echo $web_countrycode; ?>" data-dismiss="modal">Continue Visiting</a></p>
			</div>
		</div>
	</div>
</div>