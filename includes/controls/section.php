<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Section extends Control_Base {

	public function get_type() {
		return 'section';
	}

	public function content_template() {
		?>
		<div class="wroter-panel-heading">
			<div class="wroter-panel-heading-toggle wroter-section-toggle" data-collapse_id="{{ data.name }}">
				<i class="fa"></i>
			</div>
			<div class="wroter-panel-heading-title wroter-section-title">{{{ data.label }}}</div>
		</div>
		<?php
	}

	protected function get_default_settings() {
		return [
			'separator' => 'none',
		];
	}
}
