<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Image_Gallery extends Widget_Base {

	public function get_id() {
		return 'image-gallery';
	}

	public function get_title() {
		return __( 'Image Gallery', 'wroter' );
	}

	public function get_icon() {
		return 'gallery-grid';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_gallery',
			[
				'label' => __( 'Image Gallery', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'wp_gallery',
			[
				'label' => __( 'Add Images', 'wroter' ),
				'type' => Controls_Manager::GALLERY,
				'section' => 'section_gallery',
			]
		);

		$this->add_group_control(
			Group_Control_Image_size::get_type(),
			[
				'name' => 'thumbnail',
				'exclude' => [ 'custom' ],
				'section' => 'section_gallery',
			]
		);

		$gallery_columns = range( 1, 10 );
		$gallery_columns = array_combine( $gallery_columns, $gallery_columns );

		$this->add_control(
			'gallery_columns',
			[
				'label' => __( 'Columns', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 4,
				'options' => $gallery_columns,
				'section' => 'section_gallery',
			]
		);

		$this->add_control(
			'gallery_link',
			[
				'label' => __( 'Link to', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'file',
				'section' => 'section_gallery',
				'options' => [
					'file' => __( 'Media File', 'wroter' ),
					'attachment' => __( 'Attachment Page', 'wroter' ),
					'none' => __( 'None', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'gallery_rand',
			[
				'label' => __( 'Ordering', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_gallery',
				'options' => [
					'' => __( 'Default', 'wroter' ),
					'rand' => __( 'Random', 'wroter' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'wroter' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_gallery',
			]
		);

		$this->add_control(
			'section_gallery_images',
			[
				'label' => __( 'Images', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => __( 'Spacing', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_gallery_images',
				'tab' => self::TAB_STYLE,
				'options' => [
					'' => __( 'Default', 'wroter' ),
					'custom' => __( 'Custom', 'wroter' ),
				],
				'prefix_class' => 'gallery-spacing-',
				'default' => '',
			]
		);

		$columns_margin = is_rtl() ? '0 0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}};' : '0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}} 0;';
		$columns_padding = is_rtl() ? '0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};' : '0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;';

		$this->add_control(
			'image_spacing_custom',
			[
				'label' => __( 'Image Spacing', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'section' => 'section_gallery_images',
				'tab' => self::TAB_STYLE,
				'show_label' => false,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-item' => 'padding:' . $columns_padding,
					'{{WRAPPER}} .gallery' => 'margin: ' . $columns_margin,
				],
				'condition' => [
					'image_spacing' => 'custom',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => __( 'Image Border', 'wroter' ),
				'tab' => self::TAB_STYLE,
				'section' => 'section_gallery_images',
				'selector' => '{{WRAPPER}} .gallery-item img',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_gallery_images',
				'selectors' => [
					'{{WRAPPER}} .gallery-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_caption',
			[
				'label' => __( 'Caption', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'gallery_display_caption',
			[
				'label' => __( 'Display', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_caption',
				'tab' => self::TAB_STYLE,
				'default' => '',
				'options' => [
					'' => __( 'Show', 'wroter' ),
					'none' => __( 'Hide', 'wroter' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'display: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'align',
			[
				'label' => __( 'Alignment', 'wroter' ),
				'type' => Controls_Manager::CHOOSE,
				'tab' => self::TAB_STYLE,
				'section' => 'section_caption',
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'gallery_display_caption' => '',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_caption',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'color: {{VALUE}};',
				],
				'condition' => [
					'gallery_display_caption' => '',
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
				'section' => 'section_caption',
				'selector' => '{{WRAPPER}} .gallery-item .gallery-caption',
				'condition' => [
					'gallery_display_caption' => '',
				],
			]
		);
	}

	protected function render( $instance = [] ) {
		if ( ! $instance['wp_gallery'] ) {
			return;
		}

		$ids = wp_list_pluck( $instance['wp_gallery'], 'id' );

		$this->add_render_attribute( 'shortcode', 'ids', implode( ',', $ids ) );
		$this->add_render_attribute( 'shortcode', 'size', $instance['thumbnail_size'] );

		if ( $instance['gallery_columns'] ) {
			$this->add_render_attribute( 'shortcode', 'columns', $instance['gallery_columns'] );
		}

		if ( $instance['gallery_link'] ) {
			$this->add_render_attribute( 'shortcode', 'link', $instance['gallery_link'] );
		}

		if ( ! empty( $instance['gallery_rand'] ) ) {
			$this->add_render_attribute( 'shortcode', 'orderby', $instance['gallery_rand'] );
		}
		?>
		<div class="wroter-image-gallery">
			<?php echo do_shortcode( '[gallery ' . $this->get_render_attribute_string( 'shortcode' ) . ']' ); ?>
		</div>
		<?php
	}

	protected function content_template() {}
}
