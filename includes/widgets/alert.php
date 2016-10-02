<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Alert extends Widget_Base {

	public function get_id() {
		return 'alert';
	}

	public function get_title() {
		return __( 'Alert', 'wroter' );
	}

	public function get_icon() {
		return 'alert';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_alert',
			[
				'label' => __( 'Alert', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'alert_type',
			[
				'label' => __( 'Type', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'info',
				'section' => 'section_alert',
				'options' => [
					'info' => __( 'Info', 'wroter' ),
					'success' => __( 'Success', 'wroter' ),
					'warning' => __( 'Warning', 'wroter' ),
					'danger' => __( 'Danger', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'alert_title',
			[
				'label' => __( 'Title & Description', 'wroter' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Your Title', 'wroter' ),
				'default' => __( 'This is Alert', 'wroter' ),
				'label_block' => true,
				'section' => 'section_alert',
			]
		);

		$this->add_control(
			'alert_description',
			[
				'label' => __( 'Content', 'wroter' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Your Description', 'wroter' ),
				'default' => __( 'I am description. Click edit button to change this text.', 'wroter' ),
				'separator' => 'none',
				'section' => 'section_alert',
				'show_label' => false,
			]
		);

		$this->add_control(
			'show_dismiss',
			[
				'label' => __( 'Dismiss Button', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'show',
				'section' => 'section_alert',
				'options' => [
					'show' => __( 'Show', 'wroter' ),
					'hide' => __( 'Hide', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'wroter' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_alert',
			]
		);

		$this->add_control(
			'section_type',
			[
				'label' => __( 'Alert Type', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'background',
			[
				'label' => __( 'Background Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_type',
				'selectors' => [
					'{{WRAPPER}} .wroter-alert' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __( 'Border Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_type',
				'selectors' => [
					'{{WRAPPER}} .wroter-alert' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_left-width',
			[
				'label' => __( 'Left Border Width', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'tab' => self::TAB_STYLE,
				'section' => 'section_type',
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-alert' => 'border-left-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __( 'Title', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_title',
				'selectors' => [
					'{{WRAPPER}} .wroter-alert-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'alert_title',
				'tab' => self::TAB_STYLE,
				'section' => 'section_title',
				'selector' => '{{WRAPPER}} .wroter-alert-title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'section_description',
			[
				'label' => __( 'Description', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Text Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_description',
				'selectors' => [
					'{{WRAPPER}} .wroter-alert-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'alert_description',
				'tab' => self::TAB_STYLE,
				'section' => 'section_description',
				'selector' => '{{WRAPPER}} .wroter-alert-description',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

	}

	protected function render( $instance = [] ) {
		if ( empty( $instance['alert_title'] ) ) {
			return;
		}

		if ( ! empty( $instance['alert_type'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'wroter-alert wroter-alert-' . $instance['alert_type'] );
		}

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . ' role="alert">';
		$html = sprintf( '<span class="wroter-alert-title">%1$s</span>', $instance['alert_title'] );

		if ( ! empty( $instance['alert_description'] ) ) {
			$html .= sprintf( '<span class="wroter-alert-description">%s</span>', $instance['alert_description'] );
		}

		if ( ! empty( $instance['show_dismiss'] ) && 'show' === $instance['show_dismiss'] ) {
			$html .= '<button type="button" class="wroter-alert-dismiss">X</button></div>';
		}

		echo $html;
	}

	protected function content_template() {
		?>
		<#
		var html = '<div class="wroter-alert wroter-alert-' + settings.alert_type + '" role="alert">';
		if ( '' !== settings.title ) {
			html += '<span class="wroter-alert-title">' + settings.alert_title + '</span>';

			if ( '' !== settings.description ) {
				html += '<span class="wroter-alert-description">' + settings.alert_description + '</span>';
			}

			if ( 'show' === settings.show_dismiss ) {
				html += '<button type="button" class="wroter-alert-dismiss">X</button></div>';
			}

			print( html );
		}
		#>
		<?php
	}
}
