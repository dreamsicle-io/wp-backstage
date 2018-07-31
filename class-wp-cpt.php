<?php

class WP_CPT {

	function __construct( $args = array() ) {
		
		$this->args = wp_parse_args( $args, array(
			 
		) );

	}

	public function init() {

		add_action( 'init', array( $this, 'register' ), 10 );

	}

	public function register() {

	}

}