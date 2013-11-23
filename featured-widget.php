<?php
/**
 * Plugin Name: Featured Widget
 * Plugin URI: https://github.com/jaredkc/wp-featured-widget
 * Description: A basic wiget that display a title, description, button text and button Link. Intended to be styled as desired for you theme.
 * Version: 0.1
 * Author: Jared Cornwall
 * Author URI: http://jaredcornwall.com
 */

function register_jkc_featured_widget() {
	register_widget( 'JKC_Featured_Widget' );
}
add_action( 'widgets_init', 'register_jkc_featured_widget' );

class JKC_Featured_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		load_plugin_textdomain( 'jkc-featured-widget', false, basename( dirname( __FILE__ ) ) . '/languages' );

		parent::__construct(
			'featured-widget',
			'Featured Widget',
			array( 'description' => __( 'A bold callout with title, description and link.', 'gild-theme' ), )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$description = wpautop( $instance['description'] );
		$button_text = $instance['button_text'];
		$button_link = $instance['button_link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo '<h3>' . $title . '</h3>';
		if ( ! empty( $description ) )
			echo $description;
		if ( (! empty( $button_text )) && (! empty( $button_link )) )
			echo '<p><a href="' . $button_link . '"' . ' class="btn-small">' . $button_text . '</a></p>';
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		// Set defaults
		if( !isset($instance['title']) ) { $instance['title'] = ''; }
		if( !isset($instance['description']) ) { $instance['description'] = ''; }
		if( !isset($instance['button_text']) ) { $instance['button_text'] = ''; }
		if( !isset($instance['button_link']) ) { $instance['button_link'] = ''; }

		$title = $instance[ 'title' ];
		$description = $instance[ 'description' ];
		$button_text = $instance[ 'button_text' ];
		$button_link = $instance[ 'button_link' ];
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'description' ); ?>"><?php _e( 'Description:' ); ?></label>
			<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo esc_attr( $description ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'button_text' ); ?>"><?php _e( 'Button Text:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'button_link' ); ?>"><?php _e( 'Button Link:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'button_link' ); ?>" name="<?php echo $this->get_field_name( 'button_link' ); ?>" type="text" value="<?php echo esc_attr( $button_link ); ?>" />
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['button_text'] = ( ! empty( $new_instance['button_text'] ) ) ? strip_tags( $new_instance['button_text'] ) : '';
		$instance['button_link'] = ( ! empty( $new_instance['button_link'] ) ) ? strip_tags( $new_instance['button_link'] ) : '';
		return $instance;
	}

}