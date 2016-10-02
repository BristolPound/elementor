<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Element_Column extends Element_Base {

	public function get_id() {
		return 'column';
	}

	public function get_title() {
		return __( 'Column', 'wroter' );
	}

	public function get_icon() {
		return 'columns';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_style',
			[
				'label' => __( 'Background & Border', 'wroter' ),
				'tab' => self::TAB_STYLE,
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
				'selector' => '{{WRAPPER}} > .wroter-element-populated',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
				'selector' => '{{WRAPPER}} > .wroter-element-populated',
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
					'{{WRAPPER}} > .wroter-element-populated' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'section' => 'section_style',
				'tab' => self::TAB_STYLE,
				'selector' => '{{WRAPPER}} > .wroter-element-populated',
			]
		);

		// Section Typography
		$this->add_control(
			'section_typo',
			[
				'label' => __( 'Typography', 'wroter' ),
				'tab' => self::TAB_STYLE,
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Heading Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-element-populated .wroter-heading-title' => 'color: {{VALUE}};',
				],
				'tab' => self::TAB_STYLE,
				'section' => 'section_typo',
			]
		);

		$this->add_control(
			'color_text',
			[
				'label' => __( 'Text Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'section' => 'section_typo',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} > .wroter-element-populated' => 'color: {{VALUE}};',
				],
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'color_link',
			[
				'label' => __( 'Link Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'section' => 'section_typo',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-element-populated a' => 'color: {{VALUE}};',
				],
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'color_link_hover',
			[
				'label' => __( 'Link Hover Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'section' => 'section_typo',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-element-populated a:hover' => 'color: {{VALUE}};',
				],
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_align',
			[
				'label' => __( 'Text Align', 'wroter' ),
				'type' => Controls_Manager::CHOOSE,
				'tab' => self::TAB_STYLE,
				'section' => 'section_typo',
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
					'{{WRAPPER}} > .wroter-element-populated' => 'text-align: {{VALUE}};',
				],
			]
		);

		// Section Advanced
		$this->add_control(
			'section_advanced',
			[
				'label' => __( 'Advanced', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_ADVANCED,
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __( 'Margin', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'section' => 'section_advanced',
				'tab' => self::TAB_ADVANCED,
				'selectors' => [
					'{{WRAPPER}} > .wroter-element-populated' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => __( 'Padding', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'section' => 'section_advanced',
				'tab' => self::TAB_ADVANCED,
				'selectors' => [
					'{{WRAPPER}} > .wroter-element-populated' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'animation',
			[
				'label' => __( 'Entrance Animation', 'wroter' ),
				'type' => Controls_Manager::ANIMATION,
				'default' => '',
				'prefix_class' => 'animated ',
				'tab' => self::TAB_ADVANCED,
				'label_block' => true,
				'section' => 'section_advanced',
			]
		);

		$this->add_control(
			'animation_duration',
			[
				'label' => __( 'Animation Duration', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'slow' => __( 'Slow', 'wroter' ),
					'' => __( 'Normal', 'wroter' ),
					'fast' => __( 'Fast', 'wroter' ),
				],
				'prefix_class' => 'animated-',
				'tab' => self::TAB_ADVANCED,
				'section' => 'section_advanced',
				'condition' => [
					'animation!' => '',
				],
			]
		);

		$this->add_control(
			'css_classes',
			[
				'label' => __( 'CSS Classes', 'wroter' ),
				'type' => Controls_Manager::TEXT,
				'section' => 'section_advanced',
				'tab' => self::TAB_ADVANCED,
				'default' => '',
				'prefix_class' => '',
				'label_block' => true,
				'title' => __( 'Add your custom class WITHOUT the dot. e.g: my-class', 'wroter' ),
			]
		);

		// Section Responsive
		$this->add_control(
			'section_responsive',
			[
				'label' => __( 'Responsive', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_ADVANCED,
			]
		);

		$responsive_points = [
			'screen_sm' => [
				'title' => __( 'Mobile Width', 'wroter' ),
				'class_prefix' => 'wroter-sm-',
				'classes' => '',
				'description' => '',
			],
			'screen_xs' => [
				'title' => __( 'Mobile Portrait', 'wroter' ),
				'class_prefix' => 'wroter-xs-',
				'classes' => 'wroter-control-deprecated',
				'description' => __( 'Deprecated: Mobile Portrait control is no longer supported. Please use the Mobile Width instead.', 'wroter' ),
			],
		];

		foreach ( $responsive_points as $point_name => $point_data ) {
			$this->add_control(
				$point_name,
				[
					'label' => $point_data['title'],
					'type' => Controls_Manager::SELECT,
					'section' => 'section_responsive',
					'default' => 'default',
					'options' => [
						'default' => __( 'Default', 'wroter' ),
						'custom' => __( 'Custom', 'wroter' ),
					],
					'tab' => self::TAB_ADVANCED,
					'description' => $point_data['description'],
					'classes' => $point_data['classes'],
				]
			);

			$this->add_control(
				$point_name . '_width',
				[
					'label' => __( 'Column Width', 'wroter' ),
					'type' => Controls_Manager::SELECT,
					'section' => 'section_responsive',
					'options' => [
						'10' => '10%',
						'11' => '11%',
						'12' => '12%',
						'14' => '14%',
						'16' => '16%',
						'20' => '20%',
						'25' => '25%',
						'30' => '30%',
						'33' => '33%',
						'40' => '40%',
						'50' => '50%',
						'60' => '60%',
						'66' => '66%',
						'70' => '70%',
						'75' => '75%',
						'80' => '80%',
						'83' => '83%',
						'90' => '90%',
						'100' => '100%',
					],
					'default' => '100',
					'tab' => self::TAB_ADVANCED,
					'condition' => [
						$point_name => [ 'custom' ],
					],
					'prefix_class' => $point_data['class_prefix'],
				]
			);
		}
	}

	protected function render_settings() {
		?>
		<div class="wroter-element-overlay">
			<div class="column-title"></div>
			<div class="wroter-editor-element-settings wroter-editor-column-settings">
				<ul class="wroter-editor-element-settings-list wroter-editor-column-settings-list">
					<li class="wroter-editor-element-setting wroter-editor-element-trigger">
						<a href="#" title="<?php _e( 'Drag Column', 'wroter' ); ?>"><?php _e( 'Column', 'wroter' ); ?></a>
					</li>
					<?php /* Temp removing for better UI
					<li class="wroter-editor-element-setting wroter-editor-element-edit">
						<a href="#" title="<?php _e( 'Edit Column', 'wroter' ); ?>">
							<span class="wroter-screen-only"><?php _e( 'Edit', 'wroter' ); ?></span>
							<i class="fa fa-pencil"></i>
						</a>
					</li>
					*/ ?>
					<li class="wroter-editor-element-setting wroter-editor-element-duplicate">
						<a href="#" title="<?php _e( 'Duplicate Column', 'wroter' ); ?>">
							<span class="wroter-screen-only"><?php _e( 'Duplicate', 'wroter' ); ?></span>
							<i class="fa fa-files-o"></i>
						</a>
					</li>
					<li class="wroter-editor-element-setting wroter-editor-element-add">
						<a href="#" title="<?php _e( 'Add New Column', 'wroter' ); ?>">
							<span class="wroter-screen-only"><?php _e( 'Add', 'wroter' ); ?></span>
							<i class="fa fa-plus"></i>
						</a>
					</li>
					<li class="wroter-editor-element-setting wroter-editor-element-remove">
						<a href="#" title="<?php _e( 'Remove Column', 'wroter' ); ?>">
							<span class="wroter-screen-only"><?php _e( 'Remove', 'wroter' ); ?></span>
							<i class="fa fa-times"></i>
						</a>
					</li>
				</ul>
				<ul class="wroter-editor-element-settings-list  wroter-editor-section-settings-list">
					<li class="wroter-editor-element-setting wroter-editor-element-trigger">
						<a href="#" title="<?php _e( 'Drag Section', 'wroter' ); ?>"><?php _e( 'Section', 'wroter' ); ?></a>
					</li>
					<?php /* Temp removing for better UI
					<li class="wroter-editor-element-setting wroter-editor-element-edit">
						<a href="#" title="<?php _e( 'Edit', 'wroter' ); ?>">
							<span class="wroter-screen-only"><?php _e( 'Edit Section', 'wroter' ); ?></span>
							<i class="fa fa-pencil"></i>
						</a>
					</li>
					*/ ?>
					<li class="wroter-editor-element-setting wroter-editor-element-duplicate">
						<a href="#" title="<?php _e( 'Duplicate', 'wroter' ); ?>">
							<span class="wroter-screen-only"><?php _e( 'Duplicate Section', 'wroter' ); ?></span>
							<i class="fa fa-files-o"></i>
						</a>
					</li>
					<li class="wroter-editor-element-setting wroter-editor-element-save">
						<a href="#" title="<?php _e( 'Save', 'wroter' ); ?>">
							<span class="wroter-screen-only"><?php _e( 'Save to Library', 'wroter' ); ?></span>
							<i class="fa fa-floppy-o"></i>
						</a>
					</li>
					<li class="wroter-editor-element-setting wroter-editor-element-remove">
						<a href="#" title="<?php _e( 'Remove', 'wroter' ); ?>">
							<span class="wroter-screen-only"><?php _e( 'Remove Section', 'wroter' ); ?></span>
							<i class="fa fa-times"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<div class="wroter-column-wrap">
			<div class="wroter-widget-wrap"></div>
		</div>
		<?php
	}

	public function before_render( $instance, $element_id, $element_data = [] ) {
		$column_type = ! empty( $element_data['isInner'] ) ? 'inner' : 'top';

		$this->add_render_attribute( 'wrapper', 'class', [
			'wroter-column',
			'wroter-element',
			'wroter-element-' . $element_id,
			'wroter-col-' . $instance['_column_size'],
			'wroter-' . $column_type . '-column',
		] );

		foreach ( $this->get_class_controls() as $control ) {
			if ( empty( $instance[ $control['name'] ] ) )
				continue;

			if ( ! $this->is_control_visible( $instance, $control ) )
				continue;

			$this->add_render_attribute( 'wrapper', 'class', $control['prefix_class'] . $instance[ $control['name'] ] );
		}

		if ( ! empty( $instance['animation'] ) ) {
			$this->add_render_attribute( 'wrapper', 'data-animation', $instance['animation'] );
		}

		$this->add_render_attribute( 'wrapper', 'data-element_type', $this->get_id() );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="wroter-column-wrap<?php if ( ! empty( $element_data['elements'] ) ) echo ' wroter-element-populated'; ?>">
				<div class="wroter-widget-wrap">
		<?php
	}

	public function after_render( $instance, $element_id, $element_data = [] ) {
		?>
				</div>
			</div>
		</div>
		<?php
	}
}
