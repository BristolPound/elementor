<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Switcher extends Control_Base {

	public function get_type() {
		return 'switcher';
	}

	public function content_template() {
		?>
		<div class="wroter-control-field">
			<label class="wroter-control-title">{{{ data.label }}}</label>
			<div class="wroter-control-input-wrapper">
				<label class="wroter-switch">
					<input type="checkbox" data-setting="{{ data.name }}" class="wroter-switch-input" value="{{ data.return_value }}">
					<span class="wroter-switch-label" data-on="{{ data.label_on }}" data-off="{{ data.label_off }}"></span>
					<span class="wroter-switch-handle"></span>
				</label>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="wroter-control-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	protected function get_default_settings() {
		return [
			'label_off' => '',
			'label_on' => '',
			'return_value' => 'yes',
		];
	}
}
