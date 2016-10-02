<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Group_Control_Typography extends Group_Control_Base {

	private static $_fields;

	private static $_scheme_fields_keys = [ 'font_family', 'font_weight' ];

	public static function get_scheme_fields_keys() {
		return self::$_scheme_fields_keys;
	}

	public static function get_type() {
		return 'typography';
	}

	public static function get_fields() {
		if ( null === self::$_fields ) {
			self::_init_fields();
		}

		return self::$_fields;
	}

	private static function _init_fields() {
		$fields = [];

		$fields['font_size'] = [
			'label' => _x( 'Size', 'Typography Control', 'wroter' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 200,
				],
			],
			'responsive' => true,
			'selector_value' => 'font-size: {{SIZE}}{{UNIT}}',
		];

		$default_fonts = get_option( 'wroter_default_generic_fonts', 'Sans-serif' );

		if ( $default_fonts ) {
			$default_fonts = ', ' . $default_fonts;
		}

		$fields['font_family'] = [
			'label' => _x( 'Family', 'Typography Control', 'wroter' ),
			'type' => Controls_Manager::FONT,
			'default' => '',
			'selector_value' => 'font-family: {{VALUE}}' . $default_fonts . ';',
		];

		$typo_weight_options = [ '' => __( 'Default', 'wroter' ) ];
		foreach ( array_merge( [ 'normal', 'bold' ], range( 100, 900, 100 ) ) as $weight ) {
			$typo_weight_options[ $weight ] = ucfirst( $weight );
		}

		$fields['font_weight'] = [
			'label' => _x( 'Weight', 'Typography Control', 'wroter' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => $typo_weight_options,
		];

		$fields['text_transform'] = [
			'label' => _x( 'Transform', 'Typography Control', 'wroter' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => __( 'Default', 'wroter' ),
				'uppercase' => _x( 'Uppercase', 'Typography Control', 'wroter' ),
				'lowercase' => _x( 'Lowercase', 'Typography Control', 'wroter' ),
				'capitalize' => _x( 'Capitalize', 'Typography Control', 'wroter' ),
			],
		];

		$fields['font_style'] = [
			'label' => _x( 'Style', 'Typography Control', 'wroter' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => __( 'Default', 'wroter' ),
				'normal' => _x( 'Normal', 'Typography Control', 'wroter' ),
				'italic' => _x( 'Italic', 'Typography Control', 'wroter' ),
				'oblique' => _x( 'Oblique', 'Typography Control', 'wroter' ),
			],
		];

		$fields['line_height'] = [
			'label' => _x( 'Line-Height', 'Typography Control', 'wroter' ),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'unit' => 'em',
			],
			'range' => [
				'px' => [
					'min' => 1,
				],
			],
			'responsive' => true,
			'size_units' => [ 'px', 'em' ],
			'selector_value' => 'line-height: {{SIZE}}{{UNIT}}',
		];

		$fields['letter_spacing'] = [
			'label' => _x( 'Letter Spacing', 'Typography Control', 'wroter' ),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => [
					'min' => -5,
					'max' => 10,
					'step' => 0.1,
				],
			],
			'responsive' => true,
			'selector_value' => 'letter-spacing: {{SIZE}}{{UNIT}}',
		];

		self::$_fields = $fields;
	}

	protected function _get_controls( $args ) {
		$controls = self::get_fields();

		array_walk( $controls, function ( &$control, $control_name ) use ( $args ) {
			$selector_value = ! empty( $control['selector_value'] ) ? $control['selector_value'] : str_replace( '_', '-', $control_name ) . ': {{VALUE}};';

			$control['selectors'] = [
				$args['selector'] => $selector_value,
			];

			$control['condition'] = [
				'typography' => [ 'custom' ],
			];
		} );

		$typography_control = [
			'typography' => [
				'label' => _x( 'Typography', 'Typography Control', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'wroter' ),
					'custom' => __( 'Custom', 'wroter' ),
				],
			],
		];

		/*
		 *  Custom Typography switch control version
		 *
		$typography_control = [
			'typography' => [
				'label' => _x( 'Custom Typography', 'Typography Control', 'wroter' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'return_value' => 'custom',
			],
		];
		*/

		$controls = $typography_control + $controls;

		return $controls;
	}

	protected function _add_group_args_to_control( $control_id, $control_args ) {
		$control_args = parent::_add_group_args_to_control( $control_id, $control_args );

		$args = $this->get_args();

		if ( in_array( $control_id, self::get_scheme_fields_keys() ) && ! empty( $args['scheme'] ) ) {
			$control_args['scheme'] = [
				'type' => self::get_type(),
				'value' => $args['scheme'],
				'key' => $control_id,
			];
		}

		return $control_args;
	}
}
