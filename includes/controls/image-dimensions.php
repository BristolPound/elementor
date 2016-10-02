<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Image_Dimensions extends Control_Base_Multiple {

	public function get_type() {
		return 'image_dimensions';
	}

	public function get_default_value() {
		return [
			'width' => '',
			'height' => '',
		];
	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
			'show_label' => false,
		];
	}

	public function content_template() {
		if ( ! $this->_is_image_editor_supports() ) : ?>
		<div class="panel-alert panel-alert-danger">
			<?php _e( 'The server does not have ImageMagick or GD installed and/or enabled! Any of these libraries are required for WordPress to be able to resize images. Please contact your server administrator to enable this before continuing.', 'wroter' ); ?>
		</div>
		<?php
			return;
		endif;
		?>
		<# if ( data.description ) { #>
			<div class="wroter-control-description">{{{ data.description }}}</div>
		<# } #>
		<div class="wroter-control-field">
			<label class="wroter-control-title">{{{ data.label }}}</label>
			<div class="wroter-control-input-wrapper">
				<div class="wroter-image-dimensions-field">
					<input type="text" data-setting="width" />
					<div class="wroter-image-dimensions-field-description"><?php _e( 'Width', 'wroter' ); ?></div>
				</div>
				<div class="wroter-image-dimensions-separator">x</div>
				<div class="wroter-image-dimensions-field">
					<input type="text" data-setting="height" />
					<div class="wroter-image-dimensions-field-description"><?php _e( 'Height', 'wroter' ); ?></div>
				</div>
				<button class="wroter-button wroter-button-success wroter-image-dimensions-apply-button"><?php _e( 'Apply', 'wroter' ); ?></button>
			</div>
		</div>
		<?php
	}

	private function _is_image_editor_supports() {
		$arg = [ 'mime_type' => 'image/jpeg' ];
		return ( wp_image_editor_supports( $arg ) );
	}
}
