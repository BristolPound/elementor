<?php

class Wroter_Test_Controls extends WP_UnitTestCase {

	public function test_getInstance() {
		$this->assertInstanceOf( '\Wroter\Controls_Manager', Wroter\Plugin::instance()->controls_manager );
	}

	public function test_getControls() {
		$this->assertNotEmpty( Wroter\Plugin::instance()->controls_manager->get_controls() );
	}

	public function test_renderControls() {
		ob_start();
		Wroter\Plugin::instance()->controls_manager->render_controls();
		$this->assertNotEmpty( ob_get_clean() );
	}

	public function test_enqueueControlScripts() {
		ob_start();
		Wroter\Plugin::instance()->controls_manager->enqueue_control_scripts();
		$this->assertEmpty( ob_get_clean() );
	}

	public function test_getTypes() {
		foreach ( Wroter\Plugin::instance()->controls_manager->get_controls() as $control ) {
			$this->assertNotEmpty( $control->get_type() );
		}
	}

	public function test_registerNUnregisterControl() {
		$return = Wroter\Plugin::instance()->controls_manager->register_control( 'test_control', 'Control_Text_Not_Found' );
		$this->assertInstanceOf( '\WP_Error', $return );
		$this->assertEquals( 'element_class_name_not_exists', $return->get_error_code() );

		$return = Wroter\Plugin::instance()->controls_manager->register_control( 'test_control', '\Wroter\DB' );
		$this->assertInstanceOf( '\WP_Error', $return );
		$this->assertEquals( 'wrong_instance_control', $return->get_error_code() );

		$control_class = '\Wroter\Control_Text';
		$control_id = 'text';

		$this->assertTrue( Wroter\Plugin::instance()->controls_manager->register_control( $control_id, $control_class ) );

		$control = Wroter\Plugin::instance()->controls_manager->get_control( $control_id );
		$this->assertInstanceOf( $control_class, $control );

		$this->assertTrue( Wroter\Plugin::instance()->controls_manager->unregister_control( $control_id ) );
		$this->assertFalse( Wroter\Plugin::instance()->controls_manager->unregister_control( $control_id ) );

		// Return the control for next tests..
		$this->assertTrue( Wroter\Plugin::instance()->controls_manager->register_control( $control_id, $control_class ) );
	}

	public function test_groupControlsGetTypes() {
		foreach ( Wroter\Plugin::instance()->controls_manager->get_group_controls() as $group_control ) {
			$this->assertNotEmpty( $group_control->get_type() );
		}
	}

	public function test_replaceStyleValues() {
		$text_control = Wroter\Plugin::instance()->controls_manager->get_control( 'text' );

		$this->assertEquals(
			'10px;',
			$text_control->get_replace_style_values(
				'{{VALUE}};',
				'10px'
			)
		);

		$dimensions_control = Wroter\Plugin::instance()->controls_manager->get_control( 'dimensions' );
		$this->assertEquals(
			'1px 2px 3px 4px;',
			$dimensions_control->get_replace_style_values(
				'{{TOP}} {{RIGHT}} {{BOTTOM}} {{LEFT}};',
				[
					'top' => '1px',
					'right' => '2px',
					'bottom' => '3px',
					'left' => '4px',
				]
			)
		);
	}

	public function test_checkCondition() {
		$element_obj = Wroter\Plugin::instance()->widgets_manager->get_widget( 'text-editor' );

		$this->assertTrue( $element_obj->is_control_visible( [], [] ) );
		
		$instance = [
			'control_1' => 'value',
		];
		$control_option = [
			'name' => 'control_2',
			'condition' => [
				'control_1' => 'value1',
			],
		];

		$this->assertFalse( $element_obj->is_control_visible( $instance, $control_option) );

		$control_option = [
			'name' => 'control_2',
			'condition' => [
				'control_1' => 'value',
			],
		];

		$this->assertTrue( $element_obj->is_control_visible( $instance, $control_option) );

		$control_option = [
			'name' => 'control_2',
			'condition' => [
				'control_1!' => 'value',
			],
		];
		$this->assertFalse( $element_obj->is_control_visible( $instance, $control_option) );
	}

	public function test_getDefaultValue() {
		// Text Control
		$text_control = Wroter\Plugin::instance()->controls_manager->get_control( \Wroter\Controls_Manager::TEXT );
		
		$control_option = [
			'name' => 'key',
			'default' => 'value',
		];
		$this->assertEquals( 'value', $text_control->get_value( $control_option, [] ) );
		
		// URL Control
		$url_control = Wroter\Plugin::instance()->controls_manager->get_control( \Wroter\Controls_Manager::URL );
		$control_option = [
			'name' => 'key',
			'default' => [
				'url' => 'THE_LINK',
			],
		];
		$this->assertEquals( [ 'url' => 'THE_LINK', 'is_external' => '' ], $url_control->get_value( $control_option, [ 'key' => [ 'is_external' => '' ] ] ) );
		
		// Repeater Control
		$repeater_control = \Wroter\Plugin::instance()->controls_manager->get_control( \Wroter\Controls_Manager::REPEATER );
		$control_option = [
			'name' => 'key',
			'default' => [ [] ],
			'fields' => [
				[
					'name' => 'one',
					'type' => \Wroter\Controls_Manager::TEXT,
					'default' => 'value',
				],
			],
		];

		$expected = [
			[
				'one' => 'value',
			]
		];
		$this->assertEquals( $expected, $repeater_control->get_value( $control_option, [ [] ] ) );
	}
}
