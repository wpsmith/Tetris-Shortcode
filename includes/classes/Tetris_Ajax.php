<?php

class Tetris_Ajax {

	public $debug = false;
	public $scripts_registered = false;
	public $scripts_enqueued = false;

	public function __construct() {


	}

	/**
	 * Register the scripts
	 *
	 * @uses wp_register_script
	 * @uses wp_localize_script
	 */
	public function register_scripts() {
		if ( $this->scripts_registered ) {
			return;
		}

		/* SCRIPTS */
		$suffix = $this->debug ? '.js' : '.min.js';
		wp_register_script(
			'blockrain',
			plugins_url( "js/blockrain.jquery$suffix", TETRIS_FILE ),
			array( 'jquery', ),
			filemtime( plugin_dir_path( TETRIS_FILE ) . "js/blockrain.jquery$suffix" ),
			false
		);
		wp_register_script(
			'blockrain-init',
			plugins_url( "js/blockrain.init$suffix", TETRIS_FILE ),
			array( 'blockrain', ),
			filemtime( plugin_dir_path( TETRIS_FILE ) . "js/blockrain.init$suffix" ),
			false
		);

		$args = array(
			'playText'          => __( 'Let\'s play some Tetris', TETRIS_SLUG ),
			'playButtonText'    => __( 'Play', TETRIS_SLUG ),
			'gameOverText'      => __( 'Game Over', TETRIS_SLUG ),
			'restartButtonText' => __( 'Play Again', TETRIS_SLUG ),
			'scoreText'         => __( 'Score', TETRIS_SLUG ),
		);
		wp_localize_script( 'blockrain-init', 'blockrainI10n', $args );


		/* STYLES */
		$suffix = $this->debug ? '.css' : '.min.css';
		wp_register_style(
			'blockrain',
			plugins_url( "css/blockrain$suffix", TETRIS_FILE ),
			null,
			filemtime( plugin_dir_path( TETRIS_FILE ) . "css/blockrain$suffix" )
		);

	}

	/**
	 * Output the scripts for WordPress
	 *
	 * @uses wp_enqueue_script
	 */
	public function enqueue_scripts() {
		if ( $this->scripts_enqueued ) {
			return;
		}
		// Ensure scripts are registered
		$this->register_scripts();

		/* SCRIPTS */
		wp_enqueue_script( 'blockrain-init' );

		/* STYLES */
		wp_enqueue_style( 'blockrain' );

		// Prevent redundant calls
		$this->scripts_enqueued = true;
	}


}