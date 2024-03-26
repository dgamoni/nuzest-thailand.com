<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="field-icon">
		<!-- <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ) ?></span> -->
		<input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
		<button type="submit" class="btn"><span class="glyphicon glyphicon-search"></span></button>
	</div>
</form>