<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Accordion extends Widget_Base {

	public function get_id() {
		return 'accordion';
	}

	public function get_title() {
		return __( 'Accordion', 'wroter' );
	}

	public function get_icon() {
		return 'accordion';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Accordion', 'wroter' ),
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => __( 'Accordion Items', 'wroter' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'tab_title' => __( 'Accordion #1', 'wroter' ),
						'tab_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'wroter' ),
					],
					[
						'tab_title' => __( 'Accordion #2', 'wroter' ),
						'tab_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'wroter' ),
					],
				],
				'fields' => [
					[
						'name' => 'tab_title',
						'label' => __( 'Title & Content', 'wroter' ),
						'type' => Controls_Manager::TEXT,
						'default' => __( 'Accordion Title' , 'wroter' ),
						'label_block' => true,
					],
					[
						'name' => 'tab_content',
						'label' => __( 'Content', 'wroter' ),
						'type' => Controls_Manager::TEXTAREA,
						'default' => __( 'Accordion Content', 'wroter' ),
						'show_label' => false,
					],
				],
				'title_field' => 'tab_title',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'wroter' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Accordion', 'wroter' ),
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => __( 'Icon Alignment', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => is_rtl() ? 'right' : 'left',
				'options' => [
					'left' => __( 'Left', 'wroter' ),
					'right' => __( 'Right', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selectors' => [
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-item' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-content' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-wrapper .wroter-accordion-title.active > span' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __( 'Border Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selectors' => [
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-item' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-content' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-wrapper .wroter-accordion-title.active > span' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selectors' => [
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_background',
			[
				'label' => __( 'Title Background', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selectors' => [
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_active_color',
			[
				'label' => __( 'Active Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selectors' => [
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-title.active' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __( 'Title Typography', 'wroter' ),
				'name' => 'title_typography',
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selector' => '{{WRAPPER}} .wroter-accordion .wroter-accordion-title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label' => __( 'Content Background', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selectors' => [
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-content' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Content Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selectors' => [
					'{{WRAPPER}} .wroter-accordion .wroter-accordion-content' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->end_controls_section();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content Typography', 'wroter' ),
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selector' => '{{WRAPPER}} .wroter-accordion .wroter-accordion-content',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);
	}

	protected function render( $instance = [] ) {
		?>
		<div class="wroter-accordion">
			<?php $counter = 1; ?>
			<?php foreach ( $instance['tabs'] as $item ) : ?>
				<div class="wroter-accordion-item">
					<div class="wroter-accordion-title" data-section="<?php echo $counter; ?>">
						<span class="wroter-accordion-icon wroter-accordion-icon-<?php echo $instance['icon_align']; ?>">
							<i class="fa"></i>
						</span>
						<?php echo $item['tab_title']; ?>
					</div>
					<div class="wroter-accordion-content" data-section="<?php echo $counter; ?>"><?php echo $this->parse_text_editor( $item['tab_content'], $item ); ?></div>
				</div>
			<?php
				$counter++;
			endforeach; ?>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<div class="wroter-accordion" data-active-section="{{ editSettings.activeItemIndex ? editSettings.activeItemIndex : 0 }}">
			<#
			if ( settings.tabs ) {
				var counter = 1;
				_.each( settings.tabs, function( item ) { #>
					<div class="wroter-accordion-item">
						<div class="wroter-accordion-title" data-section="{{ counter }}">
							<span class="wroter-accordion-icon wroter-accordion-icon-{{ settings.icon_align }}">
								<i class="fa"></i>
							</span>
							{{{ item.tab_title }}}
						</div>
						<div class="wroter-accordion-content" data-section="{{ counter }}">{{{ item.tab_content }}}</div>
					</div>
				<#
					counter++;
				} );
			} #>
		</div>
		<?php
	}
}
