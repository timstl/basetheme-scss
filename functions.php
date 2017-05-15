<?php
/*
	Help refresh cache for stylesheet, main.js, plugins.js.
	This number is appended in basetheme_enqueue()
*/
function cache_bust() { return '050317'; }

/* 
	Include theme files.
	Functions and hooks should go in these files, not in functions.php.
*/

/* Setup menus, sidebars, scripts, etc. */
include(get_template_directory() . '/lib/theme.setup.php');

/* Bootstrap menu walker */
include(get_template_directory() . '/lib/theme.bootstrapmenu.php');

/* Register theme Custom Post Types (note: Many CPTs would actually be created by plugins.) */
include(get_template_directory() . '/lib/theme.customposttypes.php');

/* Misc hooks and functions used on many WordPress sites */
include(get_template_directory() . '/lib/theme.helpers.php');

/* Misc hooks and functions more specific to this site */
include(get_template_directory() . '/lib/theme.functions.php');

/* Register theme shortcodes */
include(get_template_directory() . '/lib/theme.shortcodes.php');

/* Siteorigin hooks */
include(get_template_directory() . '/lib/siteorigin-widgets/siteorigin.hooks.php');