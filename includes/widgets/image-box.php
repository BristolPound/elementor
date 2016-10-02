<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Image_box extends Widget_Base {

	public function get_id() {
		return 'image-box';
	}

	public function get_title() {
		return __( 'Image Box', 'wroter' );
	}

	public function get_icon() {
		return 'image-box';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_image',
			[
				'label' => __( 'Image Box', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'wroter' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'section' => 'section_image',
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => __( 'Title & Description', 'wroter' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'wroter' ),
				'placeholder' => __( 'Your Title', 'wroter' ),
				'section' => 'section_image',
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text',
			[
				'label' => __( 'Content', 'wroter' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'wroter' ),
				'placeholder' => __( 'Your Description', 'wroter' ),
				'title' => __( 'Input image text here', 'wroter' ),
				'section' => 'section_image',
				'separator' => 'none',
				'rows' => 10,
				'show_label' => false,
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link to', 'wroter' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'wroter' ),
				'section' => 'section_image',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'position',
			[
				'label' => __( 'Image Position', 'wroter' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'wroter' ),
						'icon' => 'align-left',
					],
					'top' => [
						'title' => __( 'Top', 'wroter' ),
						'icon' => 'align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wroter' ),
						'icon' => 'align-right',
					],
				],
				'prefix_class' => 'wroter-position-',
				'toggle' => false,
				'section' => 'section_image',
			]
		);

		$this->add_control(
			'title_size',
			[
				'label' => __( 'Title HTML Tag', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'wroter' ),
					'h2' => __( 'H2', 'wroter' ),
					'h3' => __( 'H3', 'wroter' ),
					'h4' => __( 'H4', 'wroter' ),
					'h5' => __( 'H5', 'wroter' ),
					'h6' => __( 'H6', 'wroter' ),
					'div' => __( 'div', 'wroter' ),
					'span' => __( 'span', 'wroter' ),
					'p' => __( 'p', 'wroter' ),
				],
				'default' => 'h3',
				'section' => 'section_image',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'wroter' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_content',
			]
		);

		$this->add_control(
			'section_style_image',
			[
				'type'  => Controls_Manager::SECTION,
				'label' => __( 'Image', 'wroter' ),
				'tab'   => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_space',
			[
				'label' => __( 'Image Spacing', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'section' => 'section_style_image',
				'tab' => self::TAB_STYLE,
				'selectors' => [
					'{{WRAPPER}}.wroter-position-right .wroter-image-box-img' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.wroter-position-left .wroter-image-box-img' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.wroter-position-top .wroter-image-box-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => __( 'Image Size', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'section' => 'section_style_image',
				'tab' => self::TAB_STYLE,
				'selectors' => [
					'{{WRAPPER}} .wroter-image-box-wrapper .wroter-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity (%)', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'section' => 'section_style_image',
				'tab' => self::TAB_STYLE,
				'selectors' => [
					'{{WRAPPER}} .wroter-image-box-wrapper .wroter-image-box-img img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Animation', 'wroter' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_image',
			]
		);

		$this->add_control(
			'section_style_content',
			[
				'type'  => Controls_Manager::SECTION,
				'label' => __( 'Content', 'wroter' ),
				'tab'   => self::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'wroter' ),
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
					'justify' => [
						'title' => __( 'Justified', 'wroter' ),
						'icon' => 'align-justify',
					],
				],
				'section' => 'section_style_content',
				'tab' => self::TAB_STYLE,
				'selectors' => [
					'{{WRAPPER}} .wroter-image-box-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_vertical_alignment',
			[
				'label' => __( 'Vertical Alignment', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top' => __( 'Top', 'wroter' ),
					'middle' => __( 'Middle', 'wroter' ),
					'bottom' => __( 'Bottom', 'wroter' ),
				],
				'default' => 'top',
				'section' => 'section_style_content',
				'tab' => self::TAB_STYLE,
				'prefix_class' => 'wroter-vertical-align-',
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => __( 'Title', 'wroter' ),
				'type' => Controls_Manager::HEADING,
				'section' => 'section_style_content',
				'tab' => self::TAB_STYLE,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_bottom_space',
			[
				'label' => __( 'Title Spacing', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'section' => 'section_style_content',
				'tab' => self::TAB_STYLE,
				'selectors' => [
					'{{WRAPPER}} .wroter-image-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-image-box-content .wroter-image-box-title' => 'color: {{VALUE}};',
				],
				'section' => 'section_style_content',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .wroter-image-box-content .wroter-image-box-title',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_content',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label' => __( 'Description', 'wroter' ),
				'type' => Controls_Manager::HEADING,
				'section' => 'section_style_content',
				'tab' => self::TAB_STYLE,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Description Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-image-box-content .wroter-image-box-description' => 'color: {{VALUE}};',
				],
				'section' => 'section_style_content',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .wroter-image-box-content .wroter-image-box-description',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_content',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);
	}

	protected function render( $instance = [] ) {
		$has_content = ! empty( $instance['title_text'] ) || ! empty( $instance['description_text'] );

		$html = '<div class="wroter-image-box-wrapper">';

		if ( ! empty( $instance['image']['url'] ) ) {
			$this->add_render_attribute( 'image', 'src', $instance['image']['url'] );
			$this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $instance['image'] ) );
			$this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $instance['image'] ) );

			if ( $instance['hover_animation'] ) {
				$this->add_render_attribute( 'image', 'class', 'wroter-animation-' . $instance['hover_animation'] );
			}

			$image_html = '<img ' . $this->get_render_attribute_string( 'image' ) . '>';

			if ( ! empty( $instance['link']['url'] ) ) {
				$target = '';
				if ( ! empty( $instance['link']['is_external'] ) ) {
					$target = ' target="_blank"';
				}
				$image_html = sprintf( '<a href="%s"%s>%s</a>', $instance['link']['url'], $target, $image_html );
			}

			$html .= '<figure class="wroter-image-box-img">' . $image_html . '</figure>';
		}

		if ( $has_content ) {
			$html .= '<div class="wroter-image-box-content">';

			if ( ! empty( $instance['title_text'] ) ) {
				$title_html = $instance['title_text'];

				if ( ! empty( $instance['link']['url'] ) ) {
					$target = '';

					if ( ! empty( $instance['link']['is_external'] ) ) {
						$target = ' target="_blank"';
					}

					$title_html = sprintf( '<a href="%s"%s>%s</a>', $instance['link']['url'], $target, $title_html );
				}

				$html .= sprintf( '<%1$s class="wroter-image-box-title">%2$s</%1$s>', $instance['title_size'], $title_html );
			}

			if ( ! empty( $instance['description_text'] ) ) {
				$html .= sprintf( '<p class="wroter-image-box-description">%s</p>', $instance['description_text'] );
			}

			$html .= '</div>';
		}

		$html .= '</div>';

		echo $html;
	}

	protected function content_template() {
		?>
		<#
		var html = '<div class="wroter-image-box-wrapper">';

		if ( settings.image.url ) {
			var imageHtml = '<img src="' + settings.image.url + '" class="wroter-animation-' + settings.hover_animation + '" />';

			if ( settings.link.url ) {
				imageHtml = '<a href="' + settings.link.url + '">' + imageHtml + '</a>';
			}

			html += '<figure class="wroter-image-box-img">' + imageHtml + '</figure>';
		}

		var hasContent = !! ( settings.title_text || settings.description_text );

		if ( hasContent ) {
			html += '<div class="wroter-image-box-content">';

			if ( settings.title_text ) {
				var title_html = settings.title_text;

				if ( settings.link.url ) {
					title_html = '<a href="' + settings.link.url + '">' + title_html + '</a>';
				}

				html += '<' + settings.title_size  + ' class="wroter-image-box-title">' + title_html + '</' + settings.title_size  + '>';
			}

			if ( settings.description_text ) {
				html += '<p class="wroter-image-box-description">' + settings.description_text + '</p>';
			}

			html += '</div>';
		}

		html += '</div>';

		print( html );
		#>
		<?php
	}
}
