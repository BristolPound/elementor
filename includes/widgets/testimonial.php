<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Testimonial extends Widget_Base {

	public function get_id() {
		return 'testimonial';
	}

	public function get_title() {
		return __( 'Testimonial', 'wroter' );
	}

	public function get_icon() {
		return 'testimonial';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_testimonial',
			[
				'label' => __( 'Testimonial', 'wroter' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'testimonial_content',
			[
				'label' => __( 'Content', 'wroter' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => '10',
				'default' => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
				'section' => 'section_testimonial',
			]
		);

		$this->add_control(
			'testimonial_image',
			[
				'label' => __( 'Add Image', 'wroter' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'section' => 'section_testimonial',
			]
		);

		$this->add_control(
			'testimonial_name',
			[
				'label' => __( 'Name', 'wroter' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'John Doe',
				'section' => 'section_testimonial',
			]
		);

		$this->add_control(
			'testimonial_job',
			[
				'label' => __( 'Job', 'wroter' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Designer',
				'section' => 'section_testimonial',
			]
		);

		$this->add_control(
			'testimonial_image_position',
			[
				'label' => __( 'Image Position', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'aside',
				'section' => 'section_testimonial',
				'options' => [
					'aside' => __( 'Aside', 'wroter' ),
					'top' => __( 'Top', 'wroter' ),
				],
				'condition' => [
					'testimonial_image[url]!' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'testimonial_alignment',
			[
				'label' => __( 'Alignment', 'wroter' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'section' => 'section_testimonial',
				'options' => [
					'left'    => [
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

		// Content
		$this->add_control(
			'section_style_testimonial_content',
			[
				'label' => __( 'Content', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_content_color',
			[
				'label' => __( 'Content Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_testimonial_content',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-testimonial-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'wroter' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_testimonial_content',
				'selector' => '{{WRAPPER}} .wroter-testimonial-content',
			]
		);

		// Image
		$this->add_control(
			'section_style_testimonial_image',
			[
				'label' => __( 'Image', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
				'condition' => [
					'testimonial_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => __( 'Image Size', 'wroter' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 200,
					],
				],
				'section' => 'section_style_testimonial_image',
				'tab' => self::TAB_STYLE,
				'selectors' => [
					'{{WRAPPER}} .wroter-testimonial-wrapper .wroter-testimonial-image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'testimonial_image[url]!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_testimonial_image',
				'selector' => '{{WRAPPER}} .wroter-testimonial-wrapper .wroter-testimonial-image img',
				'condition' => [
					'testimonial_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'wroter' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_testimonial_image',
				'selectors' => [
					'{{WRAPPER}} .wroter-testimonial-wrapper .wroter-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'testimonial_image[url]!' => '',
				],
			]
		);

		// Name
		$this->add_control(
			'section_style_testimonial_name',
			[
				'label' => __( 'Name', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_text_color',
			[
				'label' => __( 'Text Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_testimonial_name',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-testimonial-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'label' => __( 'Typography', 'wroter' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_testimonial_name',
				'selector' => '{{WRAPPER}} .wroter-testimonial-name',
			]
		);

		// Job
		$this->add_control(
			'section_style_testimonial_job',
			[
				'label' => __( 'Job', 'wroter' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'job_text_color',
			[
				'label' => __( 'Text Color', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_testimonial_job',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wroter-testimonial-job' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'job_typography',
				'label' => __( 'Typography', 'wroter' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_testimonial_job',
				'selector' => '{{WRAPPER}} .wroter-testimonial-job',
			]
		);
	}

	protected function render( $instance = [] ) {
		if ( empty( $instance['testimonial_name'] ) || empty( $instance['testimonial_content'] ) )
			return;

		$has_image = false;
		if ( '' !== $instance['testimonial_image']['url'] ) {
			$image_url = $instance['testimonial_image']['url'];
			$has_image = ' wroter-has-image';
		}

		$testimonial_alignment = $instance['testimonial_alignment'] ? ' wroter-testimonial-text-align-' . $instance['testimonial_alignment'] : '';
		$testimonial_image_position = $instance['testimonial_image_position'] ? ' wroter-testimonial-image-position-' . $instance['testimonial_image_position'] : '';
		?>
		<div class="wroter-testimonial-wrapper<?php echo $testimonial_alignment; ?>">

			<?php if ( ! empty( $instance['testimonial_content'] ) ) : ?>
				<div class="wroter-testimonial-content">
						<?php echo $instance['testimonial_content']; ?>
				</div>
			<?php endif; ?>

			<div class="wroter-testimonial-meta<?php if ( $has_image ) echo $has_image; ?><?php echo $testimonial_image_position; ?>">
				<div class="wroter-testimonial-meta-inner">
					<?php if ( isset( $image_url ) ) : ?>
						<div class="wroter-testimonial-image">
							<img src="<?php echo esc_attr( $image_url ); ?>" alt="<?php echo esc_attr( Control_Media::get_image_alt( $instance['testimonial_image'] ) ); ?>" />
						</div>
					<?php endif; ?>

					<div class="wroter-testimonial-details">
						<?php if ( ! empty( $instance['testimonial_name'] ) ) : ?>
							<div class="wroter-testimonial-name">
								<?php echo $instance['testimonial_name']; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $instance['testimonial_job'] ) ) : ?>
							<div class="wroter-testimonial-job">
								<?php echo $instance['testimonial_job']; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}

	protected function content_template() {
		?>
		<#
		var imageUrl = false, hasImage = '';
		if ( '' !== settings.testimonial_image.url ) {
			imageUrl = settings.testimonial_image.url;
			hasImage = ' wroter-has-image';
		}

		var testimonial_alignment = settings.testimonial_alignment ? ' wroter-testimonial-text-align-' + settings.testimonial_alignment : '';
		var testimonial_image_position = settings.testimonial_image_position ? ' wroter-testimonial-image-position-' + settings.testimonial_image_position : '';
		#>
		<div class="wroter-testimonial-wrapper{{ testimonial_alignment }}">

			<# if ( '' !== settings.testimonial_content ) { #>
				<div class="wroter-testimonial-content">
					{{{ settings.testimonial_content }}}
				</div>
		    <# } #>

			<div class="wroter-testimonial-meta{{ hasImage }}{{ testimonial_image_position }}">
				<div class="wroter-testimonial-meta-inner">
					<# if ( imageUrl ) { #>
					<div class="wroter-testimonial-image">
						<img src="{{ imageUrl }}" alt="testimonial" />
					</div>
					<# } #>

					<div class="wroter-testimonial-details">

						<# if ( '' !== settings.testimonial_name ) { #>
						<div class="wroter-testimonial-name">
							{{{ settings.testimonial_name }}}
						</div>
						<# } #>

						<# if ( '' !== settings.testimonial_job ) { #>
						<div class="wroter-testimonial-job">
							{{{ settings.testimonial_job }}}
						</div>
						<# } #>

					</div>
				</div>
			</div>
		</div>
	<?php
	}
}
