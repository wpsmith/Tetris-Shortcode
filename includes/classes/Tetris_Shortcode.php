<?php

class Tetris_Shortcode {

	public $debug = false;
	public $scripts_registered = false;
	public $scripts_enqueued = false;

	public function __construct() {
		add_shortcode( 'tetris', array( $this, 'shortcode' ) );
		$this->debug = ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) );

		// Hookup!
		$this->add_do_action( 'init', 'register_scripts', 11 );
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
			'jgestures',
			plugins_url( "js/jgestures$suffix", TETRIS_FILE ),
			array( 'jquery', ),
			filemtime( plugin_dir_path( TETRIS_FILE ) . "js/jgestures$suffix" ),
			false
		);

		wp_register_script(
			'blockrain',
			plugins_url( "js/jquery.blockrain$suffix", TETRIS_FILE ),
			array( 'jquery', 'jquery-ui-widget', 'jgestures', ),
			filemtime( plugin_dir_path( TETRIS_FILE ) . "js/jquery.blockrain$suffix" ),
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

	/**
	 * Returns the HTML markup for the shortcode.
	 *
	 * @param array       $atts Array of attributes (height, width).
	 * @param string $content Content string. N/A.
	 *
	 * @return string HTML markup.
	 */
	public function shortcode( $atts, $content = '' ) {
		// Parse the attributes with defaults
		$atts = shortcode_atts( array(
			'height' => '100%',
			'width'  => '100%'
		), $atts, 'tetris' );

		// Output the script
		$this->enqueue_scripts();

		// Return the simple markup
		return sprintf( '<div class="tetris-game" style="max-width:%s; max-height:%s;"></div>', $atts['width'], $atts['height'] );
	}

	/**
	 * Hooks a function on to a specific action or calls the function callback if action already completed or in
	 * process.
	 *
	 *
	 * @param string     $tag           The name of the action to which the $function_to_add is hooked.
	 * @param callback   $function      The name of the function you wish to be called.
	 * @param int        $priority      Optional. Used to specify the order in which the functions
	 *                                  associated with a particular action are executed. Default 10.
	 *                                  Lower numbers correspond with earlier execution,
	 *                                  and functions with the same priority are executed
	 *                                  in the order in which they were added to the action.
	 * @param int        $accepted_args Optional. The number of arguments the function accepts. Default 1.
	 * @param bool|false $debug         Optional. The number of arguments the function accepts. Default 1.
	 *
	 * @return WP_Error
	 */
	public function add_do_action( $tag, $function, $priority = 10, $accepted_args = 1, $debug = false ) {
		if ( ( did_action( $tag ) || doing_filter( $tag ) ) && is_callable( $function ) ) {
			call_user_func( $function );
		} elseif ( is_callable( $function ) ) {
			add_action( $tag, $function, $priority, $accepted_args );
		} elseif ( $debug ) {
			return new WP_Error( 'invalid-function', __( 'Function is not callable', 'wps' ), array(
				$tag,
				$function,
				$priority,
				$accepted_args
			) );
		}

		return true;
	}

}