<?php
namespace Wroter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Admin {

	/**
	 * Enqueue admin scripts.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_script(
			'wroter-admin-app',
			WROTER_ASSETS_URL . 'js/admin' . $suffix . '.js',
			[
				'jquery',
			],
			Plugin::instance()->get_version(),
			true
		);
		wp_enqueue_script( 'wroter-admin-app' );

		if ( in_array( get_current_screen()->id, [ 'plugins', 'plugins-network' ] ) ) {
			add_action( 'admin_footer', [ $this, 'print_deactivate_feedback_dialog' ] );

			$this->enqueue_feedback_dialog_scripts();
		}
	}

	/**
	 * Enqueue admin styles.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_styles() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$direction_suffix = is_rtl() ? '-rtl' : '';

		wp_register_style(
			'wroter-icons',
			WROTER_ASSETS_URL . 'lib/eicons/css/wroter-icons' . $suffix . '.css',
			[],
			Plugin::instance()->get_version()
		);

		wp_register_style(
			'wroter-admin-app',
			WROTER_ASSETS_URL . 'css/admin' . $direction_suffix . $suffix . '.css',
			[
				'wroter-icons',
			],
			Plugin::instance()->get_version()
		);

		wp_enqueue_style( 'wroter-admin-app' );

		// It's for upgrade notice
		// TODO: enqueue this just if needed
		add_thickbox();
	}

	/**
	 * Print switch button in edit post (which has cpt support).
	 *
	 * @since 1.0.0
	 * @param $post
	 *
	 * @return void
	 */
	public function print_switch_mode_button( $post ) {
		if ( ! User::is_current_user_can_edit( $post->ID ) ) {
			return;
		}

		$current_mode = Plugin::instance()->db->get_edit_mode( $post->ID );
		if ( 'builder' !== $current_mode ) {
			$current_mode = 'editor';
		}

		wp_nonce_field( basename( __FILE__ ), '_wroter_edit_mode_nonce' );
		?>
		<div id="wroter-switch-mode">
			<input id="wroter-switch-mode-input" type="hidden" name="_wroter_post_mode" value="<?php echo $current_mode; ?>" />
			<button id="wroter-switch-mode-button" class="wroter-button">
				<span class="wroter-switch-mode-on"><?php _e( '&#8592; Back to WordPress Editor', 'wroter' ); ?></span>
				<span class="wroter-switch-mode-off">
					<i class="eicon-wroter"></i>
					<?php _e( 'Edit with Wroter', 'wroter' ); ?>
				</span>
			</button>
		</div>
		<div id="wroter-editor">
	        <a id="wroter-go-to-edit-page-link" href="<?php echo Utils::get_edit_link( $post->ID ); ?>">
		        <div id="wroter-editor-button" class="wroter-button">
			        <i class="eicon-wroter"></i>
					<?php _e( 'Edit with Wroter', 'wroter' ); ?>
		        </div>
		        <div class="wroter-loader-wrapper">
			        <div class="wroter-loader">
				        <div class="wroter-loader-box"></div>
				        <div class="wroter-loader-box"></div>
				        <div class="wroter-loader-box"></div>
				        <div class="wroter-loader-box"></div>
			        </div>
			        <div class="wroter-loading-title"><?php _e( 'Loading', 'wroter' ); ?></div>
		        </div>
	        </a>
		</div>
		<?php
	}

	/**
	 * Fired when the save the post, and flag the post mode.
	 *
	 * @since 1.0.0
	 * @param $post_id
	 *
	 * @return void
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['_wroter_edit_mode_nonce'] ) || ! wp_verify_nonce( $_POST['_wroter_edit_mode_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Exit when you don't have $_POST array.
		if ( empty( $_POST ) ) {
			return;
		}

		if ( ! isset( $_POST['_wroter_post_mode'] ) )
			$_POST['_wroter_post_mode'] = '';

		Plugin::instance()->db->set_edit_mode( $post_id, $_POST['_wroter_post_mode'] );
	}

	/**
	 * Add edit link in outside edit post.
	 *
	 * @since 1.0.0
	 * @param $actions
	 * @param $post
	 *
	 * @return array
	 */
	public function add_edit_in_dashboard( $actions, $post ) {
		if ( User::is_current_user_can_edit( $post->ID ) && 'builder' === Plugin::instance()->db->get_edit_mode( $post->ID ) ) {
			$actions['edit_with_wroter'] = sprintf(
				'<a href="%s">%s</a>',
				Utils::get_edit_link( $post->ID ),
				__( 'Edit with Wroter', 'wroter' )
			);
		}

		return $actions;
	}

	public function body_status_classes( $classes ) {
		global $pagenow;

		if ( in_array( $pagenow, [ 'post.php', 'post-new.php' ] ) && Utils::is_post_type_support() ) {
			$post = get_post();
			$current_mode = Plugin::instance()->db->get_edit_mode( $post->ID );

			$mode_class = 'builder' === $current_mode ? 'wroter-editor-active' : 'wroter-editor-inactive';

			$classes .= ' ' . $mode_class;
		}

		return $classes;
	}

	public function plugin_action_links( $links ) {
		$settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=' . Settings::PAGE_ID ), __( 'Settings', 'wroter' ) );
		array_unshift( $links, $settings_link );

		return $links;
	}

	public function admin_notices() {
		$upgrade_notice = Api::get_upgrade_notice();
		if ( empty( $upgrade_notice ) )
			return;

		if ( ! current_user_can( 'update_plugins' ) )
			return;

		if ( ! in_array( get_current_screen()->id, [ 'toplevel_page_wroter', 'edit-wroter_library', 'wroter_page_wroter-system-info', 'dashboard' ] ) ) {
			return;
		}

		// Check if have any upgrades
		$update_plugins = get_site_transient( 'update_plugins' );
		if ( empty( $update_plugins ) || empty( $update_plugins->response[ WROTER_PLUGIN_BASE ] ) || empty( $update_plugins->response[ WROTER_PLUGIN_BASE ]->package ) ) {
			return;
		}
		$product = $update_plugins->response[ WROTER_PLUGIN_BASE ];

		// Check if have upgrade notices to show
		if ( version_compare( Plugin::instance()->get_version(), $upgrade_notice['version'], '>=' ) )
			return;

		$notice_id = 'upgrade_notice_' . $upgrade_notice['version'];
		if ( User::is_user_notice_viewed( $notice_id ) )
			return;

		$details_url = self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $product->slug . '&section=changelog&TB_iframe=true&width=600&height=800' );
		$upgrade_url = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' . WROTER_PLUGIN_BASE ), 'upgrade-plugin_' . WROTER_PLUGIN_BASE );
		?>
		<div class="notice updated is-dismissible wroter-message wroter-message-dismissed" data-notice_id="<?php echo esc_attr( $notice_id ); ?>">
			<div class="wroter-message-inner">
				<div class="wroter-message-icon">
					<i class="eicon-wroter-square"></i>
				</div>
				<div class="wroter-message-content">
					<h3><?php _e( 'New in Wroter', 'wroter' ); ?></h3>
					<p><?php
						printf(
							/* translators: 1: details URL, 2: accessibility text, 3: version number, 4: update URL, 5: accessibility text */
							__( 'There is a new version of Wroter Page Builder available. <a href="%1$s" class="thickbox open-plugin-details-modal" aria-label="%2$s">View version %3$s details</a> or <a href="%4$s" class="update-link" aria-label="%5$s">update now</a>.', 'wroter' ),
							esc_url( $details_url ),
							esc_attr(
								sprintf(
									/* translators: %s: version number */
									__( 'View Wroter version %s details', 'wroter' ),
									$product->new_version
								)
							),
							$product->new_version,
							esc_url( $upgrade_url ),
							esc_attr( __( 'Update Now', 'wroter' ) )
						);
						?></p>
				</div>
				<div class="wroter-update-now">
					<a class="button wroter-button" href="<?php echo $upgrade_url; ?>"><i class="dashicons dashicons-update"></i><?php _e( 'Update Now', 'wroter' ); ?></a>
				</div>
			</div>
		</div>
		<?php
	}

	public function admin_footer_text( $footer_text ) {
		$current_screen = get_current_screen();
		$is_wroter_screen = ( $current_screen && false !== strpos( $current_screen->base, 'wroter' ) );

		if ( $is_wroter_screen ) {
			$footer_text = sprintf(
				/* translators: %s: link to plugin review */
				__( 'Enjoyed <strong>Wroter</strong>? Please leave us a %s rating. We really appreciate your support!', 'wroter' ),
				'<a href="https://wordpress.org/support/view/plugin-reviews/wroter?filter=5#postform" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
			);
		}

		return $footer_text;
	}

	public function enqueue_feedback_dialog_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_script(
			'wroter-dialog',
			WROTER_ASSETS_URL . 'lib/dialog/dialog' . $suffix . '.js',
			[
				'jquery-ui-position',
			],
			'3.0.0',
			true
		);

		wp_register_script(
			'wroter-admin-feedback',
			WROTER_ASSETS_URL . 'js/admin-feedback' . $suffix . '.js',
			[
				'underscore',
				'wroter-dialog',
			],
			Plugin::instance()->get_version(),
			true
		);

		wp_enqueue_script( 'wroter-admin-feedback' );

		wp_localize_script(
			'wroter-admin-feedback',
			'WroterAdminFeedbackArgs',
			[
				'is_tracker_opted_in' => Tracker::is_allow_track(),
				'i18n' => [
					'submit_n_deactivate' => __( 'Submit & Deactivate', 'wroter' ),
					'skip_n_deactivate' => __( 'Skip & Deactivate', 'wroter' ),
				],
			]
		);
	}

	public function print_deactivate_feedback_dialog() {
		$deactivate_reasons = [
			'no_longer_needed' => [
				'title' => __( 'I no longer need the plugin', 'wroter' ),
				'input_placeholder' => '',
			],
			'found_a_better_plugin' => [
				'title' => __( 'I found a better plugin', 'wroter' ),
				'input_placeholder' => __( 'Please share which plugin', 'wroter' ),
			],
			'couldnt_get_the_plugin_to_work' => [
				'title' => __( 'I couldn\'t get the plugin to work', 'wroter' ),
				'input_placeholder' => '',
			],
			'temporary_deactivation' => [
				'title' => __( 'It\'s a temporary deactivation', 'wroter' ),
				'input_placeholder' => '',
			],
			'other' => [
				'title' => __( 'Other', 'wroter' ),
				'input_placeholder' => __( 'Please share the reason', 'wroter' ),
			],
		];

		?>
		<div id="wroter-deactivate-feedback-dialog-wrapper">
			<div id="wroter-deactivate-feedback-dialog-header">
				<i class="eicon-wroter-square"></i>
				<span id="wroter-deactivate-feedback-dialog-header-title"><?php _e( 'Quick Feedback', 'wroter' ); ?></span>
			</div>
			<form id="wroter-deactivate-feedback-dialog-form" method="post">
				<?php
				wp_nonce_field( '_wroter_deactivate_feedback_nonce' );
				?>
				<input type="hidden" name="action" value="wroter_deactivate_feedback" />

				<div id="wroter-deactivate-feedback-dialog-form-caption"><?php _e( 'If you have a moment, please share why you are deactivating Wroter:', 'wroter' ); ?></div>
				<div id="wroter-deactivate-feedback-dialog-form-body">
					<?php foreach ( $deactivate_reasons as $reason_key => $reason ) : ?>
						<div class="wroter-deactivate-feedback-dialog-input-wrapper">
							<input id="wroter-deactivate-feedback-<?php echo esc_attr( $reason_key ); ?>" class="wroter-deactivate-feedback-dialog-input" type="radio" name="reason_key" value="<?php echo esc_attr( $reason_key ); ?>" />
							<label for="wroter-deactivate-feedback-<?php echo esc_attr( $reason_key ); ?>" class="wroter-deactivate-feedback-dialog-label"><?php echo $reason['title']; ?></label>
							<?php if ( ! empty( $reason['input_placeholder'] ) ) : ?>
								<input class="wroter-feedback-text" type="text" name="reason_<?php echo esc_attr( $reason_key ); ?>" placeholder="<?php echo esc_attr( $reason['input_placeholder'] ); ?>" />
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</form>
		</div>
		<?php
	}

	public function ajax_wroter_deactivate_feedback() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], '_wroter_deactivate_feedback_nonce' ) ) {
			wp_send_json_error();
		}

		$reason_text = $reason_key = '';

		if ( ! empty( $_POST['reason_key'] ) )
			$reason_key = $_POST['reason_key'];

		if ( ! empty( $_POST[ "reason_{$reason_key}" ] ) )
			$reason_text = $_POST[ "reason_{$reason_key}" ];

		Api::send_feedback( $reason_key, $reason_text );

		wp_send_json_success();
	}

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );

		add_action( 'edit_form_after_title', [ $this, 'print_switch_mode_button' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );

		add_filter( 'page_row_actions', [ $this, 'add_edit_in_dashboard' ], 10, 2 );
		add_filter( 'post_row_actions', [ $this, 'add_edit_in_dashboard' ], 10, 2 );

		add_filter( 'plugin_action_links_' . WROTER_PLUGIN_BASE, [ $this, 'plugin_action_links' ] );

		add_action( 'admin_notices', [ $this, 'admin_notices' ] );
		add_filter( 'admin_body_class', [ $this, 'body_status_classes' ] );
		add_filter( 'admin_footer_text', [ $this, 'admin_footer_text' ] );

		// Ajax
		add_action( 'wp_ajax_wroter_deactivate_feedback', [ $this, 'ajax_wroter_deactivate_feedback' ] );
	}
}
