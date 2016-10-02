<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_URL extends Control_Base_Multiple {

	public function get_type() {
		return 'url';
	}

	public function get_default_value() {
		return [
			'is_external' => '',
			'url' => '',
		];
	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
			'show_external' => true,
		];
	}

	public function content_template() {
		?>
		<div class="wroter-control-field wroter-control-url-external-{{{ data.show_external ? 'show' : 'hide' }}}">
			<label class="wroter-control-title">{{{ data.label }}}</label>
			<div class="wroter-control-input-wrapper">
				<input type="url" data-setting="url" placeholder="{{ data.placeholder }}" />
				<button class="wroter-control-url-target tooltip-target" data-tooltip="<?php _e( 'Open Link in new Tab', 'wroter' ); ?>" title="<?php esc_attr_e( 'Open Link in new Tab', 'wroter' ); ?>">
					<span class="wroter-control-url-external" title="<?php esc_attr_e( 'New Window', 'wroter' ); ?>"><i class="fa fa-external-link"></i></span>
				</button>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="wroter-control-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
