<?php
/**
 * Plugin Name: Tetris
 * Plugin URI: http://wpsmith.net
 * Description: Adds tetris game shortcode.
 * Version: 0.0.1
 * Author: Travis Smith, WP Smith
 * Author URI: http://wpsmith.net
 * Text Domain: tetris
 *
 * @copyright 2015
 * @author Travis Smith
 * @link http://wpsmith.net/
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

/**
 * Core Plugin File
 *
 * @package      Tetris
 * @author       Travis Smith <t@wpsmith.net>
 * @copyright    Copyright (c) 2015, Travis Smith
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'TETRIS_VERSION', '0.0.1' );
define( 'TETRIS_SLUG', 'tetris' );
define( 'TETRIS_FILE', __FILE__ );

spl_autoload_register( 'tetris_autoload' );
/**
 *  SPL Class Autoloader for classes.
 *
 *  @param string $class_name Class name being autoloaded.
 *  @link http://us1.php.net/spl_autoload_register
 *  @author	Travis Smith
 *  @since 0.1.0
 */
function tetris_autoload( $class_name ) {

	// Do nothing if class already exists, not prefixed WPS_
	if ( class_exists( $class_name, false ) ||
	     ( !class_exists( $class_name, false ) && false === strpos( $class_name, 'Tetris_' ) ) ) {
		return;
	}

	// Set file
	$file = plugin_dir_path( __FILE__ ) . "includes/classes/$class_name.php";

	// Load file
	if ( file_exists( $file ) ) {
		include_once( $file );
	}

}

/*----------------------------------------------------------------------------*
 * Global Functionality
 *----------------------------------------------------------------------------*/

//require_once( plugin_dir_path( __FILE__ ) . 'includes/functions.php' );
//require_once( plugin_dir_path( __FILE__ ) . 'includes/classes/Tetris_Shortcode.php' );

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

new Tetris_Shortcode();

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
//register_activation_hook( __FILE__, array( 'Tetris_Core', 'activate' ) );
//register_deactivation_hook( __FILE__, array( 'Tetris_Core', 'deactivate' ) );
//
//// Load plugin at plugins_loaded hook
//add_action( 'plugins_loaded', array( 'Tetris_Core', 'get_instance' ) );

