<?php
/**
 * Settings.
 *
 * @since 1.0.0
 * @package AdvancedShortcodes
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

?>
<div class="wrap ascodes-wrap ascodes-settings">
	<div class="ascodes__header">
		<h1 class="wp-heading-inline">
			<?php esc_html_e( 'Settings', 'advanced-shortcodes' ); ?>
		</h1>
		<p><?php esc_html_e( 'The following options are the advanced shortcodes plugin settings.', 'advanced-shortcodes' ); ?></p>
	</div>
	<hr class="wp-header-end">
	<div class="ascodes__body">
		<form id="ascodes-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<div class="ascodes-form__content">
				<div class="field-group field-section">
					<h3><?php esc_html_e( 'General Settings', 'advanced-shortcodes' ); ?></h3>
					<p><?php esc_html_e( 'The following options are the general settings for the advanced shortcodes plugin.', 'advanced-shortcodes' ); ?></p>
				</div>

				<div class="field-group">
					<div class="field-label">
						<strong><?php esc_html_e( 'Shortcode Title:', 'advanced-shortcodes' ); ?></strong>
					</div>
					<div class="field">
						<label for="ascodes_shortcode_title">
							<input name="ascodes_shortcode_title" id="ascodes_shortcode_title" type="checkbox" value="yes" <?php checked( get_option( 'ascodes_shortcode_title' ), 'yes' ); ?>>
							<?php esc_html_e( 'Enable title', 'advanced-shortcodes' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable to display the shortcode title.', 'advanced-shortcodes' ); ?></p>
					</div>
				</div>

				<div class="field-group">
					<div class="field-label">
						<strong><?php esc_html_e( 'Shortcode Sub Title:', 'advanced-shortcodes' ); ?></strong>
					</div>
					<div class="field">
						<label for="ascodes_shortcode_sub_title">
							<input name="ascodes_shortcode_sub_title" id="ascodes_shortcode_sub_title" type="checkbox" value="yes" <?php checked( get_option( 'ascodes_shortcode_sub_title' ), 'yes' ); ?>>
							<?php esc_html_e( 'Enable sub title', 'advanced-shortcodes' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable to display the shortcode sub title.', 'advanced-shortcodes' ); ?></p>
					</div>
				</div>

				<div class="field-group">
					<div class="field-label">
						<strong><?php esc_html_e( 'Shortcode Content:', 'advanced-shortcodes' ); ?></strong>
					</div>
					<div class="field">
						<label for="ascodes_shortcode_content">
							<input name="ascodes_shortcode_content" id="ascodes_shortcode_content" type="checkbox" value="yes" <?php checked( get_option( 'ascodes_shortcode_content' ), 'yes' ); ?>>
							<?php esc_html_e( 'Enable content', 'advanced-shortcodes' ); ?>
						</label>
						<p class="description"><?php esc_html_e( 'Enable to display the shortcode content.', 'advanced-shortcodes' ); ?></p>
					</div>
				</div>

				<div class="field-group">
					<div class="field-submit-btn">
						<button class="button button-primary"><?php esc_html_e( 'Save Changes', 'advanced-shortcodes' ); ?></button>
					</div>
				</div>

				<input type="hidden" name="action" value="ascodes_update_settings">
				<?php wp_nonce_field( 'ascodes_update_settings' ); ?>
			</div>
			<div class="ascodes-form__aside">
				<div class="ascodes__sidebar">
					<div class="ascodes__sidebar__header">
						<h2><?php esc_html_e( 'Support', 'advanced-shortcodes' ); ?></h2>
					</div>
					<div class="ascodes__sidebar__body">
						<p><?php esc_html_e( 'If you need help, please contact us.', 'advanced-shortcodes' ); ?></p>
						<p>
							<a href="https://beautifulplugins.com/support" target="_blank" class="button button-secondary">
								<?php esc_html_e( 'Contact Support', 'advanced-shortcodes' ); ?>
							</a>
						</p>
					</div>
				</div>
				<div class="ascodes__sidebar">
					<div class="ascodes__sidebar__header">
						<h2><?php esc_html_e( 'Our Popular Plugins', 'advanced-shortcodes' ); ?></h2>
					</div>
					<div class="ascodes__sidebar__body">
						<ul>
							<li>
								<a href="https://wordpress.org/plugins/utm-manager/" target="_blank">
									<?php esc_html_e( 'UTM Manager', 'advanced-shortcodes' ); ?>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
