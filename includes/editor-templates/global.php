<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<script type="text/template" id="tmpl-wroter-empty-preview">
	<div class="wroter-first-add">
		<div class="wroter-icon eicon-plus"></div>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-preview">
	<div id="wroter-section-wrap"></div>
	<div id="wroter-add-section" class="wroter-visible-desktop">
		<div id="wroter-add-section-inner">
			<div id="wroter-add-new-section">
				<button id="wroter-add-section-button" class="wroter-button"><?php _e( 'Add New Section', 'wroter' ); ?></button>
				<button id="wroter-add-template-button" class="wroter-button"><?php _e( 'Add Template', 'wroter' ); ?></button>
				<div id="wroter-add-section-drag-title"><?php _e( 'Or drag widget here', 'wroter' ); ?></div>
			</div>
			<div id="wroter-select-preset">
				<div id="wroter-select-preset-close">
					<i class="fa fa-times"></i>
				</div>
				<div id="wroter-select-preset-title"><?php _e( 'Select your Structure', 'wroter' ); ?></div>
				<ul id="wroter-select-preset-list">
					<#
					var structures = [ 10, 20, 30, 40, 21, 22, 31, 32, 33, 50, 60, 34 ];

					_.each( structures, function( structure ) {
						var preset = wroter.presetsFactory.getPresetByStructure( structure ); #>

						<li class="wroter-preset wroter-column wroter-col-16" data-structure="{{ structure }}">
							{{{ wroter.presetsFactory.getPresetSVG( preset.preset ).outerHTML }}}
						</li>
					<# } ); #>
				</ul>
			</div>
		</div>
	</div>
</script>
