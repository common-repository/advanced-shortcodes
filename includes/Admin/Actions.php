<?php

namespace AdvancedShortcodes\Admin;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Actions Class.
 *
 * @since 1.0.0
 * @package AdvancedShortcodes\Admin
 */
class Actions {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_post_ascodes_add_shortcode', array( __CLASS__, 'add_shortcode' ) );
		add_action( 'admin_post_ascodes_edit_shortcode', array( __CLASS__, 'edit_shortcode' ) );
		add_action( 'admin_post_ascodes_update_settings', array( __CLASS__, 'handle_settings' ) );
	}

	/**
	 * Add shortcode.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function add_shortcode() {
		check_admin_referer( 'ascodes_add_shortcode' );
		$referer = wp_get_referer();

		if ( ! current_user_can( 'manage_options' ) ) {
			advanced_shortcodes()->add_flash_notice( esc_html__( 'You do not have permission to perform this action.', 'advanced-shortcodes' ), 'error' );
			wp_safe_redirect( $referer );
			exit();
		}

		$title                = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$content              = isset( $_POST['content'] ) ? sanitize_textarea_field( wp_unslash( $_POST['content'] ) ) : '';
		$status               = isset( $_POST['status'] ) ? sanitize_key( wp_unslash( $_POST['status'] ) ) : '';
		$is_enabled_title     = isset( $_POST['ascodes_shortcode_title'] ) ? 'yes' : '';
		$is_enabled_sub_title = isset( $_POST['ascodes_shortcode_sub_title'] ) ? 'yes' : '';
		$is_enabled_content   = isset( $_POST['ascodes_shortcode_content'] ) ? 'yes' : '';
		$id                   = isset( $_POST['id'] ) ? intval( wp_unslash( $_POST['id'] ) ) : intval( '0' );

		$args = array(
			'ID'           => $id,
			'post_type'    => 'ascodes_shortcode',
			'post_title'   => wp_strip_all_tags( $title ),
			'post_content' => wp_kses_post( $content ),
			'post_status'  => $status,
			'meta_input'   => array(
				'ascodes_shortcode_title'     => $is_enabled_title,
				'ascodes_shortcode_sub_title' => $is_enabled_sub_title,
				'ascodes_shortcode_content'   => $is_enabled_content,
			),
		);

		$shortcode = wp_insert_post( $args );

		if ( is_wp_error( $shortcode ) ) {
			advanced_shortcodes()->add_flash_notice( esc_html( $shortcode->get_error_message() ), 'error' );
		} else {
			advanced_shortcodes()->add_flash_notice( __( 'Shortcode created successfully.', 'advanced-shortcodes' ) );

			$referer = add_query_arg(
				array( 'edit' => absint( $shortcode ) ),
				remove_query_arg( 'add', $referer )
			);
		}

		wp_safe_redirect( $referer );
		exit;
	}

	/**
	 * Edit shortcode.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function edit_shortcode() {
		check_admin_referer( 'ascodes_edit_shortcode' );
		$referer = wp_get_referer();

		if ( ! current_user_can( 'manage_options' ) ) {
			advanced_shortcodes()->add_flash_notice( esc_html__( 'You do not have permission to perform this action.', 'advanced-shortcodes' ), 'error' );
			wp_safe_redirect( $referer );
			exit();
		}

		$title                = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$content              = isset( $_POST['content'] ) ? wp_kses_post( wp_unslash( $_POST['content'] ) ) : '';
		$status               = isset( $_POST['status'] ) ? sanitize_key( wp_unslash( $_POST['status'] ) ) : '';
		$is_enabled_title     = isset( $_POST['ascodes_shortcode_title'] ) ? 'yes' : '';
		$is_enabled_sub_title = isset( $_POST['ascodes_shortcode_sub_title'] ) ? 'yes' : '';
		$is_enabled_content   = isset( $_POST['ascodes_shortcode_content'] ) ? 'yes' : '';
		$id                   = isset( $_POST['id'] ) ? intval( wp_unslash( $_POST['id'] ) ) : intval( '0' );

		$args = array(
			'ID'           => $id,
			'post_type'    => 'ascodes_shortcode',
			'post_title'   => wp_strip_all_tags( $title ),
			'post_content' => $content,
			'post_status'  => $status,
			'meta_input'   => array(
				'ascodes_shortcode_title'     => $is_enabled_title,
				'ascodes_shortcode_sub_title' => $is_enabled_sub_title,
				'ascodes_shortcode_content'   => $is_enabled_content,
			),
		);

		$shortcode = wp_insert_post( $args );

		if ( is_wp_error( $shortcode ) ) {
			advanced_shortcodes()->add_flash_notice( esc_html( $shortcode->get_error_message() ), 'error' );
		} else {
			advanced_shortcodes()->add_flash_notice( __( 'Shortcode updated successfully.', 'advanced-shortcodes' ) );
		}

		wp_safe_redirect( $referer );
		exit;
	}

	/**
	 * Updating settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function handle_settings() {
		check_admin_referer( 'ascodes_update_settings' );
		$referer = wp_get_referer();

		if ( ! current_user_can( 'manage_options' ) ) {
			advanced_shortcodes()->add_flash_notice( esc_html__( 'You do not have permission to perform this action.', 'advanced-shortcodes' ), 'error' );
			wp_safe_redirect( $referer );
			exit();
		}

		$title     = isset( $_POST['ascodes_shortcode_title'] ) ? sanitize_text_field( wp_unslash( $_POST['ascodes_shortcode_title'] ) ) : '';
		$sub_title = isset( $_POST['ascodes_shortcode_sub_title'] ) ? sanitize_text_field( wp_unslash( $_POST['ascodes_shortcode_sub_title'] ) ) : '';
		$content   = isset( $_POST['ascodes_shortcode_content'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ascodes_shortcode_content'] ) ) : '';

		update_option( 'ascodes_shortcode_title', $title );
		update_option( 'ascodes_shortcode_sub_title', $sub_title );
		update_option( 'ascodes_shortcode_content', $content );

		advanced_shortcodes()->add_flash_notice( esc_html__( 'Settings saved successfully.', 'advanced-shortcodes' ) );
		wp_safe_redirect( $referer );
		exit();
	}
}
