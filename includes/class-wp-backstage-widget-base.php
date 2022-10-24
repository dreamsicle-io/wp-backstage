<?php
/**
 * WP Backstage Widget Base
 *
 * @since       2.0.0
 * @since       3.0.0  linted and formatted with phpcs
 * @package     wp-backstage
 * @subpackage  includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Backstage Widget Base
 *
 * Sets up a global widget that all WP Backstage widgets use as their base by
 * adding hooks and filters for the form, the output, and saving of instances.
 *
 * @since       2.0.0
 * @since       2.2.0  Added `before_widget` and `after_widget` args to `widget` method.
 * @package     wp-backstage
 * @subpackage  includes
 */
class WP_Backstage_Widget_Base extends WP_Widget {

	/**
	 * Construct
	 *
	 * Constructs the widget and calls the parent widgets constructor.
	 *
	 * @since 2.0.0
	 * @param string $slug The widget's slug.
	 * @param array  $args The widget's args.
	 * @return void
	 */
	public function __construct( $slug = '', $args = array() ) {

		$this->slug = $slug;
		$this->args = $args;

		parent::__construct(
			$this->slug,
			$this->args['title'],
			array(
				'description'                 => $this->args['description'],
				'customize_selective_refresh' => true,
			)
		);
	}

	/**
	 * Widget
	 *
	 * This is the function that renders the "front end" of the widget. It
	 * outputs the `before_widget` and `after_widget` args, and adds an action
	 * for the developer to render the front end. This allows for this class
	 * to be used for all WP Backstage widgets.
	 *
	 * @since  2.0.0
	 * @param  array $args      The arguments of the widget as configured when registering the widget area.
	 * @param  array $instance  The stored settings of this widget instance.
	 */
	public function widget( $args, $instance ) {

		// phpcs:ignore WordPress.Security.EscapeOutput
		echo $args['before_widget'];

		do_action( "wp_backstage_widget_output_{$this->slug}", $args, $instance );

		// phpcs:ignore WordPress.Security.EscapeOutput
		echo $args['after_widget'];
	}

	/**
	 * Form
	 *
	 * This is the function that renders the "back end" of the widget. It adds an action
	 * for WP Backstage to render the form fields. This allows for this class
	 * to be used for all WP Backstage widgets.
	 *
	 * @since  2.0.0
	 * @param  array $instance  The stored settings of this widget instance.
	 */
	public function form( $instance ) {
		do_action( "wp_backstage_widget_form_{$this->slug}", $instance, $this->id_base, $this->number );
	}

	/**
	 * Update
	 *
	 * This is the function that saves the instance of the widget. It adds a filter
	 * for WP Backstage to save the form fields, passing the new instance and old instance.
	 * This allows for this class to be used for all WP Backstage widgets.
	 *
	 * @since  2.0.0
	 * @param  array $new_instance  The new settings to store.
	 * @param  array $old_instance  The currentylu stored settings.
	 */
	public function update( $new_instance, $old_instance ) {
		return apply_filters( "wp_backstage_widget_save_{$this->slug}", $new_instance, $old_instance );
	}

}
