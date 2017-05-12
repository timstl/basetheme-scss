<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Basetheme
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/lib/tgm-plugin-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', '_bt_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function _bt_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */

		
	$plugins = array(
		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'Gravity Forms (Manual Install Only)', // The plugin name
			'slug'     				=> 'gravityforms', // The plugin slug (typically the folder name)
			'source'   				=> 'http://www.gravityhelp.com/downloads/', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://www.gravityhelp.com/downloads/', // If set, overrides default API URL and points to an external URL
		),

		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'ACF 5.0 PRO (Manual Install Only)', // The plugin name
			'slug'     				=> 'advanced-custom-fields-pro', // The plugin slug (typically the folder name)
			'source'   				=> 'http://www.advancedcustomfields.com/my-account/', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '5.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://www.advancedcustomfields.com/my-account/', // If set, overrides default API URL and points to an external URL
		),
				
		array(
			'name' 		=> 'Page Builder  by SiteOrigin',
			'slug' 		=> 'siteorigin-panels',
			'required' 	=> false		
		),
		array(
			'name' 		=> 'SiteOrigin Widgets Bundle',
			'slug' 		=> 'so-widgets-bundle',
			'required' 	=> false		
		),
		array(
			'name' 		=> 'WordPress SEO by Yoast',
			'slug' 		=> 'wordpress-seo',
			'required' 	=> false		
		),
		array(
			'name' 		=> 'BulletProof Security',
			'slug' 		=> 'bulletproof-security',
			'required' 	=> false			
		),
		array(
			'name' 		=> 'Wordfence',
			'slug' 		=> 'wordfence',
			'required' 	=> false
		),
		array(
			'name' 		=> 'Simple 301 Redirects',
			'slug' 		=> 'simple-301-redirects',
			'required' 	=> false			
		),
		array(
			'name' 		=> 'Remove XMLRPC Pingback Ping',
			'slug' 		=> 'remove-xmlrpc-pingback-ping',
			'required' 	=> false
		)
	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'basetheme';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           => 'basetheme',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'basetheme' ),
			'menu_title'                      => __( 'Install Plugins', 'basetheme' ),
			'installing'                      => __( 'Installing Plugin: %s', 'basetheme' ),
			'updating'                        => __( 'Updating Plugin: %s', 'basetheme' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'basetheme' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'basetheme'
			),
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'basetheme'
			),
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'basetheme'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'basetheme'
			),
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'basetheme'
			),
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'basetheme'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'basetheme'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'basetheme'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'basetheme'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'basetheme' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'basetheme' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'basetheme' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'basetheme' ),
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'basetheme' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'basetheme' ),
			'dismiss'                         => __( 'Dismiss this notice', 'basetheme' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'basetheme' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'basetheme' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
			)
		);

	tgmpa( $plugins, $config );

}