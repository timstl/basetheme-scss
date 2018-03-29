<?php
/* 
	Include theme files.
	Functions and hooks should go in these files, not in functions.php.
*/

/* Setup menus, sidebars, scripts, etc. */
include(get_template_directory() . '/lib/theme.setup.php');

/* Misc hooks and functions used on many WordPress sites */
include(get_template_directory() . '/lib/theme.helpers.php');

/* Misc hooks and functions more specific to this site */
include(get_template_directory() . '/lib/theme.functions.php');

/* Register theme shortcodes */
include(get_template_directory() . '/lib/theme.shortcodes.php');