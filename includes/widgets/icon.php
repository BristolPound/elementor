<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Icon extends Widget_Base {

	public function get_id() {
		return 'icon';
	}

	public function get_title() {
		return __( 'Icon', 'wroter' );
	}

	public function get_icon() {
		return 'favorite';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_icon',
			[
				'label' => __( 'Icon', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_icon',
				'options' => [
					'default' => __( 'Default', 'wroter' ),
					'stacked' => __( 'Stacked', 'wroter' ),
					'framed' => __( 'Framed', 'wroter' ),
				],
				'default' => 'default',
				'prefix_class' => 'wroter-view-',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'wroter' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => 'fa fa-star',
				'section' => 'section_icon',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Shape', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_icon',
				'options' => [
					'circle' => __( 'Circle', 'wroter' ),
					'square' => __( 'Square', 'wroter' ),
				],
				'default' => 'circle',
				'condition' => [
					'view!' => 'default',
				],
				'prefix_class' => 'wroter-shape-',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'wroter' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'section' => 'section_icon',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'wroter' ),
				'type' => Controls_Manager::CHOOSE,
				'section' => 'section_icon',
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .wroter-icon-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'section_style_icon',
			[
				'label' => __( 'Icon', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_icon',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.wroter-view-stacked .wroter-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.wroter-view-framed .wroter-icon, {{WRAPPER}}.wroter-view-default .wroter-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => __( 'Secondary Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_icon',
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.wroter-view-framed .wroter-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.wroter-view-stacked .wroter-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Icon Size', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_icon',
				'selectors' => [
					'{{WRAPPER}} .wroter-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __( 'Icon Padding', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_icon',
				'selectors' => [
					'{{WRAPPER}} .wroter-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'default' => [
					'size' => 1.5,
					'unit' => 'em',
				],
				'range' => [
					'em' => [
						'min' => 0,
					],
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->add_control(
			'rotate',
			[
				'label' => __( 'Icon Rotate', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_icon',
				'selectors' => [
					'{{WRAPPER}} .wroter-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_icon',
				'selectors' => [
					'{{WRAPPER}} .wroter-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_icon',
				'selectors' => [
					'{{WRAPPER}} .wroter-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->add_control(
			'section_hover',
			[
				'label' => __( 'Icon Hover', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => __( 'Primary Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_hover',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.wroter-view-stacked .wroter-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.wroter-view-framed .wroter-icon:hover, {{WRAPPER}}.wroter-view-default .wroter-icon:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => __( 'Secondary Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_hover',
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.wroter-view-framed .wroter-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.wroter-view-stacked .wroter-icon:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Animation', 'wroter' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
				'tab' => self::TAB_STYLE,
				'section' => 'section_hover',
			]
		);
	}

	protected function render( $instance = [] ) {
		$this->add_render_attribute( 'wrapper', 'class', 'wroter-icon-wrapper' );

		$this->add_render_attribute( 'icon-wrapper', 'class', 'wroter-icon' );

		if ( ! empty( $instance['hover_animation'] ) ) {
			$this->add_render_attribute( 'icon-wrapper', 'class', 'wroter-animation-' . $instance['hover_animation'] );
		}

		$icon_tag = 'div';

		if ( ! empty( $instance['link']['url'] ) ) {
			$this->add_render_attribute( 'icon-wrapper', 'href', $instance['link']['url'] );
			$icon_tag = 'a';

			if ( ! empty( $instance['link']['is_external'] ) ) {
				$this->add_render_attribute( 'icon-wrapper', 'target', '_blank' );
			}
		}

		if ( ! empty( $instance['icon'] ) ) {
			$this->add_render_attribute( 'icon', 'class', $instance['icon'] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<<?php echo $icon_tag . ' ' . $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
				<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
			</<?php echo $icon_tag; ?>>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<# var link = settings.link.url ? 'href="' + settings.link.url + '"' : '',
				iconTag = link ? 'a' : 'div'; #>
		<div class="wroter-icon-wrapper">
			<{{{ iconTag }}} class="wroter-icon wroter-animation-{{ settings.hover_animation }}" {{{ link }}}>
				<i class="{{ settings.icon }}"></i>
			</{{{ iconTag }}}>
		</div>
		<?php
	}
}
