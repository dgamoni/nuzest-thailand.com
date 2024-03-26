<?php
// Creating the widget
class nz_social_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'nz_social_widget',

			// Widget name will appear in UI
			__('Social Widget', 'nuzest-custom-admin'),

			// Widget description
			array( 'description' => __( 'Show social menu as widget', 'nuzest-custom-admin' ))
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = '';
		if (array_key_exists('title', $instance)) {
			apply_filters( 'widget_title', $instance['title'] );
		}
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		echo $this->social_menu();
		echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
		?>
		<p><?php echo _e('Ensure you have a menu set to the \'Social Menu\' theme location.', 'nuzest-custom-admin') ?></p>
		<p><?php echo _e('In this menu, create link items, with the \'Link Text\' set to the Font-Awesome icon name without the \'fa-\' prefix', 'nuzest-custom-admin') ?> 
			(<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank"><?php echo _e('See here for a list', 'nuzest-custom-admin') ?></a>).</p>
		<p><i><?php echo _E('E.g. for a facebook icon, the \'Link Text\' should be \'facebook\'', 'nuzest-custom-admin') ?></i></p>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		return $instance;
	}

	public function social_menu() {
		$menu_name = 'social-menu'; // specify custom menu slug
		if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
			$menu = wp_get_nav_menu_object($locations[$menu_name]);
			$menu_items = wp_get_nav_menu_items($menu->term_id);

			$menu_list = '<nav class="social-links">' ."\n";
			$menu_list .= '<ul class="list-inline">' ."\n";
			foreach ((array) $menu_items as $key => $menu_item) {
				$title = $menu_item->title;
				$url = $menu_item->url;
				$menu_list .= '<li><a target="_blank" href="'. $url .'">';
				$menu_list .= '<i class="fa fa-' . $title .'"></i>';
				$menu_list .= '</li></a>' ."\n";
			}
			$menu_list .= '</ul>' ."\n";
			$menu_list .= '</nav>' ."\n";
		} else {
			$menu_list = '<!-- no social icons list defined -->';
		}
		return $menu_list;
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'nz_social_widget' );
} );
