<?php
/**
 * Plugin Name:       Shortcodes - Advanced Shortcode Manager
 * Plugin URI:        https://beautifulplugins.com/advanced-shortcodes/
 * Description:       Advanced Shortcodes is a powerful and user-friendly WordPress plugin designed to help you manage shortcodes across your website.
 * Version:           1.1.0
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            BeautifulPlugins
 * Author URI:        https://beautifulplugins.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       advanced-shortcodes
 * Domain Path:       /languages
 *
 * @package AdvancedShortcodes
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 */

use AdvancedShortcodes\Plugin;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Autoload function.
 * This will autoload classes.
 *
 * @since 1.0.0
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Get the plugin instance.
 *
 * @since 1.0.0
 * @return Plugin
 */
function advanced_shortcodes() {
	return Plugin::create( __FILE__, '1.1.0' );
}

// Initialize the plugin.
advanced_shortcodes();
