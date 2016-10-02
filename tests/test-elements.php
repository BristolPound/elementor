<?php

class Wroter_Test_Elements extends WP_UnitTestCase {

	public function test_getInstance() {
		$this->assertInstanceOf( '\Wroter\Elements_Manager', Wroter\Plugin::instance()->elements_manager );
	}

	public function test_getElements() {
		$this->assertNotEmpty( Wroter\Plugin::instance()->elements_manager->get_registered_elements() );
	}

	public function test_elementMethods() {
		foreach ( \Wroter\Plugin::instance()->elements_manager->get_registered_elements() as $element ) {
			$this->assertNotEmpty( $element->get_title() );
			$this->assertNotEmpty( $element->get_type() );
			$this->assertNotEmpty( $element->get_id() );
		}
	}

	public function test_registerNUnregisterElement() {
		$return = Wroter\Plugin::instance()->elements_manager->register_element( 'Element_Not_Found' );
		$this->assertInstanceOf( '\WP_Error', $return );
		$this->assertEquals( 'element_class_name_not_exists', $return->get_error_code() );

		$return = Wroter\Plugin::instance()->elements_manager->register_element( '\Wroter\Control_Text' );
		$this->assertInstanceOf( '\WP_Error', $return );
		$this->assertEquals( 'wrong_instance_element', $return->get_error_code() );

		$element_class = '\Wroter\Element_Column';
		$element_id = 'column';

		$this->assertTrue( Wroter\Plugin::instance()->elements_manager->register_element( $element_class ) );

		$element = Wroter\Plugin::instance()->elements_manager->get_element( $element_id );
		$this->assertInstanceOf( $element_class, $element );

		$this->assertTrue( Wroter\Plugin::instance()->elements_manager->unregister_element( $element_id ) );
		$this->assertFalse( Wroter\Plugin::instance()->elements_manager->unregister_element( $element_id ) );

		$this->assertFalse( Wroter\Plugin::instance()->elements_manager->get_element( $element_id ) );

		$this->assertTrue( Wroter\Plugin::instance()->elements_manager->register_element( $element_class ) );
	}

	/**
	 * @expectedIncorrectUsage  Wroter\Element_Base::add_control
	 */
	public function test_redeclareControl() {
		$element_obj = Wroter\Plugin::instance()->elements_manager->get_element( 'section' );

		$control_id = 'test_redeclare_control';
		$element_obj->add_control( $control_id, [ 'section' => 'section_layout' ] );
		$element_obj->add_control( $control_id, [ 'section' => 'section_layout' ] );
		$element_obj->remove_control( $control_id );
	}

	public function test_controlsSelectorsData() {
		$wrapper_text = '{{WRAPPER}}';

		foreach ( Wroter\Plugin::instance()->elements_manager->get_registered_elements() as $element ) {
			foreach ( $element->get_style_controls() as $control ) {
				foreach ( $control['selectors'] as $selector => $css_property ) {
					foreach ( explode( ',', $selector ) as $item ) {
						$this->assertTrue( false !== strpos( $item, $wrapper_text ) );
					}
				}
			}
		}
	}

	public function test_controlsDefaultData() {
		foreach ( Wroter\Plugin::instance()->elements_manager->get_registered_elements() as $element ) {
			foreach ( $element->get_controls() as $control ) {
				if ( \Wroter\Controls_Manager::SELECT !== $control['type'] )
					continue;

				$error_msg = sprintf( 'Element: %s, Control: %s', $element->get_id(), $control['name'] );

				if ( empty( $control['default'] ) )
					$this->assertTrue( isset( $control['options'][''] ), $error_msg );
				else
					$this->assertArrayHasKey( $control['default'], $control['options'], $error_msg );
			}
		}
	}
}
