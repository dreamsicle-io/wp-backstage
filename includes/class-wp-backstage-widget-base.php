<?php 
/**
 * WP Backstage Widget Base
 *
 * @since       2.0.0
 * @package     wp_backstage
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
 * @package     wp_backstage
 * @subpackage  includes
 */
class WP_Backstage_Widget_Base extends WP_Widget {

	public function __construct( $slug = '', $args = array() ) {
		$this->slug = $slug;
		$this->args = $args;
		parent::__construct(
			$this->slug, 
			$this->args['title'], 
			array( 
				'description' => $this->args['description'],
				'customize_selective_refresh' => true, 
			) 
		);
	}
	
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		do_action( sprintf( 'wp_backstage_widget_output_%1$s', $this->slug ), $args, $instance );
		echo $args['after_widget'];
	}
			
	public function form( $instance ) {
		do_action( sprintf( 'wp_backstage_widget_form_%1$s', $this->slug ), $instance, $this->id_base, $this->number );
	}

	public function update( $new_instance, $old_instance ) {
		return apply_filters( sprintf( 'wp_backstage_widget_save_%1$s', $this->slug ), $new_instance, $old_instance );
	}
 
}
