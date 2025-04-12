<?php
/**
 * Custom widgets for this theme
 *
 * @package Malawi_Bishops
 */

/**
 * Register custom widgets
 */
function malawi_bishops_register_widgets() {
	register_widget( 'Malawi_Bishops_Upcoming_Events_Widget' );
	register_widget( 'Malawi_Bishops_Dioceses_Widget' );
}
add_action( 'widgets_init', 'malawi_bishops_register_widgets' );

/**
 * Upcoming Events Widget
 */
class Malawi_Bishops_Upcoming_Events_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'malawi_bishops_upcoming_events', // Base ID
			esc_html__( 'Upcoming Events', 'malawi-bishops' ), // Name
			array( 'description' => esc_html__( 'Display upcoming events', 'malawi-bishops' ) ) // Args
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
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Upcoming Events', 'malawi-bishops' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;
		
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		
		malawi_bishops_display_upcoming_events( $number );
		
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Upcoming Events', 'malawi-bishops' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'malawi-bishops' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of events to show:', 'malawi-bishops' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
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
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 3;

		return $instance;
	}
}

/**
 * Dioceses Widget
 */
class Malawi_Bishops_Dioceses_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'malawi_bishops_dioceses', // Base ID
			esc_html__( 'Dioceses List', 'malawi-bishops' ), // Name
			array( 'description' => esc_html__( 'Display a list of all dioceses', 'malawi-bishops' ) ) // Args
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
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Dioceses', 'malawi-bishops' );
		
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		
		malawi_bishops_list_dioceses();
		
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Dioceses', 'malawi-bishops' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'malawi-bishops' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}
}
