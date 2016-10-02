<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Element_Section extends Element_Base {

	private static $presets = [];

	public function get_id() {
		return 'section';
	}

	public function get_title() {
		return __( 'Section', 'wroter' );
	}

	public function get_icon() {
		return 'columns';
	}

	public static function get_presets( $columns_count = null, $preset_index = null ) {
		if ( ! self::$presets ) {
			self::init_presets();
		}

		$presets = self::$presets;

		if ( null !== $columns_count ) {
			$presets = $presets[ $columns_count ];
		}

		if ( null !== $preset_index ) {
			$presets = $presets[ $preset_index ];
		}

		return $presets;
	}

	public static function init_presets() {
		$additional_presets = [
			2 => [
				[
					'preset' => [ 33, 66 ],
				],
				[
					'preset' => [ 66, 33 ],
				],
			],
			3 => [
				[
					'preset' => [ 25, 25, 50 ],
				],
				[
					'preset' => [ 50, 25, 25 ],
				],
				[
					'preset' => [ 25, 50, 25 ],
				],
				[
					'preset' => [ 16, 66, 16 ],
				],
			],
		];

		foreach ( range( 1, 10 ) as $columns_count ) {
			self::$presets[ $columns_count ] = [
				[
					'preset' => [],
				],
			];

			$preset_unit = floor( 1 / $columns_count * 100 );

			for ( $i = 0; $i < $columns_count; $i++ ) {
				self::$presets[ $columns_count ][0]['preset'][] = $preset_unit;
			}

			if ( ! empty( $additional_presets[ $columns_count ] ) ) {
				self::$presets[ $columns_count ] = array_merge( self::$presets[ $columns_count ], $additional_presets[ $columns_count ] );
			}

			foreach ( self::$presets[ $columns_count ] as $preset_index => & $preset ) {
				$preset['key'] = $columns_count . $preset_index;
			}
		}
	}

	public function get_data() {
		$data = parent::get_data();

		$data['presets'] = self::get_presets();

		return $data;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'wroter' ),
				'tab' => self::TAB_LAYOUT,
			]
		);

		$this->add_control(
			'stretch_section',
			[
				'label' => __( 'Stretch Section', 'wroter' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __( 'Yes', 'wroter' ),
				'label_off' => __( 'No', 'wroter' ),
				'return_value' => 'section-stretched',
				'prefix_class' => 'wroter-',
				'force_render' => true,
				'hide_in_inner' => true,
				'description' => __( 'Stretch the section to the full width of the page using JS.', 'wroter' ) . sprintf( ' <a href="%s" target="_blank">%s</a>', 'https://go.wroter.com/stretch-section/', __( 'Learn more.', 'wroter' ) ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __( 'Content Width', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'boxed',
				'options' => [
					'boxed' => __( 'Boxed', 'wroter' ),
					'full_width' => __( 'Full Width', 'wroter' ),
				],
				'prefix_class' => 'wroter-section-',
			]
		);

		$this->add_control(
			'content_width',
			[
				'label' => __( 'Content Width', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 500,
						'max' => 1600,
					],
				],
				'selectors' => [
					'{{WRAPPER}} > .wroter-container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => [ 'boxed' ],
				],
				'show_label' => false,
				'separator' => 'none',
			]
		);

		$this->add_control(
			'gap',
			[
				'label' => __( 'Columns Gap', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'wroter' ),
					'no' => __( 'No Gap', 'wroter' ),
					'narrow' => __( 'Narrow', 'wroter' ),
					'extended' => __( 'Extended', 'wroter' ),
					'wide' => __( 'Wide', 'wroter' ),
					'wider' => __( 'Wider', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'height',
			[
				'label' => __( 'Height', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'wroter' ),
					'full' => __( 'Fit To Screen', 'wroter' ),
					'min-height' => __( 'Min Height', 'wroter' ),
				],
				'prefix_class' => 'wroter-section-height-',
				'hide_in_inner' => true,
			]
		);

		$this->add_control(
			'custom_height',
			[
				'label' => __( 'Minimum Height', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 400,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1440,
					],
				],
				'selectors' => [
					'{{WRAPPER}} > .wroter-container' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'height' => [ 'min-height' ],
				],
				'hide_in_inner' => true,
			]
		);

		$this->add_control(
			'height_inner',
			[
				'label' => __( 'Height', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'wroter' ),
					'min-height' => __( 'Min Height', 'wroter' ),
				],
				'prefix_class' => 'wroter-section-height-',
				'hide_in_top' => true,
			]
		);

		$this->add_control(
			'custom_height_inner',
			[
				'label' => __( 'Minimum Height', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 400,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1440,
					],
				],
				'selectors' => [
					'{{WRAPPER}} > .wroter-container' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'height_inner' => [ 'min-height' ],
				],
				'hide_in_top' => true,
			]
		);

		$this->add_control(
			'column_position',
			[
				'label' => __( 'Column Position', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'middle',
				'options' => [
					'stretch' => __( 'Stretch', 'wroter' ),
					'top' => __( 'Top', 'wroter' ),
					'middle' => __( 'Middle', 'wroter' ),
					'bottom' => __( 'Bottom', 'wroter' ),
				],
				'prefix_class' => 'wroter-section-items-',
				'condition' => [
					'height' => [ 'full', 'min-height' ],
				],
			]
		);

		$this->add_control(
			'content_position',
			[
				'label' => __( 'Content Position', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'wroter' ),
					'top' => __( 'Top', 'wroter' ),
					'middle' => __( 'Middle', 'wroter' ),
					'bottom' => __( 'Bottom', 'wroter' ),
				],
				'prefix_class' => 'wroter-section-content-',
			]
		);

		$this->add_control(
			'structure',
			[
				'label' => __( 'Structure', 'wroter' ),
				'type' => Controls_Manager::STRUCTURE,
				'default' => '10',
			]
		);

		$this->end_controls_section();

		// Section background
		$this->start_controls_section(
			'section_background',
			[
				'label' => __( 'Background', 'wroter' ),
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'video' ],
			]
		);

		$this->end_controls_section();

		// Background Overlay
		$this->start_controls_section(
			'background_overlay_section',
			[
				'label' => __( 'Background Overlay', 'wroter' ),
				'tab' => self::TAB_STYLE,
				'condition' => [
					'background_background' => [ 'classic', 'video' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_overlay',
				'selector' => '{{WRAPPER}} > .wroter-background-overlay',
				'condition' => [
					'background_background' => [ 'classic', 'video' ],
				],
			]
		);

		$this->add_control(
			'background_overlay_opacity',
			[
				'label' => __( 'Opacity (%)', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => .5,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} > .wroter-background-overlay' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'background_overlay_background' => [ 'classic' ],
				],
			]
		);

		$this->end_controls_section();

		// Section border
		$this->start_controls_section(
			'section_border',
			[
				'label' => __( 'Border', 'wroter' ),
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}}, {{WRAPPER}} > .wroter-background-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
			]
		);

		$this->end_controls_section();

		// Section Typography
		$this->start_controls_section(
			'section_typo',
			[
				'label' => __( 'Typography', 'wroter' ),
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Heading Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} > .wroter-container .wroter-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'color_text',
			[
				'label' => __( 'Text Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} > .wroter-container' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'color_link',
			[
				'label' => __( 'Link Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} > .wroter-container a' => 'color: {{VALUE}};',
				],
				'tab' => self::TAB_STYLE,
				'section' => 'section_typo',
			]
		);

		$this->add_control(
			'color_link_hover',
			[
				'label' => __( 'Link Hover Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} > .wroter-container a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_align',
			[
				'label' => __( 'Text Align', 'wroter' ),
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
				],
				'selectors' => [
					'{{WRAPPER}} > .wroter-container' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Section Advanced
		$this->start_controls_section(
			'section_advanced',
			[
				'label' => __( 'Advanced', 'wroter' ),
				'tab' => self::TAB_ADVANCED,
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label' => __( 'Margin', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'allowed_dimensions' => 'vertical',
				'placeholder' => [
					'top' => '',
					'right' => 'auto',
					'bottom' => '',
					'left' => 'auto',
				],
				'selectors' => [
					'{{WRAPPER}}' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => __( 'Padding', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label_block' => true,
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
				'default' => '',
				'prefix_class' => '',
				'label_block' => true,
				'title' => __( 'Add your custom class WITHOUT the dot. e.g: my-class', 'wroter' ),
			]
		);

		$this->end_controls_section();

		// Section Responsive
		$this->start_controls_section(
			'_section_responsive',
			[
				'label' => __( 'Responsive', 'wroter' ),
				'tab' => self::TAB_ADVANCED,
			]
		);

		$this->add_control(
			'reverse_order_mobile',
			[
				'label' => __( 'Reverse Columns', 'wroter' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'prefix_class' => 'wroter-',
				'label_on' => __( 'Yes', 'wroter' ),
				'label_off' => __( 'No', 'wroter' ),
				'return_value' => 'reverse-mobile',
				'description' => __( 'Reverse column order - When on mobile, the column order is reversed, so the last column appears on top and vice versa.', 'wroter' ),
			]
		);

		$this->add_control(
			'heading_visibility',
			[
				'label' => __( 'Visibility', 'wroter' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'responsive_description',
			[
				'raw' => __( 'Attention: The display settings (show/hide for mobile, tablet or desktop) will only take effect once you are on the preview or live page, and not while you\'re in editing mode in Wroter.', 'wroter' ),
				'type' => Controls_Manager::RAW_HTML,
				'classes' => 'wroter-control-descriptor',
			]
		);

		$this->add_control(
			'hide_desktop',
			[
				'label' => __( 'Hide On Desktop', 'wroter' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'prefix_class' => 'wroter-',
				'label_on' => __( 'Hide', 'wroter' ),
				'label_off' => __( 'Show', 'wroter' ),
				'return_value' => 'hidden-desktop',
			]
		);

		$this->add_control(
			'hide_tablet',
			[
				'label' => __( 'Hide On Tablet', 'wroter' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'prefix_class' => 'wroter-',
				'label_on' => __( 'Hide', 'wroter' ),
				'label_off' => __( 'Show', 'wroter' ),
				'return_value' => 'hidden-tablet',
			]
		);

		$this->add_control(
			'hide_mobile',
			[
				'label' => __( 'Hide On Mobile', 'wroter' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'prefix_class' => 'wroter-',
				'label_on' => __( 'Hide', 'wroter' ),
				'label_off' => __( 'Show', 'wroter' ),
				'return_value' => 'hidden-phone',
			]
		);

		$this->end_controls_section();
	}

	protected function render_settings() {
		?>
		<div class="wroter-element-overlay"></div>
		<?php
	}

	protected function content_template() {
		?>
		<# if ( 'video' === settings.background_background ) {
			var videoLink = settings.background_video_link;

			if ( videoLink ) {
				var videoID = wroter.helpers.getYoutubeIDFromURL( settings.background_video_link ); #>

				<div class="wroter-background-video-container wroter-hidden-phone">
					<# if ( videoID ) { #>
						<div class="wroter-background-video" data-video-id="{{ videoID }}"></div>
					<# } else { #>
						<video class="wroter-background-video" src="{{ videoLink }}" autoplay loop muted></video>
					<# } #>
				</div>
			<# }

			if ( settings.background_video_fallback ) { #>
				<div class="wroter-background-video-fallback" style="background-image: url({{ settings.background_video_fallback.url }})"></div>
			<# }
		}

		if ( 'classic' === settings.background_overlay_background ) { #>
			<div class="wroter-background-overlay"></div>
		<# } #>
		<div class="wroter-container wroter-column-gap-{{ settings.gap }}" <# if ( settings.get_render_attribute_string ) { #>{{{ settings.get_render_attribute_string( 'wrapper' ) }}} <# } #> >
			<div class="wroter-row"></div>
		</div>
		<?php
	}

	public function before_render( $instance, $element_id, $element_data = [] ) {
		$section_type = ! empty( $element_data['isInner'] ) ? 'inner' : 'top';

		$this->add_render_attribute( 'wrapper', 'class', [
			'wroter-section',
			'wroter-element',
			'wroter-element-' . $element_id,
			'wroter-' . $section_type . '-section',
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
		<section <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
			if ( 'video' === $instance['background_background'] ) :
				if ( $instance['background_video_link'] ) :
					$video_id = Utils::get_youtube_id_from_url( $instance['background_video_link'] );
					?>
					<div class="wroter-background-video-container wroter-hidden-phone">
						<?php if ( $video_id ) : ?>
							<div class="wroter-background-video" data-video-id="<?php echo $video_id; ?>"></div>
						<?php else : ?>
							<video class="wroter-background-video wroter-html5-video" src="<?php echo $instance['background_video_link'] ?>" autoplay loop muted></video>
						<?php endif; ?>
					</div>
				<?php endif;
			endif;

			if ( 'classic' === $instance['background_overlay_background'] ) : ?>
				<div class="wroter-background-overlay"></div>
			<?php endif; ?>
			<div class="wroter-container wroter-column-gap-<?php echo esc_attr( $instance['gap'] ); ?>">
				<div class="wroter-row">
		<?php
	}

	public function after_render( $instance, $element_id, $element_data = [] ) {
		?>
				</div>
			</div>
		</section>
		<?php
	}
}
