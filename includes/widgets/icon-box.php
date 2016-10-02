<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Icon_box extends Widget_Base {

	public function get_id() {
		return 'icon-box';
	}

	public function get_title() {
		return __( 'Icon Box', 'wroter' );
	}

	public function get_icon() {
		return 'icon-box';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_icon',
			[
				'label' => __( 'Icon Box', 'wroter' ),
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
				'label' => __( 'Choose Icon', 'wroter' ),
				'type' => Controls_Manager::ICON,
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
			'title_text',
			[
				'label' => __( 'Title & Description', 'wroter' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'wroter' ),
				'placeholder' => __( 'Your Title', 'wroter' ),
				'section' => 'section_icon',
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text',
			[
				'label' => '',
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'wroter' ),
				'placeholder' => __( 'Your Description', 'wroter' ),
				'title' => __( 'Input icon text here', 'wroter' ),
				'section' => 'section_icon',
				'rows' => 10,
				'separator' => 'none',
				'show_label' => false,
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link to', 'wroter' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'wroter' ),
				'section' => 'section_icon',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'position',
			[
				'label' => __( 'Icon Position', 'wroter' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wroter' ),
						'icon' => 'align-left',
					],
					'top' => [
						'title' => __( 'Top', 'wroter' ),
						'icon' => 'align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wroter' ),
						'icon' => 'align-right',
					],
				],
				'prefix_class' => 'wroter-position-',
				'section' => 'section_icon',
				'toggle' => false,
			]
		);

		$this->add_control(
			'title_size',
			[
				'label' => __( 'Title HTML Tag', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'wroter' ),
					'h2' => __( 'H2', 'wroter' ),
					'h3' => __( 'H3', 'wroter' ),
					'h4' => __( 'H4', 'wroter' ),
					'h5' => __( 'H5', 'wroter' ),
					'h6' => __( 'H6', 'wroter' ),
					'div' => __( 'div', 'wroter' ),
					'span' => __( 'span', 'wroter' ),
					'p' => __( 'p', 'wroter' ),
				],
				'default' => 'h3',
				'section' => 'section_icon',
			]
		);

		$this->add_control(
			'section_style_icon',
			[
				'type'  => Controls_Manager::SECTION,
				'label' => __( 'Icon', 'wroter' ),
				'tab'   => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_icon',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.wroter-view-stacked .wroter-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.wroter-view-framed .wroter-icon, {{WRAPPER}}.wroter-view-default .wroter-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
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
			'icon_space',
			[
				'label' => __( 'Icon Spacing', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'section' => 'section_style_icon',
				'tab' => self::TAB_STYLE,
				'selectors' => [
					'{{WRAPPER}}.wroter-position-right .wroter-icon-box-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.wroter-position-left .wroter-icon-box-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.wroter-position-top .wroter-icon-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'section' => 'section_style_icon',
				'tab' => self::TAB_STYLE,
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

		$this->add_control(
			'section_style_content',
			[
				'type'  => Controls_Manager::SECTION,
				'label' => __( 'Content', 'wroter' ),
				'tab'   => self::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'wroter' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
					'justify' => [
						'title' => __( 'Justified', 'wroter' ),
						'icon' => 'align-justify',
					],
				],
				'section' => 'section_style_content',
				'tab' => self::TAB_STYLE,
				'selectors' => [
					'{{WRAPPER}} .wroter-icon-box-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_vertical_alignment',
			[
				'label' => __( 'Vertical Alignment', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top' => __( 'Top', 'wroter' ),
					'middle' => __( 'Middle', 'wroter' ),
					'bottom' => __( 'Bottom', 'wroter' ),
				],
				'default' => 'top',
				'section' => 'section_style_content',
				'tab' => self::TAB_STYLE,
				'prefix_class' => 'wroter-vertical-align-',
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => __( 'Title', 'wroter' ),
				'type' => Controls_Manager::HEADING,
				'section' => 'section_style_content',
				'tab' => self::TAB_STYLE,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_bottom_space',
			[
				'label' => __( 'Title Spacing', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'section' => 'section_style_content',
				'tab' => self::TAB_STYLE,
				'selectors' => [
					'{{WRAPPER}} .wroter-icon-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-icon-box-content .wroter-icon-box-title' => 'color: {{VALUE}};',
				],
				'section' => 'section_style_content',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .wroter-icon-box-content .wroter-icon-box-title',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_content',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label' => __( 'Description', 'wroter' ),
				'type' => Controls_Manager::HEADING,
				'section' => 'section_style_content',
				'tab' => self::TAB_STYLE,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Description Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-icon-box-content .wroter-icon-box-description' => 'color: {{VALUE}};',
				],
				'section' => 'section_style_content',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .wroter-icon-box-content .wroter-icon-box-description',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_content',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);
	}

	protected function render( $instance = [] ) {
		$this->add_render_attribute( 'icon', 'class', [ 'wroter-icon', 'wroter-animation-' . $instance['hover_animation'] ] );

		$icon_tag = 'span';

		if ( ! empty( $instance['link']['url'] ) ) {
			$this->add_render_attribute( 'link', 'href', $instance['link']['url'] );
			$icon_tag = 'a';

			if ( ! empty( $instance['link']['is_external'] ) ) {
				$this->add_render_attribute( 'link', 'target', '_blank' );
			}
		}

		$this->add_render_attribute( 'i', 'class', $instance['icon'] );

		$icon_attributes = $this->get_render_attribute_string( 'icon' );
		$link_attributes = $this->get_render_attribute_string( 'link' );
		?>
		<div class="wroter-icon-box-wrapper">
			<div class="wroter-icon-box-icon">
				<<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); ?>>
					<i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
				</<?php echo $icon_tag; ?>>
			</div>
			<div class="wroter-icon-box-content">
				<<?php echo $instance['title_size']; ?> class="wroter-icon-box-title">
					<<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?>><?php echo $instance['title_text']; ?></<?php echo $icon_tag; ?>>
				</<?php echo $instance['title_size']; ?>>
				<p class="wroter-icon-box-description"><?php echo $instance['description_text']; ?></p>
			</div>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<# var link = settings.link.url ? 'href="' + settings.link.url + '"' : '',
				iconTag = link ? 'a' : 'span'; #>
		<div class="wroter-icon-box-wrapper">
			<div class="wroter-icon-box-icon">
				<{{{ iconTag + ' ' + link }}} class="wroter-icon wroter-animation-{{ settings.hover_animation }}">
					<i class="{{ settings.icon }}"></i>
				</{{{ iconTag }}}>
			</div>
			<div class="wroter-icon-box-content">
				<{{{ settings.title_size }}} class="wroter-icon-box-title">
					<{{{ iconTag + ' ' + link }}}>{{{ settings.title_text }}}</{{{ iconTag }}}>
				</{{{ settings.title_size }}}>
				<p class="wroter-icon-box-description">{{{ settings.description_text }}}</p>
			</div>
		</div>
		<?php
	}
}
