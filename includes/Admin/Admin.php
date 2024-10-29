<?php

namespace AdvancedShortcodes\Admin;

use AdvancedShortcodes\Admin\ListTables\ShortcodesListTable;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Class Admin.
 *
 * @since 1.0.0
 * @package AdvancedShortcodes\Admin
 */
class Admin {

	/**
	 * Admin constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_menu', array( $this, 'settings_menu' ), 100 );
		add_filter( 'set-screen-option', array( $this, 'screen_option' ), 10, 3 );
		add_action( 'load-toplevel_page_advanced-shortcodes', array( $this, 'handle_list_table_actions' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Add menu page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function add_menu() {
		add_menu_page(
			__( 'Shortcodes', 'advanced-shortcodes' ),
			__( 'Shortcodes', 'advanced-shortcodes' ),
			'manage_options',
			'advanced-shortcodes',
			null,
			'dashicons-shortcode',
			'25',
		);

		$load = add_submenu_page(
			'advanced-shortcodes',
			__( 'Shortcodes', 'advanced-shortcodes' ),
			__( 'Shortcodes', 'advanced-shortcodes' ),
			'manage_options',
			'advanced-shortcodes',
			array( $this, 'render_shortcodes_page' ),
		);

		// Load screen options.
		add_action( 'load-' . $load, array( __CLASS__, 'load_shortcodes_page' ) );
	}

	/**
	 * Add settings submenu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function settings_menu() {
		add_submenu_page(
			'advanced-shortcodes',
			__( 'Settings', 'advanced-shortcodes' ),
			__( 'Settings', 'advanced-shortcodes' ),
			'manage_options',
			'ascodes-settings',
			array( $this, 'settings_page' ),
		);
	}

	/**
	 * Render settings page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function settings_page() {
		include __DIR__ . '/views/settings.php';
	}

	/**
	 * Set screen option.
	 *
	 * @param mixed  $status Screen option value. Default false.
	 * @param string $option Option name.
	 * @param mixed  $value New option value.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	public function screen_option( $status, $option, $value ) {
		$options = apply_filters(
			'ascodes_set_screen_options',
			array(
				'ascodes_shortcodes_per_page',
			)
		);
		if ( in_array( $option, $options, true ) ) {
			return $value;
		}

		return $status;
	}

	/**
	 * Load shortcodes page & set screen options.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function load_shortcodes_page() {
		$screen = get_current_screen();
		if ( 'toplevel_page_advanced-shortcodes' === $screen->id ) {
			add_screen_option(
				'per_page',
				array(
					'label'   => __( 'Leads per page', 'advanced-shortcodes' ),
					'default' => 20,
					'option'  => 'ascodes_shortcodes_per_page',
				)
			);
		}
	}

	/**
	 * Determine if current page is add screen.
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public static function is_add_screen() {
		return filter_input( INPUT_GET, 'add' ) !== null;
	}

	/**
	 * Determine if current page is edit screen.
	 *
	 * @since 1.0.0
	 * @return false|int False if not edit screen, id if edit screen.
	 */
	public static function is_edit_screen() {
		return filter_input( INPUT_GET, 'edit', FILTER_VALIDATE_INT );
	}

	/**
	 * Render shortcodes page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function render_shortcodes_page() {
		wp_verify_nonce( '_nonce' );

		$edit      = self::is_edit_screen();
		$shortcode = get_post( $edit );

		if ( ! empty( $shortcode ) && ! $shortcode instanceof \WP_Post ) {
			wp_safe_redirect( remove_query_arg( 'edit' ) );
			exit();
		}

		if ( self::is_add_screen() ) {
			include __DIR__ . '/views/add-shortcode.php';
		} elseif ( $edit ) {
			include __DIR__ . '/views/edit-shortcode.php';
		} else {
			$list_table = new ShortcodesListTable();
			$list_table->prepare_items();
			include __DIR__ . '/views/shortcodes.php';
		}
	}

	/**
	 * Handle list table actions.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function handle_list_table_actions() {

		if ( ! current_user_can( 'manage_options' ) ) {
			advanced_shortcodes()->add_flash_notice( esc_html__( 'You do not have permission to perform this action.', 'advanced-shortcodes' ), 'error' );
			$redirect_url = remove_query_arg( array( 'action', 'action2', 'ids', '_wpnonce', '_wp_http_referer' ) );
			wp_safe_redirect( $redirect_url );
			exit;
		}

		$list_table = new ShortcodesListTable();
		$list_table->process_bulk_action();

		if ( 'delete' === $list_table->current_action() ) {
			check_admin_referer( 'bulk-shortcodes' );

			$ids       = isset( $_GET['ids'] ) ? map_deep( wp_unslash( $_GET['ids'] ), 'intval' ) : array();
			$ids       = wp_parse_id_list( $ids );
			$performed = 0;

			foreach ( $ids as $id ) {
				$shortcode = get_post( $id );
				if ( $shortcode && wp_delete_post( $shortcode->ID, true ) ) {
					++$performed;
				}
			}

			if ( ! empty( $performed ) ) {
				// translators: %s: number of accounts.
				advanced_shortcodes()->add_flash_notice( sprintf( esc_html__( '%s item(s) deleted successfully.', 'advanced-shortcodes' ), number_format_i18n( $performed ) ) );
			}

			if ( ! headers_sent() ) {
				// Redirect to avoid resubmission.
				$redirect_url = remove_query_arg( array( 'action', 'action2', 'ids', '_wpnonce', '_wp_http_referer' ) );
				wp_safe_redirect( $redirect_url );
				exit;
			}
		}
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @param string $hook The current page ID.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_scripts( $hook ) {
		if ( 'toplevel_page_advanced-shortcodes' === $hook || 'shortcodes_page_ascodes-settings' === $hook ) {
			wp_enqueue_style( 'ascodes-admin', ASCODES_URL . 'assets/css/ascodes-admin.css', array(), ASCODES_VERSION );
		}
	}
}
