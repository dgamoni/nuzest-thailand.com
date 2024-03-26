<?php
/**
 * YIKES Inc. MailChimp Template: Nuzest Widget Template
 * MailChimp Template Author: Nuzest
 * MailChimp Template Description: Nuzest Widget Template
	Developer Notes : 
		DO NOT remove the $this->getFrontendFormDisplay($list, $submit_text) call. This is what generates all of your input forms based on MailChimp data.
		Also, refrain from removing or altering any of the existing ID attributes as they are referenced by the JavaScript
	
 */
 
	// enqueue the associated styles for this template
	// found in the same directory, inside of the styles folder
	wp_enqueue_style( 'nz_mc_widget_css' , get_stylesheet_directory_uri() . '/yikes-mailchimp-user-templates/Nuzest_Widget/nz_mc_widget.css' );
 
?>

<!-- Form Template -->
<div class="yks-mailchimpFormContainerInner nz_mc_widget" id="yks-mailchimpFormContainerInner_<?php echo $list['id']; ?>">	
	
	<div id="row">
    	<div id="col-xs-12">

			<form method="post" name="yks-mailchimp-form" id="yks-mailchimp-form_<?php echo $list['id']; ?>" class="yiks-mailchimp-custom-form" rel="<?php echo $list['id']; ?>">
				<input type="hidden" name="yks-mailchimp-list-ct" id="yks-mailchimp-list-ct_<?php echo $list['id']; ?>" value="<?php echo $listCt; ?>" />
				<input type="hidden" name="yks-mailchimp-list-id" id="yks-mailchimp-list-id_<?php echo $list['id']; ?>" value="<?php echo $list['list-id']; ?>" />
					<?php 
						/* Generate The Form Fields **/
						echo $this->getFrontendFormDisplay($list, $submit_text); 
					?>
			</form>
				
		</div>
	</div>
	
</div>