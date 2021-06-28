<?php
/**
 * Social Icons Widget
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */



/**
 * Adds Automobile Social Icons widget.
 *
 * @since Clean Business 0.1
 */
class clean_business_social_icons_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'clean_business_social_icons', // Base ID
			esc_html__( 'CT: Social Icons', 'clean-business' ), // Name
			array( 'description' => esc_html__( 'Use this widget to add Social Icons as a widget. ', 'clean-business' ) ) // Args
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
		$title = isset( $instance['title'] ) ? $instance['title'] : '';

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		echo clean_business_get_social_icons();

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
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		else {
			$title = '';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php esc_html_e( 'Title (optional):', 'clean-business' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p class="description"><?php printf( __( 'You can add social icons from Customizer Panel <a href="%s" target="_blank">here</a>.', 'clean-business' ), admin_url( 'customize.php?autofocus[panel]=clean_business_social_links' ) ); ?></p>
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
		return $instance;
	}

}

/**
 * Initialize Widget
 */
function clean_business_social_icons_init() {
	register_widget( 'clean_business_social_icons_widget' );
}
add_action( 'widgets_init', 'clean_business_social_icons_init' );
