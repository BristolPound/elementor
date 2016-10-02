<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Toggle extends Widget_Base {

	public function get_id() {
		return 'toggle';
	}

	public function get_title() {
		return __( 'Toggle', 'wroter' );
	}

	public function get_icon() {
		return 'toggle';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_title',
			[
				'label' => __( 'Toggle', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => __( 'Toggle Items', 'wroter' ),
				'type' => Controls_Manager::REPEATER,
				'section' => 'section_title',
				'default' => [
					[
						'tab_title' => __( 'Toggle #1', 'wroter' ),
						'tab_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'wroter' ),
					],
					[
						'tab_title' => __( 'Toggle #2', 'wroter' ),
						'tab_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'wroter' ),
					],
				],
				'fields' => [
					[
						'name' => 'tab_title',
						'label' => __( 'Title & Content', 'wroter' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => __( 'Toggle Title' , 'wroter' ),
					],
					[
						'name' => 'tab_content',
						'label' => __( 'Content', 'wroter' ),
						'type' => Controls_Manager::TEXTAREA,
						'default' => __( 'Toggle Content', 'wroter' ),
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
				'section' => 'section_title',
			]
		);

		$this->add_control(
			'section_title_style',
			[
				'label' => __( 'Toggle', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
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
					'{{WRAPPER}} .wroter-toggle .wroter-toggle-title' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wroter-toggle .wroter-toggle-content' => 'border-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .wroter-toggle .wroter-toggle-content' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .wroter-toggle .wroter-toggle-title' => 'border-color: {{VALUE}};',
				],
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
					'{{WRAPPER}} .wroter-toggle .wroter-toggle-title' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
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
					'{{WRAPPER}} .wroter-toggle .wroter-toggle-title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
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
					'{{WRAPPER}} .wroter-toggle .wroter-toggle-title.active' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .wroter-toggle .wroter-toggle-title',
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
					'{{WRAPPER}} .wroter-toggle .wroter-toggle-content' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .wroter-toggle .wroter-toggle-content' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => 'Content Typography',
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selector' => '{{WRAPPER}} .wroter-toggle .wroter-toggle-content',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);
	}

	protected function render( $instance = [] ) {
		?>
		<div class="wroter-toggle">
			<?php $counter = 1; ?>
			<?php foreach ( $instance['tabs'] as $item ) : ?>
				<div class="wroter-toggle-title" data-tab="<?php echo $counter; ?>">
					<span class="wroter-toggle-icon">
						<i class="fa"></i>
					</span>
					<?php echo $item['tab_title']; ?>
				</div>
				<div class="wroter-toggle-content" data-tab="<?php echo $counter; ?>"><?php echo $this->parse_text_editor( $item['tab_content'], $item ); ?></div>
			<?php
				$counter++;
			endforeach; ?>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<div class="wroter-toggle">
			<#
			if ( settings.tabs ) {
				var counter = 1;
				_.each(settings.tabs, function( item ) { #>
					<div class="wroter-toggle-title" data-tab="{{ counter }}">
						<span class="wroter-toggle-icon">
						<i class="fa"></i>
					</span>
						{{{ item.tab_title }}}
					</div>
					<div class="wroter-toggle-content" data-tab="{{ counter }}">{{{ item.tab_content }}}</div>
				<#
					counter++;
				} );
			} #>
		</div>
		<?php
	}
}
