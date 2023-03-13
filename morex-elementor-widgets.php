<?php

/**
 * Plugin Name: Morex Elementor Widgets
 * Plugin URI: https://maxjn.ir/plugins/morex-elementor-widgets.zip
 * Author: Morex
 * Author URI: https://www.rtl-theme.com/author/maxjn/products/
 * Description: Elementor Widgets For Morex Template
 * Version: 1.0.0
 * License: 1.0.0
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: morex-elementor-widgets
 * Domain Path: /languages
 */
// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Plugin Functions
 *
 * @package Morex Widget Plugin
 */
if (!defined('MOREX_WIDGET')) {
    define('MOREX_WIDGET', untrailingslashit(__DIR__) . '/inc/classes/widgets/');
}

if (!defined('MOREX_PLUGIN_DIR_PATH')) {
    define('MOREX_PLUGIN_DIR_PATH', untrailingslashit(__DIR__));
}
if (!defined('MOREX_PLUGIN_CSS_PATH')) {
    define('MOREX_PLUGIN_CSS_PATH', plugin_dir_url(__FILE__) . 'assets/css');
}
/**
 * Load Text Domain
 *
 * @package Morex Widget Plugin
 */
load_plugin_textdomain('morex-elementor-widgets', false, dirname(plugin_basename(__FILE__)) . '/languages');


require_once __DIR__ . '/inc/Helpers/autoloader.php';
require_once __DIR__ . '/inc/Helpers/plugin-tags.php';

function morex_get_plugin_instance()
{
    \MOREX_PLUGIN\Inc\MOREX_PLUGIN_INIT::get_instance();
}

morex_get_plugin_instance();
