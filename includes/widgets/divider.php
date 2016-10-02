<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Divider extends Widget_Base {

	public function get_id() {
		return 'divider';
	}

	public function get_title() {
		return __( 'Divider', 'wroter' );
	}

	public function get_icon() {
		return 'divider';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_divider',
			[
				'label' => __( 'Divider', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_divider',
				'options' => [
					'solid' => __( 'Solid', 'wroter' ),
					'double' => __( 'Double', 'wroter' ),
					'dotted' => __( 'Dotted', 'wroter' ),
					'dashed' => __( 'Dashed', 'wroter' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .wroter-divider-separator' => 'border-top-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'weight',
			[
				'label' => __( 'Weight', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'section' => 'section_divider',
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-divider-separator' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'section' => 'section_divider',
				'default' => '',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-divider-separator' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'width',
			[
				'label' => __( 'Width', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'section' => 'section_divider',
				'selectors' => [
					'{{WRAPPER}} .wroter-divider-separator' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'wroter' ),
				'type' => Controls_Manager::CHOOSE,
				'section' => 'section_divider',
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'wroter' ),
						'icon' => 'align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wroter' ),
						'icon' => 'align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wroter' ),
						'icon' => 'align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-divider' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'gap',
			[
				'label' => __( 'Gap', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 50,
					],
				],
				'section' => 'section_divider',
				'selectors' => [
					'{{WRAPPER}} .wroter-divider' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'wroter' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_divider',
			]
		);
	}

	protected function render( $instance = [] ) {
		?>
		<div class="wroter-divider">
			<span class="wroter-divider-separator"></span>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<div class="wroter-divider">
			<span class="wroter-divider-separator"></span>
		</div>
		<?php
	}
}
