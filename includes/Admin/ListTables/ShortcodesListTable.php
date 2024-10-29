<?php

namespace AdvancedShortcodes\Admin\ListTables;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

// WP_List_Table is not loaded automatically, so we need to load it in our application.
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Class LeadsListTable.
 *
 * @since 1.0.0
 * @package AdvancedShortcodes\Admin\ListTables
 */
class ShortcodesListTable extends \WP_List_Table {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->screen = get_current_screen();
		parent::__construct(
			array(
				'singular' => 'shortcode',
				'plural'   => 'shortcodes',
				'ajax'     => false,
			)
		);
	}

	/**
	 * Prepare items.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function prepare_items() {
		wp_verify_nonce( '_wpnonce' );
		$columns               = $this->get_columns();
		$hidden                = $this->get_hidden_columns();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$per_page              = $this->get_items_per_page( 'ascodes_shortcodes_per_page', 20 );
		$paged                 = $this->get_pagenum();
		$order_by              = isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : '';
		$order                 = isset( $_GET['order'] ) ? sanitize_text_field( wp_unslash( $_GET['order'] ) ) : '';
		$search                = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';

		$args = array(
			'post_type'      => 'ascodes_shortcode',
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			's'              => $search,
			'orderby'        => $order_by,
			'order'          => $order,
			'post_status'    => 'any',
		);

		/**
		 * Filter the query arguments for the list table.
		 *
		 * @param array $args An associative array of arguments.
		 *
		 * @since 1.0.0
		 */
		$args = apply_filters( 'ascodes_shortcodes_table_query_args', $args );

		$this->items = ascodes_get_shortcodes( $args );
		$total       = ascodes_get_shortcodes( $args, true );

		$this->set_pagination_args(
			array(
				'total_items' => $total,
				'per_page'    => $per_page,
			)
		);
	}

	/**
	 * No items found text.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function no_items() {
		esc_html_e( 'No shortcodes found.', 'advanced-shortcodes' );
	}


	/**
	 * Get the table columns
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function get_columns() {
		$columns = array(
			'cb'          => '<input type="checkbox" />',
			'name'        => __( 'Name', 'advanced-shortcodes' ),
			'shortcode'   => __( 'Shortcode', 'advanced-shortcodes' ),
			'description' => __( 'Description', 'advanced-shortcodes' ),
			'status'      => __( 'Status', 'advanced-shortcodes' ),
			'date'        => __( 'Date', 'advanced-shortcodes' ),
		);

		return $columns;
	}

	/**
	 * Get hidden columns.
	 */
	public function get_hidden_columns() {
		return get_hidden_columns( get_current_screen() );
	}

	/**
	 * Get sortable columns.
	 */
	public function get_sortable_columns() {
		return array(
			'name'   => array( 'post_title', true ),
			'status' => array( 'post_status', true ),
		);
	}

	/**
	 * Get primary columns name. or define the primary column name.
	 */
	public function get_primary_column_name() {
		return 'name';
	}

	/**
	 * Renders the checkbox column in the items list table.
	 *
	 * @param Object $item The current master key object.
	 *
	 * @return string Displays a checkbox.
	 * @since  1.0.0
	 */
	public function column_cb( $item ) {
		return sprintf( '<input type="checkbox" name="ids[]" value="%d"/>', esc_attr( $item->ID ) );
	}

	/**
	 * Renders the master_key column in the items list table.
	 *
	 * @param Object $item The current master key object.
	 *
	 * @return string Displays the Master key.
	 * @since  1.0.0
	 */
	public function column_name( $item ) {
		$edit_url   = add_query_arg( array( 'edit' => $item->ID ), admin_url( 'admin.php?page=advanced-shortcodes' ) );
		$delete_url = add_query_arg(
			array(
				'ids'    => $item->ID,
				'action' => 'delete',
			),
			admin_url( 'admin.php?page=advanced-shortcodes' )
		);
		$item_title = sprintf( '<a href="%1$s">%2$s</a>', $edit_url, esc_html( $item->post_title ) );
		// translators: %d: key id.
		$actions['ids']    = sprintf( __( 'ID: %d', 'advanced-shortcodes' ), esc_html( $item->ID ) );
		$actions['edit']   = sprintf( '<a href="%1$s">%2$s</a>', $edit_url, __( 'Edit', 'advanced-shortcodes' ) );
		$actions['delete'] = sprintf( '<a href="%1$s">%2$s</a>', wp_nonce_url( $delete_url, 'bulk-' . $this->_args['plural'] ), __( 'Delete', 'advanced-shortcodes' ) );

		return sprintf( '%1$s %2$s', $item_title, $this->row_actions( $actions ) );
	}

	/**
	 * Get bulk actions.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_bulk_actions() {
		return array(
			'delete' => __( 'Delete', 'advanced-shortcodes' ),
		);
	}

	/**
	 * Display column shortcode_id.
	 *
	 * @param Object $item Item.
	 *
	 * @since 1.0.0
	 */
	protected function column_shortcode( $item ) {
		$shortcode = '[a_shortcode id="' . $item->ID . '"]';

		return esc_html( $shortcode ?? '&mdash;' );
	}

	/**
	 * Display column description.
	 *
	 * @param Object $item Item.
	 *
	 * @since 1.0.0
	 * @return string Description.
	 */
	protected function column_description( $item ) {
		// Get the post content and trim it to 10 words.
		$description_excerpt = wp_trim_words( $item->post_content, 10, '...' );

		return wp_kses_post( $description_excerpt ?? '&mdash;' );
	}

	/**
	 * Display column status.
	 *
	 * @param Object $item Item.
	 *
	 * @since 1.0.0
	 * @return string Status.
	 */
	protected function column_status( $item ) {
		$status = $item->post_status;
		$status = get_post_status_object( $status );
		$status = $status->label;

		return esc_html( $status ?? '&mdash;' );
	}

	/**
	 * Display column date.
	 *
	 * @param Object $item Item.
	 *
	 * @since 1.0.0
	 * @return string Date.
	 */
	protected function column_date( $item ) {
		$value = '&mdash;';
		$date  = $item->post_date;
		if ( $date ) {
			$value = sprintf( '<time datetime="%s">%s</time>', esc_attr( $date ), esc_html( date_i18n( get_option( 'date_format' ) . ' | ' . get_option( 'time_format' ), strtotime( $date ) ) ) );
		}

		return $value;
	}
}
