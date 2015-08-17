<?php
/**
 * Plugin Name: Glaze Shortcodes
 * Plugin URI: http://pixudio.com
 * Description: List of Glaze theme's shortcodes.
 * Version: 1.0
 * Author: pixudio.com
 * Author URI: http://pixudio.com
 * Requires at least: 3.4
 * Text Domain: pixudio
 * License: GPL2
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
* Basic Constants 
*/

define('GSHORTCODES_DIR', plugin_dir_path(__FILE__));
define('GSHORTCODES_URL', plugin_dir_url(__FILE__));
define('GSHORTCODES_VERSION', '1.0');

require_once( GSHORTCODES_DIR . '/gshortcodes-functions.php' );
require_once( GSHORTCODES_DIR . '/gshortcodes-admin.php' );

register_deactivation_hook(__FILE__, 'hb_gshortcodes_deactivated');
register_activation_hook(__FILE__, 'hb_gshortcodes_activate');

/*
* Activation, Deactivation and Uninstall Functions
*/ 
function hb_gshortcodes_activate() {

	// :)
}

function hb_gshortcodes_deactivated() {

	// Oh ok!
}

/**
 * Init shortcodes function
 *
 * @return null
 **/
if( !function_exists('hb_gshortcodes_init') ) { 
    
    function hb_gshortcodes_init(){

        $gshortcodes = (array) hb_recognized_shortcodes();

        foreach ($gshortcodes as $shortcode) :

        	// SHORTCODENAME_shortcode
        	$function_name 			= $shortcode . '_shortcode';
        	// SHORTCODENAME_shortcode_custom
        	$function_name_custom   = $function_name . '_custom';

            if ( function_exists( $function_name_custom ) ) {

        		add_shortcode($shortcode, $function_name_custom);

            } elseif ( function_exists( $function_name ) ) {

        		add_shortcode($shortcode, $function_name);
            }

        endforeach;
    }
    add_action('init',  'hb_gshortcodes_init');
}