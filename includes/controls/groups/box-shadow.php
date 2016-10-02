<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Group_Control_Box_Shadow extends Group_Control_Base {

	public static function get_type() {
		return 'box-shadow';
	}

	protected function _get_controls( $args ) {
		$controls = [];

		$controls['box_shadow_type'] = [
			'label' => _x( 'Box Shadow', 'Box Shadow Control', 'wroter' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => __( 'No', 'wroter' ),
				'outset' => _x( 'Yes', 'Box Shadow Control', 'wroter' ),
			],
			'separator' => 'before',
		];

		$controls['box_shadow'] = [
			'label' => _x( 'Box Shadow', 'Box Shadow Control', 'wroter' ),
			'type' => Controls_Manager::BOX_SHADOW,
			'selectors' => [
				$args['selector'] => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
			],
			'condition' => [
				'box_shadow_type!' => '',
			],
		];

		return $controls;
	}
}
