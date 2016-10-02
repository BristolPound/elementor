<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Structure extends Control_Base {

	public function get_type() {
		return 'structure';
	}

	public function content_template() {
		?>
		<div class="wroter-control-field">
			<div class="wroter-control-input-wrapper">
				<div class="wroter-control-structure-title"><?php _e( 'Structure', 'wroter' ); ?></div>
				<# var currentPreset = wroter.presetsFactory.getPresetByStructure( data.controlValue ); #>
				<div class="wroter-control-structure-preset wroter-control-structure-current-preset">
					{{{ wroter.presetsFactory.getPresetSVG( currentPreset.preset, 233, 72, 5 ).outerHTML }}}
				</div>
				<div class="wroter-control-structure-reset"><i class="fa fa-undo"></i><?php _e( 'Reset Structure', 'wroter' ); ?></div>
				<#
				var morePresets = getMorePresets();

				if ( morePresets.length > 1 ) { #>
					<div class="wroter-control-structure-more-presets-title"><?php _e( 'More Structures', 'wroter' ); ?></div>
					<div class="wroter-control-structure-more-presets">
						<# _.each( morePresets, function( preset ) { #>
							<div class="wroter-control-structure-preset-wrapper">
								<input id="wroter-control-structure-preset-{{ data._cid }}-{{ preset.key }}" type="radio" name="wroter-control-structure-preset-{{ data._cid }}" data-setting="structure" value="{{ preset.key }}">
								<label class="wroter-control-structure-preset" for="wroter-control-structure-preset-{{ data._cid }}-{{ preset.key }}">
									{{{ wroter.presetsFactory.getPresetSVG( preset.preset, 102, 42 ).outerHTML }}}
								</label>
								<div class="wroter-control-structure-preset-title">{{{ preset.preset.join( ', ' ) }}}</div>
							</div>
						<# } ); #>
					</div>
				<# } #>
			</div>
		</div>
		
		<# if ( data.description ) { #>
			<div class="wroter-control-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	protected function get_default_settings() {
		return [
			'separator' => 'none',
		];
	}
}
