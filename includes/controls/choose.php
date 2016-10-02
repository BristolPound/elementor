<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Choose extends Control_Base {

	public function get_type() {
		return 'choose';
	}

	public function content_template() {
		?>
		<div class="wroter-control-field">
			<label class="wroter-control-title">{{{ data.label }}}</label>
			<div class="wroter-control-input-wrapper">
				<div class="wroter-choices">
					<# _.each( data.options, function( options, value ) { #>
					<input id="wroter-choose-{{ data._cid + data.name + value }}" type="radio" name="wroter-choose-{{ data.name }}" value="{{ value }}">
					<label class="wroter-choices-label tooltip-target" for="wroter-choose-{{ data._cid + data.name + value }}" data-tooltip="{{ options.title }}" title="{{ options.title }}">
						<i class="fa fa-{{ options.icon }}"></i>
					</label>
					<# } ); #>
				</div>
			</div>
		</div>

		<# if ( data.description ) { #>
		<div class="wroter-control-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
			'toggle' => true,
		];
	}
}
