<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Settings {

	const PAGE_ID = 'wroter';

	public static function get_url() {
		return admin_url( 'admin.php?page=' . self::PAGE_ID );
	}

	public function register_settings_fields() {
		$controls_class_name = __NAMESPACE__ . '\Settings_Controls';
		$validations_class_name = __NAMESPACE__ . '\Settings_Validations';

		// Register the main section
		$main_section = 'wroter_general_section';

		add_settings_section(
			$main_section,
			__( 'General Settings', 'wroter' ),
			'__return_empty_string', // No need intro text for this section right now
			self::PAGE_ID
		);

		$field_id = 'wroter_cpt_support';
		add_settings_field(
			$field_id,
			__( 'Post Types', 'wroter' ),
			[ $controls_class_name, 'render' ],
			self::PAGE_ID,
			$main_section,
			[
				'id' => $field_id,
				'type' => 'checkbox_list_cpt',
				'std' => [ 'page', 'post' ],
				'exclude' => [ 'attachment', 'wroter_library' ],
			]
		);

		register_setting( self::PAGE_ID, $field_id, [ $validations_class_name, 'checkbox_list' ] );

		$field_id = 'wroter_exclude_user_roles';
		add_settings_field(
			$field_id,
			__( 'Exclude Roles', 'wroter' ),
			[ $controls_class_name, 'render' ],
			self::PAGE_ID,
			$main_section,
			[
				'id' => $field_id,
				'type' => 'checkbox_list_roles',
				'exclude' => [ 'administrator' ],
			]
		);

		register_setting( self::PAGE_ID, $field_id, [ $validations_class_name, 'checkbox_list' ] );

		// Style section
		$style_section = 'wroter_style_section';

		add_settings_section(
			$style_section,
			__( 'Style Settings', 'wroter' ),
			'__return_empty_string', // No need intro text for this section right now
			self::PAGE_ID
		);

		$field_id = 'wroter_disable_color_schemes';
		add_settings_field(
			$field_id,
			__( 'Disable Color Palettes', 'wroter' ),
			[ $controls_class_name, 'render' ],
			self::PAGE_ID,
			$style_section,
			[
				'id' => $field_id,
				'type' => 'checkbox',
				'value' => 'yes',
				'sub_desc' => __( 'Color Palettes let you change the default colors that appear under the various widgets. If you prefer to inherit the colors from your theme, you can disable this feature.', 'wroter' ),
			]
		);

		register_setting( self::PAGE_ID, $field_id );

		$field_id = 'wroter_disable_typography_schemes';
		add_settings_field(
			$field_id,
			__( 'Disable Default Fonts', 'wroter' ),
			[ $controls_class_name, 'render' ],
			self::PAGE_ID,
			$style_section,
			[
				'id' => $field_id,
				'type' => 'checkbox',
				'value' => 'yes',
				'sub_desc' => __( 'Default Fonts let you change the fonts that appear on Wroter from one place. If you prefer to inherit the fonts from your theme, you can disable this feature here.', 'wroter' ),
			]
		);

		register_setting( self::PAGE_ID, $field_id );

		$field_id = 'wroter_default_generic_fonts';
		add_settings_field(
			$field_id,
			__( 'Default Generic Fonts', 'wroter' ),
			[ $controls_class_name, 'render' ],
			self::PAGE_ID,
			$style_section,
			[
				'id' => $field_id,
				'type' => 'text',
				'std' => 'Sans-serif',
				'classes' => [ 'medium-text' ],
				'desc' => __( 'The list of fonts used if the chosen font is not available.', 'wroter' ),
			]
		);

		register_setting( self::PAGE_ID, $field_id );

		$field_id = 'wroter_container_width';
		add_settings_field(
			$field_id,
			__( 'Content Width', 'wroter' ),
			[ $controls_class_name, 'render' ],
			self::PAGE_ID,
			$style_section,
			[
				'id' => $field_id,
				'type' => 'text',
				'placeholder' => '1140',
				'sub_desc' => 'px',
				'classes' => [ 'medium-text' ],
				'desc' => __( 'Sets the default width of the content area (Default: 1140)', 'wroter' ),
			]
		);

		register_setting( self::PAGE_ID, $field_id );

		$field_id = 'wroter_stretched_section_container';
		add_settings_field(
			$field_id,
			__( 'Stretched Section Fit To', 'wroter' ),
			[ $controls_class_name, 'render' ],
			self::PAGE_ID,
			$style_section,
			[
				'id' => $field_id,
				'type' => 'text',
				'placeholder' => 'body',
				'classes' => [ 'medium-text' ],
				'desc' => __( 'Enter parent element selector to which stretched sections will fit to (e.g. #primary / .wrapper / main etc). Leave blank to fit to page width.', 'wroter' ),
			]
		);

		register_setting( self::PAGE_ID, $field_id );

		// Tools section
		$tools_section = 'wroter_tools_section';
		add_settings_section(
			$tools_section,
			__( 'Tools', 'wroter' ),
			'__return_empty_string', // No need intro text for this section right now
			self::PAGE_ID
		);

		$field_id = 'wroter_raw_reset_api_data';
		add_settings_field(
			$field_id,
			__( 'Sync Library', 'wroter' ),
			[ $controls_class_name, 'render' ],
			self::PAGE_ID,
			$tools_section,
			[
				'id' => $field_id,
				'type' => 'raw_html',
				'html' => sprintf( '<button data-nonce="%s" class="button" id="wroter-library-sync-button">%s</button>', wp_create_nonce( 'wroter_reset_library' ), __( 'Sync Library', 'wroter' ) ),
				'desc' => __( 'Wroter Library automatically updates on a daily basis. You can also manually update it by clicking on the sync button.', 'wroter' ),
			]
		);

		$field_id = 'wroter_allow_tracking';
		add_settings_field(
			$field_id,
			__( 'Usage Data Tracking', 'wroter' ),
			[ $controls_class_name, 'render' ],
			self::PAGE_ID,
			$tools_section,
			[
				'id' => $field_id,
				'type' => 'checkbox',
				'value' => 'yes',
				'default' => '',
				'sub_desc' => __( 'Opt-in to our anonymous plugin data collection and to updates. We guarantee no sensitive data is collected.', 'wroter' ) . sprintf( ' <a href="%s" target="_blank">%s</a>', 'https://go.wroter.com/usage-data-tracking/', __( 'Learn more.', 'wroter' ) ),
			]
		);

		register_setting( self::PAGE_ID, $field_id, [ __NAMESPACE__ . '\Tracker', 'check_for_settings_optin' ] );
	}

	public function register_admin_menu() {
		add_menu_page(
			__( 'Wroter', 'wroter' ),
			__( 'Wroter', 'wroter' ),
			'manage_options',
			self::PAGE_ID,
			[ $this, 'display_settings_page' ],
			'',
			99
		);
	}

	public function admin_menu_change_name() {
		global $submenu;

		if ( isset( $submenu['wroter'] ) )
			$submenu['wroter'][0][0] = __( 'Settings', 'wroter' );
	}

	public function display_settings_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Wroter', 'wroter' ); ?></h2>
			<form method="post" action="options.php">
				<?php
				settings_fields( self::PAGE_ID );
				do_settings_sections( self::PAGE_ID );

				submit_button();
				?>
			</form>
		</div><!-- /.wrap -->
		<?php
	}

	public function __construct() {
		include( WROTER_PATH . 'includes/settings/controls.php' );
		include( WROTER_PATH . 'includes/settings/validations.php' );

		add_action( 'admin_init', [ $this, 'register_settings_fields' ], 20 );
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 20 );
		add_action( 'admin_menu', [ $this, 'admin_menu_change_name' ], 200 );
	}
}
