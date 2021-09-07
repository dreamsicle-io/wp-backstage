<?php 

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
		do_action( sprintf( 'wp_backstage_widget_output_%1$s', $this->slug ), $args, $instance );
	}
			
	public function form( $instance ) {
		do_action( sprintf( 'wp_backstage_widget_form_%1$s', $this->slug ), $instance, $this->id_base, $this->number );
	}

	public function update( $new_instance, $old_instance ) {
		return apply_filters( sprintf( 'wp_backstage_widget_save_%1$s', $this->slug ), $new_instance, $old_instance );
	}
 
}
