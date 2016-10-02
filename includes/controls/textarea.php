<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Textarea extends Control_Base {

	public function get_type() {
		return 'textarea';
	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
		];
	}

	public function content_template() {
		?>
		<div class="wroter-control-field">
			<label class="wroter-control-title">{{{ data.label }}}</label>
			<div class="wroter-control-input-wrapper">
				<textarea rows="{{ data.rows || 5 }}" data-setting="{{ data.name }}" placeholder="{{ data.placeholder }}"></textarea>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="wroter-control-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
