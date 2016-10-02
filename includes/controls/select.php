<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Select extends Control_Base {

	public function get_type() {
		return 'select';
	}

	public function content_template() {
		?>
		<div class="wroter-control-field">
			<label class="wroter-control-title">{{{ data.label }}}</label>
			<div class="wroter-control-input-wrapper">
				<select data-setting="{{ data.name }}">
				<# _.each( data.options, function( option_title, option_value ) { #>
					<option value="{{ option_value }}">{{{ option_title }}}</option>
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
