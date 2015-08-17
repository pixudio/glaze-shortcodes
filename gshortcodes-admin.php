<?php

if ( ! function_exists( 'hb_tinymce_init' ) ) {

	/*
	 * Register TinyMCE
	 */
    function hb_tinymce_init() {
        
        if ( ! current_user_can('edit_theme_options') ) return;        

        if ( 'true' == get_user_option('rich_editing') ) {
            
            require_once( GSHORTCODES_DIR . 'admin/shortcode-list.php' );
            require_once( GSHORTCODES_DIR . 'admin/shortcode-admin.php' );

            add_filter( 'mce_external_plugins', 'hb_tinymce_js_plugin' );
            add_filter( 'mce_buttons', 'register_hb_tinymce_button' );
        }
    }
    add_action('init', 'hb_tinymce_init');
}