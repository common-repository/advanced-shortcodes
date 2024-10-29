<?php

namespace AdvancedShortcodes;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Class PostTypes.
 *
 * Responsible for registering custom post types.
 *
 * @since 1.0.0
 * @package AdvancedShortcodes
 */
class PostTypes {

	/**
	 * CPT constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_cpt' ) );
	}

	/**
	 * Register custom post types.
	 *
	 * @since 1.0.0
	 */
	public function register_cpt() {
		$labels = array(
			'name'               => _x( 'Shortcodes', 'post type general name', 'advanced-shortcodes' ),
			'singular_name'      => _x( 'Shortcode', 'post type singular name', 'advanced-shortcodes' ),
			'menu_name'          => _x( 'Shortcodes', 'admin menu', 'advanced-shortcodes' ),
			'name_admin_bar'     => _x( 'Shortcode', 'add new on admin bar', 'advanced-shortcodes' ),
			'add_new'            => _x( 'Add New', 'ticket', 'advanced-shortcodes' ),
			'add_new_item'       => __( 'Add New Shortcode', 'advanced-shortcodes' ),
			'new_item'           => __( 'New Shortcode', 'advanced-shortcodes' ),
			'edit_item'          => __( 'Edit Shortcode', 'advanced-shortcodes' ),
			'view_item'          => __( 'View Shortcode', 'advanced-shortcodes' ),
			'all_items'          => __( 'All Shortcodes', 'advanced-shortcodes' ),
			'search_items'       => __( 'Search Shortcodes', 'advanced-shortcodes' ),
			'parent_item_colon'  => __( 'Parent Shortcodes:', 'advanced-shortcodes' ),
			'not_found'          => __( 'No shortcodes found.', 'advanced-shortcodes' ),
			'not_found_in_trash' => __( 'No shortcodes found in Trash.', 'advanced-shortcodes' ),
		);

		$args = array(
			'labels'              => apply_filters( 'ascodes_shortcode_post_type_labels', $labels ),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => false,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'query_var'           => false,
			'can_export'          => false,
			'rewrite'             => false,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'hierarchical'        => false,
			'menu_position'       => null,
			'supports'            => array(),
		);

		register_post_type( 'ascodes_shortcode', apply_filters( 'ascodes_shortcode_post_type_args', $args ) );
	}
}
