<?php
/**
 * This file includes lib files with theme setup, support, shortcodes, etc.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

/**
 * Include theme files.
 * Functions and hooks should go in these files, not in functions.php.
 */

/* Setup menus, sidebars, scripts, etc. */
require get_template_directory() . '/lib/theme.setup.php';

/* Misc hooks and functions used on many WordPress sites */
require get_template_directory() . '/lib/theme.helpers.php';

/* Misc hooks and functions more specific to this site */
require get_template_directory() . '/lib/theme.functions.php';

/* Register theme shortcodes */
require get_template_directory() . '/lib/theme.shortcodes.php';
