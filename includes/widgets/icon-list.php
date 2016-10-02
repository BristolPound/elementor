<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Icon_list extends Widget_Base {

	public function get_id() {
		return 'icon-list';
	}

	public function get_title() {
		return __( 'Icon List', 'wroter' );
	}

	public function get_icon() {
		return 'bullet-list';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_icon',
			[
				'label' => __( 'Icon List', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'icon_list',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'text' => __( 'List Item #1', 'wroter' ),
						'icon' => 'fa fa-check',
					],
					[
						'text' => __( 'List Item #2', 'wroter' ),
						'icon' => 'fa fa-times',
					],
					[
						'text' => __( 'List Item #3', 'wroter' ),
						'icon' => 'fa fa-dot-circle-o',
					],
				],
				'section' => 'section_icon',
				'fields' => [
					[
						'name' => 'text',
						'label' => __( 'Text', 'wroter' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'placeholder' => __( 'List Item', 'wroter' ),
						'default' => __( 'List Item', 'wroter' ),
					],
					[
						'name' => 'icon',
						'label' => __( 'Icon', 'wroter' ),
						'type' => Controls_Manager::ICON,
						'label_block' => true,
						'default' => 'fa fa-check',
					],
					[
						'name' => 'link',
						'label' => __( 'Link', 'wroter' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
						'placeholder' => __( 'http://your-link.com', 'wroter' ),
					],
				],
				'title_field' => 'text',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'wroter' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_icon',
			]
		);

		$this->add_control(
			'section_icon_style',
			[
				'label' => __( 'Icon', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_icon_style',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-icon-list-icon i' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'tab' => self::TAB_STYLE,
				'section' => 'section_icon_style',
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-icon-list-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_align',
			[
				'label' => __( 'Alignment', 'wroter' ),
				'type' => Controls_Manager::CHOOSE,
				'tab' => self::TAB_STYLE,
				'section' => 'section_icon_style',
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
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-icon-list-items' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'section_text_style',
			[
				'label' => __( 'Text', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_indent',
			[
				'label' => __( 'Text Indent', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'tab' => self::TAB_STYLE,
				'section' => 'section_text_style',
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_text_style',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-icon-list-text' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'label' => __( 'Typography', 'wroter' ),
				'tab' => self::TAB_STYLE,
				'section' => 'section_text_style',
				'selector' => '{{WRAPPER}} .wroter-icon-list-text',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);
	}

	protected function render( $instance = [] ) {
		?>
		<ul class="wroter-icon-list-items">
			<?php foreach ( $instance['icon_list'] as $item ) : ?>
				<li class="wroter-icon-list-item" >
					<?php
					if ( ! empty( $item['link']['url'] ) ) {
						$target = $item['link']['is_external'] ? ' target="_blank"' : '';

						echo '<a href="' . $item['link']['url'] . '"' . $target . '>';
					}

					if ( $item['icon'] ) : ?>
						<span class="wroter-icon-list-icon">
							<i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
						</span>
					<?php endif; ?>
					<span class="wroter-icon-list-text"><?php echo $item['text']; ?></span>
					<?php
					if ( ! empty( $item['link']['url'] ) ) {
						echo '</a>';
					}
					?>
				</li>
				<?php
			endforeach; ?>
		</ul>
		<?php
	}

	protected function content_template() {
		?>
		<ul class="wroter-icon-list-items">
			<#
			if ( settings.icon_list ) {
				_.each( settings.icon_list, function( item ) { #>
					<li class="wroter-icon-list-item">
						<# if ( item.link && item.link.url ) { #>
							<a href="{{ item.link.url }}">
						<# } #>
						<span class="wroter-icon-list-icon">
							<i class="{{ item.icon }}"></i>
						</span>
						<span class="wroter-icon-list-text">{{{ item.text }}}</span>
						<# if ( item.link && item.link.url ) { #>
							</a>
						<# } #>
					</li>
				<#
				} );
			} #>
		</ul>
		<?php
	}
}
