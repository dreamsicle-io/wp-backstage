<?php

class WP_CPT {

	function __construct( $args = array() ) {
		
		$this->args = wp_parse_args( $args, array(
			 
		) );

	}

	public static function add( $args = array() ) {

		$CPT = new WP_CPT( $args );

		$CPT->init();

	}

	public function init() {

		add_action( 'init', array( $this, 'register' ), 10 );

	}

	private function register() {

	}

}