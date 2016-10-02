<?php

class Wroter_Test_Widgets extends WP_UnitTestCase {

	public function test_getInstance() {
		$this->assertInstanceOf( '\Wroter\Widgets_Manager', Wroter\Plugin::instance()->widgets_manager );
	}

	public function test_getWidgets() {
		$this->assertNotEmpty( Wroter\Plugin::instance()->widgets_manager->get_registered_widgets() );
	}

	public function test_elementMethods() {
		foreach ( Wroter\Plugin::instance()->widgets_manager->get_registered_widgets() as $widget ) {
			$this->assertNotEmpty( $widget->get_title() );
			$this->assertNotEmpty( $widget->get_type() );
			$this->assertNotEmpty( $widget->get_id() );
		}
	}

	public function test_registerNUnregisterWidget() {
		$return = Wroter\Plugin::instance()->widgets_manager->register_widget( '\Wroter\Widget_Not_Found' );
		$this->assertInstanceOf( '\WP_Error', $return );
		$this->assertEquals( 'widget_class_name_not_exists', $return->get_error_code() );

		$return = Wroter\Plugin::instance()->widgets_manager->register_widget( '\Wroter\Control_Text' );
		$this->assertInstanceOf( '\WP_Error', $return );
		$this->assertEquals( 'wrong_instance_widget', $return->get_error_code() );

		$widget_class = '\Wroter\Widget_Text_editor';
		$widget_id = 'text-editor';

		$this->assertTrue( Wroter\Plugin::instance()->widgets_manager->register_widget( $widget_class ) );

		$widget = Wroter\Plugin::instance()->widgets_manager->get_widget( $widget_id );
		$this->assertInstanceOf( $widget_class, $widget );

		$this->assertTrue( Wroter\Plugin::instance()->widgets_manager->unregister_widget( $widget_id ) );
		$this->assertFalse( Wroter\Plugin::instance()->widgets_manager->unregister_widget( $widget_id ) );

		$this->assertFalse( Wroter\Plugin::instance()->widgets_manager->get_widget( $widget_id ) );
	}

	public function test_controlsSelectorsData() {
		$wrapper_text = '{{WRAPPER}}';

		foreach ( Wroter\Plugin::instance()->widgets_manager->get_registered_widgets() as $widget ) {
			foreach ( $widget->get_style_controls() as $control ) {
				foreach ( $control['selectors'] as $selector => $css_property ) {
					foreach ( explode( ',', $selector ) as $item ) {
						$this->assertTrue( false !== strpos( $item, $wrapper_text ) );
					}
				}
			}
		}
	}

	public function test_controlsDefaultData() {
		foreach ( Wroter\Plugin::instance()->widgets_manager->get_registered_widgets() as $widget ) {
			foreach ( $widget->get_controls() as $control ) {
				if ( \Wroter\Controls_Manager::SELECT !== $control['type'] )
					continue;
				
				$error_msg = sprintf( 'Widget: %s, Control: %s', $widget->get_id(), $control['name'] );
				
				if ( empty( $control['default'] ) )
					$this->assertTrue( isset( $control['options'][''] ), $error_msg );
				else
					$this->assertArrayHasKey( $control['default'], $control['options'], $error_msg );
			}
		}
	}
}
