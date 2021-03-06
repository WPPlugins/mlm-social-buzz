<?php
/*
Plugin Name: MLM Social Buzz
Description: Make sharing easy - add a MLM Social Buzz media box that scrolls with your content.
Version: 1.2.1
Text Domain: wdsb
Author: George Fourie
Author URI: http://thatmlmbeat.com/
WDP ID: 244

Copyright 2012 Incsub (http://thatmlmbeat.com/)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307  USA
*/

///////////////////////////////////////////////////////////////////////////
/* -------------------- Update Notifications Notice -------------------- */
/*if ( !function_exists( 'wdp_un_check' ) ) {
	add_action( 'admin_notices', 'wdp_un_check', 5 );
	add_action( 'network_admin_notices', 'wdp_un_check', 5 );
	function wdp_un_check() {
		if ( !class_exists( 'WPMUDEV_Update_Notifications' ) && current_user_can( 'install_plugins' ) )
			echo '<div class="error fade"><p>' . __('Please install the latest version of <a href="http://premium.wpmudev.org/project/update-notifications/" title="Download Now &raquo;">our free Update Notifications plugin</a> which helps you stay up-to-date with the most stable, secure versions of WPMU DEV themes and plugins. <a href="http://premium.wpmudev.org/wpmu-dev/update-notifications-plugin-information/">More information &raquo;</a>', 'wpmudev') . '</a></p></div>';
	}
}*/
/* --------------------------------------------------------------------- */

if( defined('WDSB_PLUGIN_SELF_DIRNAME') ){
	wp_die(__('Please uninstall Floating Social plugin because it conflicts with MLM Social Buzz plugin.'));
}

define ('WDSB_PROTOCOL', (@$_SERVER["HTTPS"] == 'on' ? 'https://' : 'http://'), true);
define ('WDSB_PLUGIN_SELF_DIRNAME', basename(dirname(__FILE__)), true);

//Setup proper paths/URLs and load text domains
if (is_multisite() && defined('WPMU_PLUGIN_URL') && defined('WPMU_PLUGIN_DIR') && file_exists(WPMU_PLUGIN_DIR . '/' . basename(__FILE__))) {
	define ('WDSB_PLUGIN_LOCATION', 'mu-plugins', true);
	define ('WDSB_PLUGIN_BASE_DIR', WPMU_PLUGIN_DIR, true);
	define ('WDSB_PLUGIN_URL', str_replace('http://', WDSB_PROTOCOL, WPMU_PLUGIN_URL), true);
	$textdomain_handler = 'load_muplugin_textdomain';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . WDSB_PLUGIN_SELF_DIRNAME . '/' . basename(__FILE__))) {
	define ('WDSB_PLUGIN_LOCATION', 'subfolder-plugins', true);
	define ('WDSB_PLUGIN_BASE_DIR', WP_PLUGIN_DIR . '/' . WDSB_PLUGIN_SELF_DIRNAME, true);
	define ('WDSB_PLUGIN_URL', str_replace('http://', WDSB_PROTOCOL, WP_PLUGIN_URL) . '/' . WDSB_PLUGIN_SELF_DIRNAME, true);
	$textdomain_handler = 'load_plugin_textdomain';
} else if (defined('WP_PLUGIN_URL') && defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . basename(__FILE__))) {
	define ('WDSB_PLUGIN_LOCATION', 'plugins', true);
	define ('WDSB_PLUGIN_BASE_DIR', WP_PLUGIN_DIR, true);
	define ('WDSB_PLUGIN_URL', str_replace('http://', WDSB_PROTOCOL, WP_PLUGIN_URL), true);
	$textdomain_handler = 'load_plugin_textdomain';
} else {
	// No textdomain is loaded because we can't determine the plugin location.
	// No point in trying to add textdomain to string and/or localizing it.
	wp_die(__('There was an issue determining where MLM Social Buzz plugin is installed. Please reinstall.'));
}
require_once WDSB_PLUGIN_BASE_DIR . '/top-blog-posts.php';
//require_once WDSB_PLUGIN_BASE_DIR . '/pinterest-pin-it-button.php';
$textdomain_handler('wdsb', false, WDSB_PLUGIN_SELF_DIRNAME . '/languages/');

require_once WDSB_PLUGIN_BASE_DIR . '/lib/class_wdsb_options.php';
require_once WDSB_PLUGIN_BASE_DIR . '/lib/functions.php';

if (is_admin()) {
	require_once WDSB_PLUGIN_BASE_DIR . '/lib/class_wdsb_admin_form_renderer.php';
	require_once WDSB_PLUGIN_BASE_DIR . '/lib/class_wdsb_admin_pages.php';
	Wdsb_AdminPages::serve();
} else {
	if(!isset($_POST["thatmlmbeat_get_voting_post"])){
		require_once WDSB_PLUGIN_BASE_DIR . '/lib/class_wdsb_public_pages.php';
		Wdsb_PublicPages::serve();
	}
}
?>