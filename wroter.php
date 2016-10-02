<?php
/**
 * Plugin Name: Wroter
 * Description: The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.
 * Plugin URI: https://wroter.com/
 * Author: Wroter.com
 * Version: 0.9.3
 * Author URI: https://wroter.com/
 *
 * Text Domain: wroter
 *
 * Wroter is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Wroter is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WROTER_VERSION', '0.9.3' );

define( 'WROTER__FILE__', __FILE__ );
define( 'WROTER_PLUGIN_BASE', plugin_basename( WROTER__FILE__ ) );
define( 'WROTER_URL', plugins_url( '/', WROTER__FILE__ ) );
define( 'WROTER_PATH', plugin_dir_path( WROTER__FILE__ ) );
define( 'WROTER_ASSETS_URL', WROTER_URL . 'assets/' );

add_action( 'plugins_loaded', 'wroter_load_plugin_textdomain' );

if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	add_action( 'admin_notices', 'wroter_fail_php_version' );
} else {
	require( WROTER_PATH . 'includes/plugin.php' );
}

/**
 * Load gettext translate for our text domain.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wroter_load_plugin_textdomain() {
	load_plugin_textdomain( 'wroter' );
}

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wroter_fail_php_version() {
	$message = esc_html__( 'Wroter requires PHP version 5.4+, plugin is currently NOT ACTIVE.', 'wroter' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}
