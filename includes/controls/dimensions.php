<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Dimensions extends Control_Base_Units {

	public function get_type() {
		return 'dimensions';
	}

	public function get_default_value() {
		return array_merge( parent::get_default_value(), [
			'top' => '',
			'right' => '',
			'bottom' => '',
			'left' => '',
			'isLinked' => true,
		] );
	}

	protected function get_default_settings() {
		return array_merge( parent::get_default_settings(), [
			'label_block' => true,
			'allowed_dimensions' => 'all',
			'placeholder' => '',
		] );
	}

	public function content_template() {
		$dimensions = [
			'top' => __( 'Top', 'wroter' ),
			'right' => __( 'Right', 'wroter' ),
			'bottom' => __( 'Bottom', 'wroter' ),
			'left' => __( 'Left', 'wroter' ),
		];
		?>
		<div class="wroter-control-field">
			<label class="wroter-control-title">{{{ data.label }}}</label>
			<?php $this->print_units_template(); ?>
			<div class="wroter-control-input-wrapper">
				<ul class="wroter-control-dimensions">
					<?php foreach ( $dimensions as $dimension_key => $dimension_title ) : ?>
						<li class="wroter-control-dimension">
							<input type="number" data-setting="<?php echo esc_attr( $dimension_key ); ?>"
							       placeholder="<#
						       if ( _.isObject( data.placeholder ) ) {
						        if ( ! _.isUndefined( data.placeholder.<?php echo $dimension_key; ?> ) ) {
						            print( data.placeholder.<?php echo $dimension_key; ?> );
						        }
						       } else {
						        print( data.placeholder );
						       } #>"
							<# if ( -1 === _.indexOf( allowed_dimensions, '<?php echo $dimension_key; ?>' ) ) { #>
								disabled
								<# } #>
									/>
									<span><?php echo $dimension_title; ?></span>
						</li>
					<?php endforeach; ?>
					<li>
						<button class="wroter-link-dimensions tooltip-target" data-tooltip="<?php _e( 'Link values together', 'wroter' ); ?>">
							<span class="wroter-linked"><i class="fa fa-link"></i></span>
							<span class="wroter-unlinked"><i class="fa fa-chain-broken"></i></span>
						</button>
					</li>
				</ul>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="wroter-control-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
