// JavaScript Document - not yet uploaded

jQuery(function($) {
	$(document).ready(function(){
		
		if( $('body').hasClass('woocommerce-cart')){
			$( "input[name='update_cart']" ).val('อัพเดทสินค้าในตะกร้า');
			
			$( document ).ajaxComplete(function() {
  				$( "input[name='update_cart']" ).val('อัพเดทสินค้าในตะกร้า');
			});
		}
		
		$('.footer-top form p:first').text('ใส่อีเมลของคุณเพื่อรับบทความ ความรู้ และข่าวสารล่าสุดจากนูเซสต์ ที่จะช่วยให้คุณมีชีวิตที่แข็งแรง สดใส และมีความสุข');
		$('.footer-top form input[type=email]').attr('placeholder', 'อีเมลของคุณ');
		$('.footer-top form input[type=submit]').val('ส่ง');
	});
}); 