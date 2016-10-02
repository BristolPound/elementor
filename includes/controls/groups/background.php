<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Group_Control_Background extends Group_Control_Base {

	public static function get_type() {
		return 'background';
	}

	protected function _get_child_default_args() {
		return [
			'types' => [ 'classic' ],
		];
	}

	protected function _get_controls( $args ) {
		$available_types = [
			'classic' => [
				'title' => _x( 'Classic', 'Background Control', 'wroter' ),
				'icon' => 'paint-brush',
			],
			'video' => [
				'title' => _x( 'Background Video', 'Background Control', 'wroter' ),
				'icon' => 'video-camera',
			],
		];

		$choose_types = [
			'none' => [
				'title' => _x( 'None', 'Background Control', 'wroter' ),
				'icon' => 'ban',
			],
		];

		foreach ( $args['types'] as $type ) {
			if ( isset( $available_types[ $type ] ) ) {
				$choose_types[ $type ] = $available_types[ $type ];
			}
		}

		$controls = [];

		$controls['background'] = [
			'label' => _x( 'Background Type', 'Background Control', 'wroter' ),
			'type' => Controls_Manager::CHOOSE,
			'default' => $args['default'],
			'options' => $choose_types,
			'label_block' => true,
		];

		// Background:color
		if ( in_array( 'classic', $args['types'] ) ) {
			$controls['color'] = [
				'label' => _x( 'Color', 'Background Control', 'wroter' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'tab' => $args['tab'],
				'title' => _x( 'Background Color', 'Background Control', 'wroter' ),
				'selectors' => [
					$args['selector'] => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'background' => [ 'classic' ],
				],
			];
		}
		// End Background:color

		// Background:image
		if ( in_array( 'classic', $args['types'] ) ) {
			$controls['image'] = [
				'label' => _x( 'Image', 'Background Control', 'wroter' ),
				'type' => Controls_Manager::MEDIA,
				'title' => _x( 'Background Image', 'Background Control', 'wroter' ),
				'selectors' => [
					$args['selector'] => 'background-image: url("{{URL}}");',
				],
				'condition' => [
					'background' => [ 'classic' ],
				],
			];

			$controls['position'] = [
				'label' => _x( 'Position', 'Background Control', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => _x( 'None', 'Background Control', 'wroter' ),
					'top left' => _x( 'Top Left', 'Background Control', 'wroter' ),
					'top center' => _x( 'Top Center', 'Background Control', 'wroter' ),
					'top right' => _x( 'Top Right', 'Background Control', 'wroter' ),
					'center left' => _x( 'Center Left', 'Background Control', 'wroter' ),
					'center center' => _x( 'Center Center', 'Background Control', 'wroter' ),
					'center right' => _x( 'Center Right', 'Background Control', 'wroter' ),
					'bottom left' => _x( 'Bottom Left', 'Background Control', 'wroter' ),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'wroter' ),
					'bottom right' => _x( 'Bottom Right', 'Background Control', 'wroter' ),
				],
				'selectors' => [
					$args['selector'] => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'background' => [ 'classic' ],
					'image[url]!' => '',
				],
			];

			$controls['attachment'] = [
				'label' => _x( 'Attachment', 'Background Control', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => _x( 'None', 'Background Control', 'wroter' ),
					'scroll' => _x( 'Scroll', 'Background Control', 'wroter' ),
					'fixed' => _x( 'Fixed', 'Background Control', 'wroter' ),
				],
				'selectors' => [
					$args['selector'] => 'background-attachment: {{VALUE}};',
				],
				'condition' => [
					'background' => [ 'classic' ],
					'image[url]!' => '',
				],
			];

			$controls['repeat'] = [
				'label' => _x( 'Repeat', 'Background Control', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => _x( 'None', 'Background Control', 'wroter' ),
					'no-repeat' => _x( 'No-repeat', 'Background Control', 'wroter' ),
					'repeat' => _x( 'Repeat', 'Background Control', 'wroter' ),
					'repeat-x' => _x( 'Repeat-x', 'Background Control', 'wroter' ),
					'repeat-y' => _x( 'Repeat-y', 'Background Control', 'wroter' ),
				],
				'selectors' => [
					$args['selector'] => 'background-repeat: {{VALUE}};',
				],
				'condition' => [
					'background' => [ 'classic' ],
					'image[url]!' => '',
				],
			];

			$controls['size'] = [
				'label' => _x( 'Size', 'Background Control', 'wroter' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => _x( 'None', 'Background Control', 'wroter' ),
					'auto' => _x( 'Auto', 'Background Control', 'wroter' ),
					'cover' => _x( 'Cover', 'Background Control', 'wroter' ),
					'contain' => _x( 'Contain', 'Background Control', 'wroter' ),
				],
				'selectors' => [
					$args['selector'] => 'background-size: {{VALUE}};',
				],
				'condition' => [
					'background' => [ 'classic' ],
					'image[url]!' => '',
				],
			];
		}
		// End Background:image

		// Background:video
		$controls['video_link'] = [
			'label' => _x( 'Video Link', 'Background Control', 'wroter' ),
			'type' => Controls_Manager::TEXT,
			'placeholder' => 'https://www.youtube.com/watch?v=9uOETcuFjbE',
			'description' => __( 'Insert YouTube link or video file (mp4 is recommended)', 'wroter' ),
			'label_block' => true,
			'default' => '',
			'condition' => [
				'background' => [ 'video' ],
			],
		];

		$controls['video_fallback'] = [
			'label' => _x( 'Background Fallback', 'Background Control', 'wroter' ),
			'description' => __( 'This cover image will replace the background video on mobile or tablet.', 'wroter' ),
			'type' => Controls_Manager::MEDIA,
			'label_block' => true,
			'condition' => [
				'background' => [ 'video' ],
			],
			'selectors' => [
				$args['selector'] => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
			],
		];
		// End Background:video

		return $controls;
	}
}
