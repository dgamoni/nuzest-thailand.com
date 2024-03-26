<?php
/**
 * Template for displaying search forms in Nuzest Theme
 *
 * @package WordPress
 * @subpackage Nuzest_Theme
 * @since Nuzest Theme 2.0
 */
?>
<div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="field-icon">
			<input type="text" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'nuzest-theme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'nuzest-theme' ); ?>">
			<button type="submit" class="btn"><span class="glyphicon glyphicon-search"></span></button>
		</div>
	</form>
</div>
