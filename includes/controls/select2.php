<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Select2 extends Control_Base {

	public function get_type() {
		return 'select2';
	}

	function get_default_settings() {
		return [
			'multiple' => false,
		];
	}

	public function content_template() {
		?>
		<div class="wroter-control-field">
			<label class="wroter-control-title">{{{ data.label }}}</label>
			<div class="wroter-control-input-wrapper">
				<# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select class="wroter-select2" type="select2" {{ multiple }} data-setting="{{ data.name }}">
					<# _.each( data.options, function( option_title, option_value ) {
						var value = data.controlValue;
						if ( typeof value == 'string' ) {
							var selected = ( option_value === value ) ? 'selected' : '';
						} else {
							var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
						}
						#>
					<option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
					<# } ); #>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="wroter-control-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
