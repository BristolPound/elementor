<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Maintenance {

	public static function activation() {
		wp_clear_scheduled_hook( 'wroter/tracker/send_event' );

		wp_schedule_event( time(), 'daily', 'wroter/tracker/send_event' );
		flush_rewrite_rules();
	}

	public static function uninstall() {
		wp_clear_scheduled_hook( 'wroter/tracker/send_event' );
	}

	public static function init() {
		register_activation_hook( WROTER_PLUGIN_BASE, [ __CLASS__, 'activation' ] );
		register_uninstall_hook( WROTER_PLUGIN_BASE, [ __CLASS__, 'uninstall' ] );
	}
}

Maintenance::init();
