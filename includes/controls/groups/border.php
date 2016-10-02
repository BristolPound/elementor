<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Group_Control_Border extends Group_Control_Base {

	public static function get_type() {
		return 'border';
	}

	protected function _get_controls( $args ) {
		$controls = [];

		$controls['border'] = [
			'label' => _x( 'Border Type', 'Border Control', 'wroter' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => __( 'None', 'wroter' ),
				'solid' => _x( 'Solid', 'Border Control', 'wroter' ),
				'double' => _x( 'Double', 'Border Control', 'wroter' ),
				'dotted' => _x( 'Dotted', 'Border Control', 'wroter' ),
				'dashed' => _x( 'Dashed', 'Border Control', 'wroter' ),
			],
			'selectors' => [
				$args['selector'] => 'border-style: {{VALUE}};',
			],
			'separator' => 'before',
		];

		$controls['width'] = [
			'label' => _x( 'Width', 'Border Control', 'wroter' ),
			'type' => Controls_Manager::DIMENSIONS,
			'selectors' => [
				$args['selector'] => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition' => [
				'border!' => '',
			],
		];

		$controls['color'] = [
			'label' => _x( 'Color', 'Border Control', 'wroter' ),
			'type' => Controls_Manager::COLOR,
			'default' => '',
			'tab' => $args['tab'],
			'selectors' => [
				$args['selector'] => 'border-color: {{VALUE}};',
			],
			'condition' => [
				'border!' => '',
			],
		];

		return $controls;
	}
}
