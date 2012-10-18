<?php
/*
Plugin Name: AddThis Welcome Bar
Plugin URI: http://www.addthis.com
Description: The Welcome Bar from AddThis
Version: 1.1
Author: AddThis
Author URI: http://www.addthis.com
License: None
*/

/* Insert the bar into the template off of action 'template_redirect' */
function insert_bar() {
	require('views/page_include.php');	
}


	add_action('wp_head', 'insert_bar');


/* Create the config preset on activate, remove it on deactivate */

function addthis_bar_config_sanitize($input) {
	
	if(preg_match('/function/', $input)) {
		$input = '{ error: \'For security purposes, no use of the word "function" is permitted in the Wordpress Welcome Bar. Sorry.\' }';
	}
	return $input;	
}

function init_addthis_bar_config() {
	add_option("addthis_bar_config_default","{}",'','yes');
	add_option("addthis_bar_config_advanced","0",'','yes');
	register_setting('addthis_bar_config_default','addthis_bar_config_default','addthis_bar_config_sanitize');
	register_setting('addthis_bar_config_advanced','addthis_bar_config_advanced');
}
add_action('admin_init', 'init_addthis_bar_config');


/* Create the settings tab, rendering view/options.php */

	
function addthis_bar_options_page() {	

		
		require('views/settings_general.php'); 
		if(get_option('addthis_bar_config_advanced') != '0') {
			require("views/advanced.php");
		} else {
			require("views/configurator.php");
		}

}



function addthis_bar_admin_menu() {

    $addthis_bar_options_page = add_options_page('AddThis Welcome Bar', 
            'AddThis Welcome', 
            'manage_options',
            'addthis_welcome', 
            'addthis_bar_options_page');
    add_action('admin_print_scripts-', $addthis_bar_options_page, 'addthis_bar_options_page_scripts');
}
add_action('admin_menu','addthis_bar_admin_menu');
	
	


// Setup our shared resources early
add_action('init', 'addthis_bar_early', 1);
function addthis_bar_early(){
    global $addthis_addjs;
    if (! isset($addthis_addjs)){
        require('views/includes/addthis_addjs.php');
        $addthis_options = get_option('addthis_settings');
        $addthis_addjs = new AddThis_addjs($addthis_options);
    } elseif (! method_exists( $addthis_addjs, 'getAtPluginPromoText')){
        require('views/includes/addthis_addjs_extender.php');
        $addthis_addjs = new AddThis_addjs_extender($addthis_options);
    }
}

?>
