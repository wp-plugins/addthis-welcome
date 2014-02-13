<?php
/*
Plugin Name: AddThis Welcome Bar
Plugin URI: http://www.addthis.com
Description: The Welcome Bar from AddThis
Version: 1.2.4
Author: AddThis
Author URI: http://www.addthis.com
License: None
*/

define(ADDTHIS_WELCOME_PRODUCT_CODE, 'wpp-1.2.4');
define(ADDTHIS_WELCOME_AT_VERSION, 300);

/* Insert the bar into the template off of action 'template_redirect' */
function insert_bar() {
	require('views/page_include.php');
}

if(get_option('addthis_bar_activated') == '1') {
	global $pagenow;
	if( $pagenow != 'wp-login.php' && $pagenow != 'wp-register.php' && !is_admin() ){
		add_action('wp_footer', 'insert_bar');
	}
}


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
	add_option( "addthis_bar_activated", "0", '', 'yes' );
	add_option( "addthis_bar_initial_activate", "0", '', 'yes' );
	register_setting('addthis_bar_config_default','addthis_bar_config_default','addthis_bar_config_sanitize');
	register_setting('addthis_bar_config_advanced','addthis_bar_config_advanced');
	register_setting('addthis_bar_activated','addthis_bar_activated');
	register_setting('addthis_bar_initial_activate','addthis_bar_initial_activate');
	register_deactivation_hook( __FILE__, 'addthis_bar_deactivate' );
}
add_action('admin_init', 'init_addthis_bar_config');


/* Create the settings tab, rendering view/options.php */

	
function addthis_bar_options_page() {	
//	update_option( 'addthis_bar_initial_activate', '0' );
//	update_option( 'addthis_bar_activated', '0' );
//	wp_enqueue_style( 'common', plugins_url('css/common.css', __FILE__) );
	if(get_option('addthis_bar_initial_activate') == '0') {
		require('views/settings_welcome.php');
	
	}
	else {
		require('views/settings_general.php'); 
		if(get_option('addthis_bar_config_advanced') != '0') {
			require("views/advanced.php");
		} else {
			require("views/configurator.php");
		}
	}

}


function addthis_bar_admin_menu() {
	if (isset($_POST['option_page'])) {
		if(get_option('addthis_bar_initial_activate') == '0') {
			update_option( 'addthis_bar_initial_activate', '1' );
			update_option( 'addthis_bar_activated', '1' );
		}
	}
    $addthis_bar_options_page = add_options_page('AddThis Welcome Bar', 
            'AddThis Welcome', 
            'manage_options',
            'addthis_welcome', 
            'addthis_bar_options_page');
    add_action('admin_print_scripts-', $addthis_bar_options_page, 'addthis_bar_options_page_scripts');

    if($_SERVER['QUERY_STRING'] == 'page=addthis_welcome' || $_SERVER['QUERY_STRING'] == 'page=addthis_welcome&updated=true'
    	|| $_SERVER['QUERY_STRING'] == 'page=addthis_welcome&settings-updated=true') {
    		
    	wp_enqueue_script('addthis-widget', 'http://s7.addthis.com/js/250/addthis_widget.js', false, '1.0.0' );
	    wp_enqueue_script( 'at-welcome-extra', plugins_url('js/at-welcome-extra.js', __FILE__) );
	    wp_enqueue_script( 'lr', plugins_url('js/lr.js', __FILE__) );
	    wp_enqueue_script( 'at-modal', plugins_url('js/at-modal.js', __FILE__) );
	    wp_enqueue_script( 'gtc-tracking', plugins_url('js/gtc-tracking.js', __FILE__) );
	    wp_enqueue_script( 'service_list', plugins_url('js/service_list.js', __FILE__) );
	    wp_enqueue_script( 'jquery-miniColors', plugins_url('js/jquery.miniColors.js', __FILE__) );
	    wp_enqueue_script( 'jaml', plugins_url('js/jaml.js', __FILE__) );
	    wp_enqueue_script('at-gtc-wombat', plugins_url('js/gtc-wombat.js' , __FILE__) );
	    
	    wp_enqueue_style( 'common', plugins_url('css/common.css', __FILE__) );
	    wp_enqueue_style( 'gtc.wombat', plugins_url('css/gtc.wombat.css', __FILE__) );
	    wp_enqueue_style( 'jquery.miniColors', plugins_url('css/jquery.miniColors.css', __FILE__) );
	    
    }
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

function addthis_bar_deactivate() {
	update_option( 'addthis_bar_initial_activate', '0' );
	update_option( 'addthis_bar_activated', '0' );
	update_option( 'addthis_bar_config_advanced', '0' );
	update_option( 'addthis_bar_config_default', '{}' );
}

// check for pro user
function at_welcome_is_pro_user() {
    $isPro = false;
    $options = get_option('addthis_settings');
    $profile = $options['profile'];
    if ($profile) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://q.addthis.com/feeds/1.0/config.json?pubid=" . $profile);

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // further processing ....
        $server_output = curl_exec($ch);
        curl_close($ch);
        
        $array = json_decode($server_output);
        // check for pro user
        if (array_key_exists('_default',$array)) {
            $isPro = true;
        } else {
            $isPro = false;
        }
    }
    return $isPro;
}

?>
