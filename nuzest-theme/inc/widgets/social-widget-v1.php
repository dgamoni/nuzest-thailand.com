<?php


// Register and load the widget
function wpb_load_widget() {
	register_widget( 'nz_social_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );



// Creating the widget
class nz_social_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'nz_social_widget',

			// Widget name will appear in UI
			__('Social Widget (Depreciated)', 'nuzest-theme-admin'),

			// Widget description
			array( 'description' => __( 'Show social links (depreciated as of v3.0)', 'nuzest-theme-admin' ))
		);
	}

	// Creating widget front-end

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		echo '<p>' . $instance['description'] . '</p>';
		echo $this->social_menu();
		echo $args['after_widget'];
	}

	
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Widget Title', 'nuzest-theme-admin' );
		}
		
		if ( isset( $instance[ 'description' ] ) ) {
			$description = $instance[ 'description' ];
		}
		else {
			$description = __( 'Description [optional])', 'nuzest-theme-admin' );
		}
		// Widget admin form
	?>

	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	
	<p>
	<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>" />
	</p>
	
	<p><em><?php echo _e('You can enter your social profile links in the Social tab of the <a href="/admin.php?page=theme-options"> Theme Options Page </a>', 'nuzest-theme-admin') ?></em></p>
	<?php 
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		return $instance;
	}


	
	public function social_menu() { ?>
		
			<nav class="social-links">
				<ul class="list-inline">
					<?php if(get_option('theme_options')["twitter_url"] != ""){?>
						<li><a target="_blank" href="<?php echo get_option('theme_options')["twitter_url"]; ?>"><i class="fa fa-fa fa-twitter"></i></a></li>
					<?php } ?>
					<?php if(get_option('theme_options')["facebook_url"] != ""){?>
						<li><a target="_blank" href="<?php echo get_option('theme_options')["facebook_url"]; ?>"><i class="fa fa-fa fa-facebook"></i></a></li>
					<?php } ?>
					<?php if(get_option('theme_options')["youtube_url"] != ""){?>
						<li><a target="_blank" href="<?php echo get_option('theme_options')["youtube_url"]; ?>"><i class="fa fa-fa fa-youtube"></i></a></li>
					<?php } ?>
					<?php if(get_option('theme_options')["instagram_url"] != ""){?>
						<li><a target="_blank" href="<?php echo get_option('theme_options')["instagram_url"]; ?>"><i class="fa fa-fa fa-instagram"></i></a></li>
					<?php } ?>
					<?php if(get_option('theme_options')["pinterest_url"] != ""){?>
						<li><a target="_blank" href="<?php echo get_option('theme_options')["pinterest_url"]; ?>"><i class="fa fa-fa fa-pinterest"></i></a></li>
					<?php } ?>
					<?php if(get_option('theme_options')["linkedin_url"] != ""){?>
						<li><a target="_blank" href="<?php echo get_option('theme_options')["linkedin_url"]; ?>"><i class="fa fa-fa fa-linkedin"></i></a></li>
					<?php } ?>
					<?php if(get_option('theme_options')["gplus_url"] != ""){?>
						<li><a target="_blank" href="<?php echo get_option('theme_options')["gplus_url"]; ?>"><i class="fa fa-fa fa-google-plus"></i></a></li>
					<?php } ?>
				</ul>
			</nav>
	<?php }
}

