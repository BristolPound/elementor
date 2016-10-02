<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Checkbox extends Control_Base {

	public function get_type() {
		return 'checkbox';
	}

	public function content_template() {
		?>
		<label class="wroter-control-title">
			<span>{{{ data.label }}}</span>
			<input type="checkbox" data-setting="{{ data.name }}" />
		</label>
		<# if ( data.description ) { #>
		<div class="wroter-control-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
