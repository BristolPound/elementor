<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Gallery extends Control_Base {

	public function get_type() {
		return 'gallery';
	}

	public function content_template() {
		?>
		<div class="wroter-control-field">
			<div class="wroter-control-input-wrapper">
				<# if ( data.description ) { #>
				<div class="wroter-control-description">{{{ data.description }}}</div>
				<# } #>
				<div class="wroter-control-media">
					<div class="wroter-control-gallery-status">
						<span class="wroter-control-gallery-status-title">
							<# if ( data.controlValue.length ) {
								print( wroter.translate( 'gallery_images_selected', [ data.controlValue.length ] ) );
							} else { #>
								<?php _e( 'No Images Selected', 'wroter' ); ?>
							<# } #>
						</span>
						<span class="wroter-control-gallery-clear">(<?php _e( 'Clear', 'wroter' ); ?>)</span>
					</div>
					<div class="wroter-control-gallery-thumbnails">
						<# _.each( data.controlValue, function( image ) { #>
							<div class="wroter-control-gallery-thumbnail" style="background-image: url({{ image.url }})"></div>
						<# } ); #>
					</div>
					<button class="wroter-button wroter-control-gallery-add"><?php _e( '+ Add Images', 'wroter' ); ?></button>
				</div>
			</div>
		</div>
		<?php
	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
			'separator' => 'none',
		];
	}

	public function get_default_value() {
		return [];
	}
}
