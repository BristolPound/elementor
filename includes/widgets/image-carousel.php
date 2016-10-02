<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Image_Carousel extends Widget_Base {

	public function get_id() {
		return 'image-carousel';
	}

	public function get_title() {
		return __( 'Image Carousel', 'wroter' );
	}

	public function get_icon() {
		return 'slider-push';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_image_carousel',
			[
				'label' => __( 'Image Carousel', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'carousel',
			[
				'label' => __( 'Add Images', 'wroter' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
				'section' => 'section_image_carousel',
			]
		);

		$this->add_group_control(
			Group_Control_Image_size::get_type(),
			[
				'name' => 'thumbnail',
				'section' => 'section_image_carousel',
			]
		);

		$slides_to_show = range( 1, 10 );
		$slides_to_show = array_combine( $slides_to_show, $slides_to_show );

		$this->add_control(
			'slides_to_show',
			[
				'label' => __( 'Slides to Show', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'section' => 'section_image_carousel',
				'options' => $slides_to_show,
			]
		);

		$this->add_control(
			'slides_to_scroll',
			[
				'label' => __( 'Slides to Scroll', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2',
				'section' => 'section_image_carousel',
				'options' => $slides_to_show,
				'condition' => [
					'slides_to_show!' => '1',
				],
			]
		);

		$this->add_control(
			'image_stretch',
			[
				'label' => __( 'Image Stretch', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'section' => 'section_image_carousel',
				'options' => [
					'no' => __( 'No', 'wroter' ),
					'yes' => __( 'Yes', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'both',
				'section' => 'section_image_carousel',
				'options' => [
					'both' => __( 'Arrows and Dots', 'wroter' ),
					'arrows' => __( 'Arrows', 'wroter' ),
					'dots' => __( 'Dots', 'wroter' ),
					'none' => __( 'None', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => __( 'Link to', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'section' => 'section_image_carousel',
				'options' => [
					'none' => __( 'None', 'wroter' ),
					'file' => __( 'Media File', 'wroter' ),
					'custom' => __( 'Custom URL', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => 'Link to',
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'wroter' ),
				'section' => 'section_image_carousel',
				'condition' => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'wroter' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_image_carousel',
			]
		);

		$this->add_control(
			'section_additional_options',
			[
				'label' => __( 'Additional Options', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __( 'Pause on Hover', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'section' => 'section_additional_options',
				'options' => [
					'yes' => __( 'Yes', 'wroter' ),
					'no' => __( 'No', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'section' => 'section_additional_options',
				'options' => [
					'yes' => __( 'Yes', 'wroter' ),
					'no' => __( 'No', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'wroter' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'section' => 'section_additional_options',
			]
		);

		$this->add_control(
			'infinite',
			[
				'label' => __( 'Infinite Loop', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'section' => 'section_additional_options',
				'options' => [
					'yes' => __( 'Yes', 'wroter' ),
					'no' => __( 'No', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'effect',
			[
				'label' => __( 'Effect', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'section' => 'section_additional_options',
				'options' => [
					'slide' => __( 'Slide', 'wroter' ),
					'fade' => __( 'Fade', 'wroter' ),
				],
				'condition' => [
					'slides_to_show' => '1',
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __( 'Animation Speed', 'wroter' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'section' => 'section_additional_options',
			]
		);

		$this->add_control(
			'direction',
			[
				'label' => __( 'Direction', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ltr',
				'section' => 'section_additional_options',
				'options' => [
					'ltr' => __( 'Left', 'wroter' ),
					'rtl' => __( 'Right', 'wroter' ),
				],
			]
		);

		$this->add_control(
			'section_style_navigation',
			[
				'label' => __( 'Navigation', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label' => __( 'Arrows', 'wroter' ),
				'type' => Controls_Manager::HEADING,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => __( 'Arrows Position', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'section' => 'section_style_navigation',
				'tab' => self::TAB_STYLE,
				'options' => [
					'inside' => __( 'Inside', 'wroter' ),
					'outside' => __( 'Outside', 'wroter' ),
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'section' => 'section_style_navigation',
				'tab' => self::TAB_STYLE,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .wroter-image-carousel-wrapper .slick-slider .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => __( 'Arrows Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'selectors' => [
					'{{WRAPPER}} .wroter-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .wroter-image-carousel-wrapper .slick-slider .slick-next:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => __( 'Dots', 'wroter' ),
				'type' => Controls_Manager::HEADING,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => __( 'Dots Position', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'outside',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'options' => [
					'outside' => __( 'Outside', 'wroter' ),
					'inside' => __( 'Inside', 'wroter' ),
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wroter-image-carousel-wrapper .wroter-image-carousel .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => __( 'Dots Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'selectors' => [
					'{{WRAPPER}} .wroter-image-carousel-wrapper .wroter-image-carousel .slick-dots li button:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'section_style_image',
			[
				'label' => __( 'Image', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => __( 'Spacing', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_image',
				'options' => [
					'' => __( 'Default', 'wroter' ),
					'custom' => __( 'Custom', 'wroter' ),
				],
				'default' => '',
				'condition' => [
					'slides_to_show!' => '1',
				],
			]
		);

		$this->add_control(
			'image_spacing_custom',
			[
				'label' => __( 'Image Spacing', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_image',
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 20,
				],
				'show_label' => false,
				'selectors' => [
					'{{WRAPPER}} .slick-list' => 'margin-left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .slick-slide .slick-slide-inner' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image_spacing' => 'custom',
					'slides_to_show!' => '1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_image',
				'selector' => '{{WRAPPER}} .wroter-image-carousel-wrapper .wroter-image-carousel .slick-slide-image',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_image',
				'selectors' => [
					'{{WRAPPER}} .wroter-image-carousel-wrapper .wroter-image-carousel .slick-slide-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	}

	protected function render( $instance = [] ) {
		if ( empty( $instance['carousel'] ) )
			return;

		$slides = [];
		foreach ( $instance['carousel'] as $attachment ) {
			$image_url = Group_Control_Image_size::get_attachment_image_src( $attachment['id'], 'thumbnail', $instance );
			$image_html = '<img class="slick-slide-image" src="' . esc_attr( $image_url ) . '" alt="' . esc_attr( Control_Media::get_image_alt( $attachment ) ) . '" />';

			$link = $this->get_link_url( $attachment, $instance );
			if ( $link ) {
				$target = '';
				if ( ! empty( $link['is_external'] ) ) {
					$target = ' target="_blank"';
				}

				$image_html = sprintf( '<a href="%s"%s>%s</a>', $link['url'], $target, $image_html );
			}

			$slides[] = '<div><div class="slick-slide-inner">' . $image_html . '</div></div>';
		}

		if ( empty( $slides ) ) {
			return;
		}

		$is_slideshow = '1' === $instance['slides_to_show'];
		$is_rtl = ( 'rtl' === $instance['direction'] );
		$direction = $is_rtl ? 'rtl' : 'ltr';
		$show_dots = ( in_array( $instance['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $instance['navigation'], [ 'arrows', 'both' ] ) );

		$slick_options = [
			'slidesToShow' => absint( $instance['slides_to_show'] ),
			'autoplaySpeed' => absint( $instance['autoplay_speed'] ),
			'autoplay' => ( 'yes' === $instance['autoplay'] ),
			'infinite' => ( 'yes' === $instance['infinite'] ),
			'pauseOnHover' => ( 'yes' === $instance['pause_on_hover'] ),
			'speed' => absint( $instance['speed'] ),
			'arrows' => $show_arrows,
			'dots' => $show_dots,
			'rtl' => $is_rtl,
		];

		$carousel_classes = [ 'wroter-image-carousel' ];

		if ( $show_arrows ) {
			$carousel_classes[] = 'slick-arrows-' . $instance['arrows_position'];
		}

		if ( $show_dots ) {
			$carousel_classes[] = 'slick-dots-' . $instance['dots_position'];
		}

		if ( 'yes' === $instance['image_stretch'] ) {
			$carousel_classes[] = 'slick-image-stretch';
		}

		if ( ! $is_slideshow ) {
			$slick_options['slidesToScroll'] = absint( $instance['slides_to_scroll'] );
		} else {
			$slick_options['fade'] = ( 'fade' === $instance['effect'] );
		}

		?>
		<div class="wroter-image-carousel-wrapper wroter-slick-slider" dir="<?php echo $direction; ?>">
			<div class="<?php echo implode( ' ', $carousel_classes ); ?>" data-slider_options='<?php echo wp_json_encode( $slick_options ); ?>'>
				<?php echo implode( '', $slides ); ?>
			</div>
		</div>
	<?php
	}

	protected function content_template() {}

	private function get_link_url( $attachment, $instance ) {
		if ( 'none' === $instance['link_to'] ) {
			return false;
		}

		if ( 'custom' === $instance['link_to'] ) {
			if ( empty( $instance['link']['url'] ) ) {
				return false;
			}
			return $instance['link'];
		}

		return [
			'url' => wp_get_attachment_url( $attachment['id'] ),
		];
	}
}
