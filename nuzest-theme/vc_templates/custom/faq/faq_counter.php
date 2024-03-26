<?php

// FAQ Click Counter

function link_check_click_counter() {

    if (  isset( $_POST['post_id'] ) ) {
		$thispost = get_post($_POST['post_id']);
		$menu_order = $thispost->menu_order;
		$my_post = array(
			  'ID'           => $_POST['post_id'],
			  'menu_order'   => $menu_order + 1,
		);
		wp_update_post( $my_post );
        //$count = get_post_meta( $_POST['post_id'], 'link_check_click_counter', true );
        //update_post_meta( $_POST['post_id'], 'link_check_click_counter', ( $count === '' ? 1 : $count + 1 ) );
    }
    exit();
}


add_action( 'wp_footer', 'link_click' );
//add_action( 'wp_head', 'link_click' );
function link_click() {
    global $post;
    if( isset( $post->ID ) ) {
?>
    <script type="text/javascript" >
    jQuery(function ($) {
        $("#faq_content").on('click','.faq-list-item',function () {
			var toggle = $(this).hasClass('active');
			if(toggle){
				var faqId = $(this).attr('id');							  
				var ajax_options = {
					action: 'link_check_click_counter',
					ajaxurl: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
					post_id: faqId
				};
				$.post( ajax_options.ajaxurl, ajax_options);
				return false;
			}
        });
		$("#faq_content").on('click','.faq-list-item-pop',function () {
			var toggle = $(this).hasClass('active');
			if(toggle){
				var faqId = $(this).attr('id');							  
				var ajax_options = {
					action: 'link_check_click_counter',
					ajaxurl: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
					post_id: faqId
				};
				$.post( ajax_options.ajaxurl, ajax_options);
				return false;
			}
        });
    });
    </script>
<?php
    }
}

add_action( 'wp_ajax_link_check_click_counter', 'link_check_click_counter');
add_action( 'wp_ajax_nopriv_link_check_click_counter', 'link_check_click_counter' );