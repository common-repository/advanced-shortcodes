<?php
/**
 * Shortcodes list table.
 *
 * @since 1.0.0
 * @package AdvancedShortcodes
 *
 * @var object $list_table Shortcodes list table.
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

?>
<div class="wrap">
	<h1 class="wp-heading-inline">
		<?php esc_html_e( 'Shortcodes', 'advanced-shortcodes' ); ?>
		<small><?php echo esc_html( 'v' . ASCODES_VERSION ); ?></small>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=advanced-shortcodes&add=yes' ) ); ?>" class="page-title-action">
			<?php esc_html_e( 'Add New Shortcode', 'advanced-shortcodes' ); ?>
		</a>
	</h1>
	<hr class="wp-header-end">
	<form id="ascodes-shortcodes-table" method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>">
		<?php
		$list_table->views();
		$list_table->search_box( __( 'Search', 'advanced-shortcodes' ), 'search' );
		$list_table->display();
		?>
		<input type="hidden" name="page" value="advanced-shortcodes">
	</form>
</div>
<?php
