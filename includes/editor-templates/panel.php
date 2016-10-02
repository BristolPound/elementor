<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<script type="text/template" id="tmpl-wroter-panel">
	<div id="wroter-mode-switcher"></div>
	<header id="wroter-panel-header-wrapper"></header>
	<main id="wroter-panel-content-wrapper"></main>
	<footer id="wroter-panel-footer">
		<div class="wroter-panel-container">
		</div>
	</footer>
</script>

<script type="text/template" id="tmpl-wroter-panel-menu-item">
	<div class="wroter-panel-menu-item-icon">
		<i class="fa fa-{{ icon }}"></i>
	</div>
	<div class="wroter-panel-menu-item-title">{{{ title }}}</div>
</script>

<script type="text/template" id="tmpl-wroter-panel-header">
	<div id="wroter-panel-header-menu-button" class="wroter-header-button">
		<i class="wroter-icon eicon-menu tooltip-target" data-tooltip="<?php esc_attr_e( 'Menu', 'wroter' ); ?>"></i>
	</div>
	<div id="wroter-panel-header-title"></div>
	<div id="wroter-panel-header-add-button" class="wroter-header-button">
		<i class="wroter-icon eicon-apps tooltip-target" data-tooltip="<?php esc_attr_e( 'Widgets Panel', 'wroter' ); ?>"></i>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-panel-footer-content">
	<div id="wroter-panel-footer-exit" class="wroter-panel-footer-tool" title="<?php _e( 'Exit', 'wroter' ); ?>">
		<i class="fa fa-times"></i>
		<div class="wroter-panel-footer-sub-menu-wrapper">
			<div class="wroter-panel-footer-sub-menu">
				<a id="wroter-panel-footer-view-page" class="wroter-panel-footer-sub-menu-item" href="<?php the_permalink(); ?>" target="_blank">
					<i class="wroter-icon fa fa-external-link"></i>
					<span class="wroter-title"><?php _e( 'View Page', 'wroter' ); ?></span>
				</a>
				<a id="wroter-panel-footer-view-edit-page" class="wroter-panel-footer-sub-menu-item" href="<?php echo get_edit_post_link(); ?>">
					<i class="wroter-icon fa fa-wordpress"></i>
					<span class="wroter-title"><?php _e( 'Go to Dashboard', 'wroter' ); ?></span>
				</a>
			</div>
		</div>
	</div>
	<div id="wroter-panel-footer-responsive" class="wroter-panel-footer-tool" title="<?php esc_attr_e( 'Responsive Mode', 'wroter' ); ?>">
		<i class="eicon-device-desktop"></i>
		<div class="wroter-panel-footer-sub-menu-wrapper">
			<div class="wroter-panel-footer-sub-menu">
				<div class="wroter-panel-footer-sub-menu-item" data-device-mode="desktop">
					<i class="wroter-icon eicon-device-desktop"></i>
					<span class="wroter-title"><?php _e( 'Desktop', 'wroter' ); ?></span>
					<span class="wroter-description"><?php _e( 'Default Preview', 'wroter' ); ?></span>
				</div>
				<div class="wroter-panel-footer-sub-menu-item" data-device-mode="tablet">
					<i class="wroter-icon eicon-device-tablet"></i>
					<span class="wroter-title"><?php _e( 'Tablet', 'wroter' ); ?></span>
					<span class="wroter-description"><?php _e( 'Preview for 768px', 'wroter' ); ?></span>
				</div>
				<div class="wroter-panel-footer-sub-menu-item" data-device-mode="mobile">
					<i class="wroter-icon eicon-device-mobile"></i>
					<span class="wroter-title"><?php _e( 'Mobile', 'wroter' ); ?></span>
					<span class="wroter-description"><?php _e( 'Preview for 360px', 'wroter' ); ?></span>
				</div>
			</div>
		</div>
	</div>
	<div id="wroter-panel-footer-help" class="wroter-panel-footer-tool" title="<?php esc_attr_e( 'Help', 'wroter' ); ?>">
		<span class="wroter-screen-only"><?php _e( 'Help', 'wroter' ); ?></span>
		<i class="fa fa-question-circle"></i>
		<div class="wroter-panel-footer-sub-menu-wrapper">
			<div class="wroter-panel-footer-sub-menu">
				<div id="wroter-panel-footer-help-title"><?php _e( 'Need help?', 'wroter' ); ?></div>
				<div id="wroter-panel-footer-watch-tutorial" class="wroter-panel-footer-sub-menu-item">
					<i class="wroter-icon fa fa-video-camera"></i>
					<span class="wroter-title"><?php _e( 'Take a tour', 'wroter' ); ?></span>
				</div>
				<div class="wroter-panel-footer-sub-menu-item">
					<i class="wroter-icon fa fa-external-link"></i>
					<a class="wroter-title" href="https://go.wroter.com/docs" target="_blank"><?php _e( 'Go to the Documentation', 'wroter' ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<div id="wroter-panel-footer-templates" class="wroter-panel-footer-tool" title="<?php esc_attr_e( 'Templates', 'wroter' ); ?>">
		<span class="wroter-screen-only"><?php _e( 'Templates', 'wroter' ); ?></span>
		<i class="fa fa-folder"></i>
		<div class="wroter-panel-footer-sub-menu-wrapper">
			<div class="wroter-panel-footer-sub-menu">
				<div id="wroter-panel-footer-templates-modal" class="wroter-panel-footer-sub-menu-item">
					<i class="wroter-icon fa fa-folder"></i>
					<span class="wroter-title"><?php _e( 'Templates Library', 'wroter' ); ?></span>
				</div>
				<div id="wroter-panel-footer-save-template" class="wroter-panel-footer-sub-menu-item">
					<i class="wroter-icon fa fa-save"></i>
					<span class="wroter-title"><?php _e( 'Save Template', 'wroter' ); ?></span>
				</div>
			</div>
		</div>
	</div>
	<div id="wroter-panel-footer-save" class="wroter-panel-footer-tool" title="<?php esc_attr_e( 'Save', 'wroter' ); ?>">
		<button class="wroter-button">
			<span class="wroter-state-icon">
				<i class="fa fa-spin fa-circle-o-notch "></i>
			</span>
			<?php _e( 'Save', 'wroter' ); ?>
		</button>
		<?php /*<div class="wroter-panel-footer-sub-menu-wrapper">
			<div class="wroter-panel-footer-sub-menu">
				<div id="wroter-panel-footer-publish" class="wroter-panel-footer-sub-menu-item">
					<i class="wroter-icon fa fa-check-circle"></i>
					<span class="wroter-title"><?php _e( 'Publish', 'wroter' ); ?></span>
				</div>
				<div id="wroter-panel-footer-discard" class="wroter-panel-footer-sub-menu-item">
					<i class="wroter-icon fa fa-times-circle"></i>
					<span class="wroter-title"><?php _e( 'Discard', 'wroter' ); ?></span>
				</div>
			</div>
		</div>*/ ?>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-mode-switcher-content">
	<input id="wroter-mode-switcher-preview-input" type="checkbox">
	<label for="wroter-mode-switcher-preview-input" id="wroter-mode-switcher-preview" title="<?php esc_attr_e( 'Preview', 'wroter' ); ?>">
		<span class="wroter-screen-only"><?php _e( 'Preview', 'wroter' ); ?></span>
		<i class="fa"></i>
	</label>
</script>

<script type="text/template" id="tmpl-editor-content">
	<div class="wroter-tabs-controls">
		<ul>
			<# _.each( elementData.tabs_controls, function( tabTitle, tabSlug ) { #>
			<li class="wroter-tab-control-{{ tabSlug }}">
				<a href="#" data-tab="{{ tabSlug }}">
					{{{ tabTitle }}}
				</a>
			</li>
			<# } ); #>
		</ul>
	</div>
	<div class="wroter-controls"></div>
</script>

<script type="text/template" id="tmpl-wroter-panel-schemes-typography">
	<div class="wroter-panel-scheme-buttons">
		<div class="wroter-panel-scheme-button-wrapper wroter-panel-scheme-reset">
			<button class="wroter-button">
				<i class="fa fa-undo"></i>
				<?php _e( 'Reset', 'wroter' ); ?>
			</button>
		</div>
		<div class="wroter-panel-scheme-button-wrapper wroter-panel-scheme-discard">
			<button class="wroter-button">
				<i class="fa fa-times"></i>
				<?php _e( 'Discard', 'wroter' ); ?>
			</button>
		</div>
		<div class="wroter-panel-scheme-button-wrapper wroter-panel-scheme-save">
			<button class="wroter-button wroter-button-success" disabled><?php _e( 'Apply', 'wroter' ); ?></button>
		</div>
	</div>
	<div class="wroter-panel-scheme-items"></div>
</script>

<script type="text/template" id="tmpl-wroter-panel-schemes-color">
	<div class="wroter-panel-scheme-buttons">
		<div class="wroter-panel-scheme-button-wrapper wroter-panel-scheme-reset">
			<button class="wroter-button">
				<i class="fa fa-undo"></i>
				<?php _e( 'Reset', 'wroter' ); ?>
			</button>
		</div>
		<div class="wroter-panel-scheme-button-wrapper wroter-panel-scheme-discard">
			<button class="wroter-button">
				<i class="fa fa-times"></i>
				<?php _e( 'Discard', 'wroter' ); ?>
			</button>
		</div>
		<div class="wroter-panel-scheme-button-wrapper wroter-panel-scheme-save">
			<button class="wroter-button wroter-button-success" disabled><?php _e( 'Apply', 'wroter' ); ?></button>
		</div>
	</div>
	<div class="wroter-panel-scheme-content wroter-panel-box">
		<div class="wroter-panel-heading">
			<div class="wroter-panel-heading-title"><?php _e( 'Color Palette', 'wroter' ); ?></div>
		</div>
		<div class="wroter-panel-scheme-items wroter-panel-box-content"></div>
	</div>
	<div class="wroter-panel-scheme-colors-more-palettes wroter-panel-box">
		<div class="wroter-panel-heading">
			<div class="wroter-panel-heading-title"><?php _e( 'More Palettes', 'wroter' ); ?></div>
		</div>
		<div class="wroter-panel-box-content">
			<?php foreach ( Scheme_Color::get_system_schemes() as $scheme_name => $scheme ) : ?>
				<div class="wroter-panel-scheme-color-system-scheme" data-scheme-name="<?php echo $scheme_name; ?>">
					<div class="wroter-panel-scheme-color-system-items">
						<?php
						$print_colors_index = [
							Scheme_Color::COLOR_1,
							Scheme_Color::COLOR_2,
							Scheme_Color::COLOR_3,
							Scheme_Color::COLOR_4,
						];
						$colors_to_print = [];
						foreach ( $print_colors_index as $color_name ) {
							$colors_to_print[ $color_name ] = $scheme['items'][ $color_name ];
						}

						foreach ( $colors_to_print as $color_value ) : ?>
							<div class="wroter-panel-scheme-color-system-item" style="background-color: <?php echo esc_attr( $color_value ); ?>;"></div>
						<?php endforeach; ?>
					</div>
					<div class="wroter-title"><?php echo $scheme['title']; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-panel-schemes-disabled">
	{{{ '<?php printf( __( '{0} are disabled. You can enable it from the <a href="%s" target="_blank">Wroter settings page</a>.', 'wroter' ), Settings::get_url() ); ?>'.replace( '{0}', disabledTitle ) }}}
</script>

<script type="text/template" id="tmpl-wroter-panel-scheme-color-item">
	<div class="wroter-panel-scheme-color-input-wrapper">
		<input type="text" class="wroter-panel-scheme-color-value" value="{{ value }}" />
	</div>
	<div class="wroter-panel-scheme-color-title">{{{ title }}}</div>
</script>

<script type="text/template" id="tmpl-wroter-panel-scheme-typography-item">
	<div class="wroter-panel-heading">
		<div class="wroter-panel-heading-toggle">
			<i class="fa"></i>
		</div>
		<div class="wroter-panel-heading-title">{{{ title }}}</div>
	</div>
	<div class="wroter-panel-scheme-typography-items wroter-panel-box-content">
		<?php
		$scheme_fields_keys = Group_Control_Typography::get_scheme_fields_keys();

		$typography_fields = Group_Control_Typography::get_fields();

		$scheme_fields = array_intersect_key( $typography_fields, array_flip( $scheme_fields_keys ) );

		foreach ( $scheme_fields as $option_name => $option ) : ?>
			<div class="wroter-panel-scheme-typography-item">
				<div class="wroter-panel-scheme-item-title wroter-control-title"><?php echo $option['label']; ?></div>
				<div class="wroter-panel-scheme-typography-item-value">
					<?php if ( 'select' === $option['type'] ) : ?>
						<select name="<?php echo $option_name; ?>" class="wroter-panel-scheme-typography-item-field">
							<?php foreach ( $option['options'] as $field_key => $field_value ) : ?>
								<option value="<?php echo $field_key; ?>"><?php echo $field_value; ?></option>
							<?php endforeach; ?>
						</select>
					<?php elseif ( 'font' === $option['type'] ) : ?>
						<select name="<?php echo $option_name; ?>" class="wroter-panel-scheme-typography-item-field">
							<option value=""><?php _e( 'Default', 'wroter' ); ?></option>

							<optgroup label="<?php _e( 'System', 'wroter' ); ?>">
								<?php foreach ( Fonts::get_fonts_by_groups( [ Fonts::SYSTEM ] ) as $font_title => $font_type ) : ?>
									<option value="<?php echo esc_attr( $font_title ); ?>"><?php echo $font_title; ?></option>
								<?php endforeach; ?>
							</optgroup>

							<optgroup label="<?php _e( 'Google', 'wroter' ); ?>">
								<?php foreach ( Fonts::get_fonts_by_groups( [ Fonts::GOOGLE, Fonts::EARLYACCESS ] ) as $font_title => $font_type ) : ?>
									<option value="<?php echo esc_attr( $font_title ); ?>"><?php echo $font_title; ?></option>
								<?php endforeach; ?>
							</optgroup>
						</select>
					<?php elseif ( 'text' === $option['type'] ) : ?>
						<input name="<?php echo $option_name; ?>" class="wroter-panel-scheme-typography-item-field" />
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</script>

<script type="text/template" id="tmpl-wroter-control-responsive-switchers">
	<div class="wroter-control-responsive-switchers">
		<a class="wroter-responsive-switcher wroter-responsive-switcher-desktop" data-device="desktop">
			<i class="eicon-device-desktop"></i>
		</a>
		<a class="wroter-responsive-switcher wroter-responsive-switcher-tablet" data-device="tablet">
			<i class="eicon-device-tablet"></i>
		</a>
		<a class="wroter-responsive-switcher wroter-responsive-switcher-mobile" data-device="mobile">
			<i class="eicon-device-mobile"></i>
		</a>
	</div>
</script>
