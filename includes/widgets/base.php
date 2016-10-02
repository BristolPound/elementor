<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Widget_Base extends Element_Base {

	public function get_type() {
		return 'widget';
	}

	public function get_icon() {
		return 'font';
	}

	public function get_short_title() {
		return $this->get_title();
	}

	public function parse_text_editor( $content, $instance = [] ) {
		$content = apply_filters( 'widget_text', $content, $instance );

		$content = shortcode_unautop( $content );
		$content = do_shortcode( $content );

		if ( $GLOBALS['wp_embed'] instanceof \WP_Embed ) {
			$content = $GLOBALS['wp_embed']->autoembed( $content );
		}

		return $content;
	}

	protected function _after_register_controls() {
		parent::_after_register_controls();

		$this->add_control(
			'_section_style',
			[
				'label' => __( 'Element Style', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_ADVANCED,
			]
		);

	    $this->add_responsive_control(
	        '_margin',
	        [
	            'label' => __( 'Margin', 'wroter' ),
	            'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
	            'tab' => self::TAB_ADVANCED,
	            'section' => '_section_style',
	            'selectors' => [
	                '{{WRAPPER}} .wroter-widget-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	        ]
	    );

	    $this->add_responsive_control(
	        '_padding',
	        [
	            'label' => __( 'Padding', 'wroter' ),
	            'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
	            'tab' => self::TAB_ADVANCED,
	            'section' => '_section_style',
	            'selectors' => [
	                '{{WRAPPER}} .wroter-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ],
	        ]
	    );

		$this->add_control(
			'_animation',
			[
				'label' => __( 'Entrance Animation', 'wroter' ),
				'type' => Controls_Manager::ANIMATION,
				'default' => '',
				'prefix_class' => 'animated ',
				'tab' => self::TAB_ADVANCED,
				'label_block' => true,
				'section' => '_section_style',
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
				'section' => '_section_style',
				'condition' => [
					'_animation!' => '',
				],
			]
		);

		$this->add_control(
			'_css_classes',
			[
				'label' => __( 'CSS Classes', 'wroter' ),
				'type' => Controls_Manager::TEXT,
				'tab' => self::TAB_ADVANCED,
				'section' => '_section_style',
				'default' => '',
				'prefix_class' => '',
				'label_block' => true,
				'title' => __( 'Add your custom class WITHOUT the dot. e.g: my-class', 'wroter' ),
			]
		);

		$this->add_control(
			'_section_background',
			[
				'label' => __( 'Background & Border', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_ADVANCED,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => '_background',
				'tab' => self::TAB_ADVANCED,
				'section' => '_section_background',
				'selector' => '{{WRAPPER}} .wroter-widget-container',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_border',
				'tab' => self::TAB_ADVANCED,
				'section' => '_section_background',
				'selector' => '{{WRAPPER}} .wroter-widget-container',
			]
		);

		$this->add_control(
			'_border_radius',
			[
				'label' => __( 'Border Radius', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'tab' => self::TAB_ADVANCED,
				'section' => '_section_background',
				'selectors' => [
					'{{WRAPPER}} .wroter-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => '_box_shadow',
				'section' => '_section_background',
				'tab' => self::TAB_ADVANCED,
				'selector' => '{{WRAPPER}} .wroter-widget-container',
			]
		);

		$this->add_control(
			'_section_responsive',
			[
				'label' => __( 'Responsive', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_ADVANCED,
			]
		);

		$this->add_control(
			'responsive_description',
			[
				'raw' => __( 'Attention: The display settings (show/hide for mobile, tablet or desktop) will only take effect once you are on the preview or live page, and not while you\'re in editing mode in Wroter.', 'wroter' ),
				'type' => Controls_Manager::RAW_HTML,
				'tab' => self::TAB_ADVANCED,
				'section' => '_section_responsive',
				'classes' => 'wroter-control-descriptor',
			]
		);

		$this->add_control(
			'hide_desktop',
			[
				'label' => __( 'Hide On Desktop', 'wroter' ),
				'type' => Controls_Manager::SWITCHER,
				'tab' => self::TAB_ADVANCED,
				'section' => '_section_responsive',
				'default' => '',
				'prefix_class' => 'wroter-',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hidden-desktop',
			]
		);

		$this->add_control(
			'hide_tablet',
			[
				'label' => __( 'Hide On Tablet', 'wroter' ),
				'type' => Controls_Manager::SWITCHER,
				'tab' => self::TAB_ADVANCED,
				'section' => '_section_responsive',
				'default' => '',
				'prefix_class' => 'wroter-',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hidden-tablet',
			]
		);

		$this->add_control(
			'hide_mobile',
			[
				'label' => __( 'Hide On Mobile', 'wroter' ),
				'type' => Controls_Manager::SWITCHER,
				'tab' => self::TAB_ADVANCED,
				'section' => '_section_responsive',
				'default' => '',
				'prefix_class' => 'wroter-',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hidden-phone',
			]
		);
	}

	final public function print_template() {
		ob_start();
		$this->content_template();
		$content_template = ob_get_clean();

		$content_template = apply_filters( 'wroter/widget/print_template', $content_template,  $this );

		if ( empty( $content_template ) ) {
			return;
		}
		?>
		<script type="text/html" id="tmpl-wroter-<?php echo $this->get_type(); ?>-<?php echo esc_attr( $this->get_id() ); ?>-content">
			<?php $this->render_settings(); ?>
			<div class="wroter-widget-container">
				<?php echo $content_template; ?>
			</div>
		</script>
		<?php
	}

	public function render_content( $instance ) {
		if ( Plugin::instance()->editor->is_edit_mode() ) {
			$this->render_settings();
		}
		?>
		<div class="wroter-widget-container">
			<?php
			ob_start();
			$this->render( $instance );
			$content = ob_get_clean();

			$content = apply_filters( 'wroter/widget/render_content', $content, $instance, $this );

			echo $content;
			?>
		</div>
		<?php
	}

	public function render_plain_content( $instance = [] ) {
		$this->render_content( $instance );
	}

	protected function render_settings() {
		?>
		<div class="wroter-editor-element-settings wroter-editor-<?php echo esc_attr( $this->get_type() ); ?>-settings wroter-editor-<?php echo esc_attr( $this->get_id() ); ?>-settings">
			<ul class="wroter-editor-element-settings-list">
				<li class="wroter-editor-element-setting wroter-editor-element-edit">
					<a href="#" title="<?php _e( 'Edit', 'wroter' ); ?>">
						<span class="wroter-screen-only"><?php _e( 'Edit', 'wroter' ); ?></span>
						<i class="fa fa-pencil"></i>
					</a>
				</li>
				<li class="wroter-editor-element-setting wroter-editor-element-duplicate">
					<a href="#" title="<?php _e( 'Duplicate', 'wroter' ); ?>">
						<span class="wroter-screen-only"><?php _e( 'Duplicate', 'wroter' ); ?></span>
						<i class="fa fa-files-o"></i>
					</a>
				</li>
				<li class="wroter-editor-element-setting wroter-editor-element-remove">
					<a href="#" title="<?php _e( 'Remove', 'wroter' ); ?>">
						<span class="wroter-screen-only"><?php _e( 'Remove', 'wroter' ); ?></span>
						<i class="fa fa-times"></i>
					</a>
				</li>
			</ul>
		</div>
		<?php
	}

	public function before_render( $instance, $element_id, $element_data = [] ) {
		$this->add_render_attribute( 'wrapper', 'class', [
			'wroter-widget',
			'wroter-element',
			'wroter-element-' . $element_id,
			'wroter-widget-' . $this->get_id(),
		] );

		foreach ( $this->get_class_controls() as $control ) {
			if ( empty( $instance[ $control['name'] ] ) )
				continue;

			if ( ! $this->is_control_visible( $instance, $control ) )
				continue;

			$this->add_render_attribute( 'wrapper', 'class', $control['prefix_class'] . $instance[ $control['name'] ] );
		}

		if ( ! empty( $instance['_animation'] ) ) {
			$this->add_render_attribute( 'wrapper', 'data-animation', $instance['_animation'] );
		}

		$this->add_render_attribute( 'wrapper', 'data-element_type', $this->get_id() );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
		<?php
	}

	public function after_render( $instance, $element_id, $element_data = [] ) {
		?>
		</div>
		<?php
	}
}
