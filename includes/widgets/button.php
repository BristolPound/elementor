<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Button extends Widget_Base {

	public function get_id() {
		return 'button';
	}

	public function get_title() {
		return __( 'Button', 'wroter' );
	}

	public function get_icon() {
		return 'button';
	}

	public static function get_button_sizes() {
		return [
			'small' => __( 'Small', 'wroter' ),
			'medium' => __( 'Medium', 'wroter' ),
			'large' => __( 'Large', 'wroter' ),
			'xl' => __( 'XL', 'wroter' ),
			'xxl' => __( 'XXL', 'wroter' ),
		];
	}

	protected function _register_controls() {
		$this->add_control(
			'section_button',
			[
				'label' => __( 'Button', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'button_type',
			[
				'label' => __( 'Type', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'section' => 'section_button',
				'options' => [
					'' => __( 'Default', 'wroter' ),
					'info' => __( 'Info', 'wroter' ),
					'success' => __( 'Success', 'wroter' ),
					'warning' => __( 'Warning', 'wroter' ),
					'danger' => __( 'Danger', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'wroter' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click me', 'wroter' ),
				'placeholder' => __( 'Click me', 'wroter' ),
				'section' => 'section_button',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'wroter' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => [
					'url' => '#',
				],
				'section' => 'section_button',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'wroter' ),
				'type' => Controls_Manager::CHOOSE,
				'section' => 'section_button',
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
					'justify' => [
						'title' => __( 'Justified', 'wroter' ),
						'icon' => 'align-justify',
					],
				],
				'prefix_class' => 'wroter%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => self::get_button_sizes(),
				'section' => 'section_button',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'wroter' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
				'section' => 'section_button',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => __( 'Icon Position', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'wroter' ),
					'right' => __( 'After', 'wroter' ),
				],
				'condition' => [
					'icon!' => '',
				],
				'section' => 'section_button',
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => __( 'Icon Spacing', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-button .wroter-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wroter-button .wroter-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'section' => 'section_button',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'wroter' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_button',
			]
		);

		$this->add_control(
			'section_style',
			[
				'label' => __( 'Button', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __( 'Typography', 'wroter' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
				'selector' => '{{WRAPPER}} .wroter-button',
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'wroter' ),
				'tab' => self::TAB_STYLE,
				'placeholder' => '1px',
				'default' => '1px',
				'section' => 'section_style',
				'selector' => '{{WRAPPER}} .wroter-button',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
				'selectors' => [
					'{{WRAPPER}} .wroter-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label' => __( 'Text Padding', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
				'selectors' => [
					'{{WRAPPER}} .wroter-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_hover',
			[
				'label' => __( 'Button Hover', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_hover',
				'selectors' => [
					'{{WRAPPER}} .wroter-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_hover',
				'selectors' => [
					'{{WRAPPER}} .wroter-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_hover',
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-button:hover' => 'border-color: {{VALUE}};',
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
		$this->add_render_attribute( 'wrapper', 'class', 'wroter-button-wrapper' );

		//if ( ! empty( $instance['align'] ) ) {
		//	$this->add_render_attribute( 'wrapper', 'class', 'wroter-align-' . $instance['align'] );
		//}

		if ( ! empty( $instance['link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $instance['link']['url'] );
			$this->add_render_attribute( 'button', 'class', 'wroter-button-link' );

			if ( ! empty( $instance['link']['is_external'] ) ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
		}

		$this->add_render_attribute( 'button', 'class', 'wroter-button' );

		if ( ! empty( $instance['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'wroter-size-' . $instance['size'] );
		}

		if ( ! empty( $instance['button_type'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'wroter-button-' . $instance['button_type'] );
		}

		if ( $instance['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'wroter-animation-' . $instance['hover_animation'] );
		}

		$this->add_render_attribute( 'content-wrapper', 'class', 'wroter-button-content-wrapper' );
		$this->add_render_attribute( 'icon-align', 'class', 'wroter-align-icon-' . $instance['icon_align'] );
		$this->add_render_attribute( 'icon-align', 'class', 'wroter-button-icon' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
					<?php if ( ! empty( $instance['icon'] ) ) : ?>
						<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
							<i class="<?php echo esc_attr( $instance['icon'] ); ?>"></i>
						</span>
					<?php endif; ?>
					<span class="wroter-button-text"><?php echo $instance['text']; ?></span>
				</span>
			</a>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<div class="wroter-button-wrapper">
			<a class="wroter-button wroter-button-{{ settings.button_type }} wroter-size-{{ settings.size }} wroter-animation-{{ settings.hover_animation }}" href="{{ settings.link.url }}">
				<span class="wroter-button-content-wrapper">
					<# if ( settings.icon ) { #>
					<span class="wroter-button-icon wroter-align-icon-{{ settings.icon_align }}">
						<i class="{{ settings.icon }}"></i>
					</span>
					<# } #>
					<span class="wroter-button-text">{{{ settings.text }}}</span>
				</span>
			</a>
		</div>
		<?php
	}
}
