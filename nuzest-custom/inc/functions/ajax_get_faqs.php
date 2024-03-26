<?php 

add_action( 'wp_ajax_ajax_get_faqs', 'ajax_get_faqs' );
add_action( 'wp_ajax_nopriv_ajax_get_faqs', 'ajax_get_faqs' );

function ajax_get_faqs() {

   $args = array(
      'post_type' => 'faqs',
      'post_status' => 'publish',
      'posts_per_page' => -1
   );
   $wp_query = get_posts( $args );

   $result = array();
   if( count($wp_query) ) {
      foreach ( $wp_query as $post ) {
         $result[] = array(
            'id' => $post->ID,
            'title'=> $post->post_title
         );
      }
   }

   wp_send_json($result);
   die();

}