<?php

/*
Plugin Name: {{plugin_name}}
Plugin URI: http://wordpress.org/
Description: Enter description here.
Author: {{plugin_author}}
Version: 0.0.1
Author URI: {{plugin_author_uri}}
License: GPL3
{{#modules.git}}
Github Repository: {{modules.git.github_repo}}
GitHub Plugin URI: {{modules.git.github_repo}}
Release Asset: true
{{/modules.git}}
Text Domain: {{wp_plugin_slug}}
Domain Path: /languages/
*/

/*  Copyright {{this_year}} {{plugin_author}}

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
Plugin was generated by WP Plugin Scaffold
https://github.com/mcguffin/wp-plugin-scaffold
Command line args were: `{{{shell_args}}}`
*/


namespace {{plugin_namespace}};

if ( ! defined('ABSPATH') ) {
	die('FU!');
}


define( '{{plugin_slug_upper}}_FILE', __FILE__ );
define( '{{plugin_slug_upper}}_DIRECTORY', plugin_dir_path(__FILE__) );
define( '{{plugin_slug_upper}}_PLUGIN', pathinfo( {{plugin_slug_upper}}_DIRECTORY, PATHINFO_FILENAME ) . '/' . pathinfo( __FILE__, PATHINFO_BASENAME ) );

require_once {{plugin_slug_upper}}_DIRECTORY . 'include/autoload.php';

Core\Core::instance();

{{#modules.model.items}}
Model\Model{{module.classname}}::instance();
{{/modules.model.items}}


{{#modules.posttype.items}}
PostType\PostType{{module.classname}}::instance();
{{/modules.posttype.items}}

{{#modules.taxonomy.items}}
Taxonomy\Taxonomy{{module.classname}}::instance();
{{/modules.taxonomy.items}}

{{#modules.shortcode.items}}
Shortcode\Shortcode{{module.classname}}::instance();
{{/modules.shortcode.items}}

{{#modules.widget}}
Widget\Widgets::instance();
{{/modules.widget}}

{{#modules.wprest}}
WPRest\WPRest::instance();
{{/modules.wprest}}

if ( is_admin() || defined( 'DOING_AJAX' ) ) {

{{#modules.autoupdate}}
	// don't WP-Update actual repos!
	if ( ! file_exists( {{plugin_slug_upper}}_DIRECTORY . '/.git/' ) ) {

		// Not a git. Check if https://github.com/afragen/github-updater is active
		$active_plugins = get_option('active_plugins');
		if ( $sitewide_plugins = get_site_option('active_sitewide_plugins') ) {
			$active_plugins = array_merge( $active_plugins, array_keys( $sitewide_plugins ) );
		}

		if ( ! in_array( 'github-updater/github-updater.php', $active_plugins ) ) {
			// not github updater. Init our our own...
			AutoUpdate\AutoUpdateGithub::instance()->init( __FILE__ );
		}
	}
{{/modules.autoupdate}}

{{#modules.admin}}
	Admin\Admin::instance();
{{/modules.admin}}

{{#modules.admin_page.items}}
	Admin\AdminPage{{module.classname}}::instance();
{{/modules.admin_page.items}}

{{#modules.settings.items}}
	Settings\Settings{{module.classname}}::instance();
{{/modules.settings.items}}

}

{{#modules.wpcli}}
if ( defined( 'WP_CLI' ) && WP_CLI ) {
{{#modules.wpcli.items}}
	WPCLI\WPCLI{{module.classname}}::instance();
{{/modules.wpcli.items}}
}
{{/modules.wpcli}}
