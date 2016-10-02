<?php

class Wroter_Test_Base extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();

		wp_set_current_user( $this->factory->user->create( [ 'role' => 'administrator' ] ) );

		// Fake behavior
		if ( ! defined( 'WP_ADMIN' ) ) {
			define( 'WP_ADMIN', true );
		}
		
		add_filter( 'wroter/utils/is_development_mode', '__return_true' );

		// Make sure the main class is running
		\Wroter\Plugin::instance();

		// Run fake actions
		do_action( 'init' );
		do_action( 'plugins_loaded' );
	}

	public function test_plugin_activated() {
		$this->assertTrue( is_plugin_active( PLUGIN_PATH ) );
	}

	public function test_getInstance() {
		$this->assertInstanceOf( '\Wroter\Plugin', \Wroter\Plugin::instance() );
	}

	public function test_getVersion() {
		$this->assertEquals( WROTER_VERSION, \Wroter\Plugin::instance()->get_version() );
	}

	/**
	 * @expectedIncorrectUsage __clone
	 */
	public function test_Clone() {
		$obj_cloned = clone \Wroter\Plugin::instance();
	}

	/**
	 * @expectedIncorrectUsage __wakeup
	 */
	public function test_Wakeup() {
		unserialize( serialize( \Wroter\Plugin::instance() ) );
	}
}
