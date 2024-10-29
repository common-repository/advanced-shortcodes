<?php
/**
 * The template for adding a shortcode.
 *
 * @since 1.0.0
 * @package AdvancedShortcodes/Admin/Views
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

?>
<div class="wrap ascodes-wrap">
	<div class="ascodes__header">
		<h1 class="wp-heading-inline">
			<?php esc_html_e( 'Add Shortcode', 'advanced-shortcodes' ); ?>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=advanced-shortcodes' ) ); ?>" class="page-title-action">
				<?php esc_html_e( 'Go Back', 'advanced-shortcodes' ); ?>
			</a>
		</h1>
		<p><?php esc_html_e( 'You can create a new shortcode here. This form will create a new shortcode.', 'advanced-shortcodes' ); ?></p>
	</div>
	<div class="ascodes__body">
		<form id="ascodes-form" class="inline-fields" method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<div class="ascodes-form__content">
				<div class="form-field">
					<label for="title"><strong><?php esc_html_e( 'Title', 'advanced-shortcodes' ); ?></strong><abbr title="required">*</abbr></label>
					<div class="input-group">
						<input type="text" name="title" id="title" class="regular-text" placeholder="Enter shortcode title" required="required"/>
					</div>
					<p class="description">
						<?php esc_html_e( 'Enter the shortcode title.', 'advanced-shortcodes' ); ?>
					</p>
				</div>
				<div class="form-field">
					<label for="content"><strong><?php esc_html_e( 'Content', 'advanced-shortcodes' ); ?></strong></label>
					<div class="input-group">
						<?php
						wp_editor(
							'',
							'content',
							array(
								'textarea_name' => 'content',
								'textarea_rows' => 10,
								'teeny'         => true,
							)
						);
						?>
					</div>
					<p class="description">
						<?php esc_html_e( 'Enter the shortcode content.', 'advanced-shortcodes' ); ?>
					</p>
				</div>
			</div>
			<div class="ascodes-form__aside">
				<div class="ascodes__sidebar">
					<div class="ascodes__sidebar__header">
						<h2><?php esc_html_e( 'Actions', 'advanced-shortcodes' ); ?></h2>
					</div>
					<div class="ascodes__sidebar__body">
						<div class="form-field">
							<label for="status"><strong><?php esc_html_e( 'Status', 'advanced-shortcodes' ); ?></strong></label>
							<div class="input-group">
								<select name="status" id="status">
									<option value="publish"><?php esc_html_e( 'Publish', 'advanced-shortcodes' ); ?></option>
									<option value="draft"><?php esc_html_e( 'Draft', 'advanced-shortcodes' ); ?></option>
									<option value="pending"><?php esc_html_e( 'Pending', 'advanced-shortcodes' ); ?></option>
								</select>
							</div>
							<p class="description">
								<?php esc_html_e( 'Select the status of the shortcode.', 'advanced-shortcodes' ); ?>
							</p>
						</div>
					</div>
					<div class="ascodes__sidebar__footer">
						<input type="hidden" name="action" value="ascodes_add_shortcode"/>
						<?php wp_nonce_field( 'ascodes_add_shortcode' ); ?>
						<?php submit_button( __( 'Add Shortcode', 'advanced-shortcodes' ), 'primary', 'add_shortcode' ); ?>
					</div>
				</div>

				<div class="ascodes__sidebar">
					<div class="ascodes__sidebar__header">
						<h2><?php esc_html_e( 'Shortcode', 'advanced-shortcodes' ); ?>
							<small title="<?php esc_attr_e( 'Copy Shortcode', 'advanced-shortcodes' ); ?>"><?php esc_html_e( 'Copy', 'advanced-shortcodes' ); ?></small>
						</h2>
					</div>
					<div class="ascodes__sidebar__body">
						<div class="form-field">
							<label for="ascodes_shortcode">
								<strong><?php esc_html_e( 'Shortcode', 'advanced-shortcodes' ); ?></strong>
							</label>
							<div class="input-group">
								<input type="text" name="ascodes_shortcode" id="ascodes_shortcode" class="regular-text" value="[a_shortcode id='']" readonly="readonly"/>
							</div>
							<p class="description">
								<?php esc_html_e( 'Use this shortcode to display the shortcode contents on your website.', 'advanced-shortcodes' ); ?>
							</p>
						</div>
					</div>
				</div>

				<div class="ascodes__sidebar">
					<div class="ascodes__sidebar__header">
						<h2><?php esc_html_e( 'Shortcode Settings', 'advanced-shortcodes' ); ?></h2>
					</div>
					<div class="ascodes__sidebar__body">
						<div class="form-field">
							<label for="ascodes_shortcode_title">
								<input type="checkbox" name="ascodes_shortcode_title" id="ascodes_shortcode_title" <?php checked( 'yes', get_option( 'ascodes_shortcode_title', 'yes' ) ); ?>/>
								<strong><?php esc_html_e( 'Shortcode Title', 'advanced-shortcodes' ); ?></strong>
							</label>
							<p class="description">
								<?php esc_html_e( 'Enable to display the shortcode title. This will overwrite the global settings.', 'advanced-shortcodes' ); ?>
							</p>
						</div>
						<div class="form-field">
							<label for="ascodes_shortcode_sub_title">
								<input type="checkbox" name="ascodes_shortcode_sub_title" id="ascodes_shortcode_sub_title" <?php checked( 'yes', get_option( 'ascodes_shortcode_sub_title', 'yes' ) ); ?>/>
								<strong><?php esc_html_e( 'Shortcode Sub Title', 'advanced-shortcodes' ); ?></strong>
							</label>
							<p class="description">
								<?php esc_html_e( 'Enable to display the shortcode sub title. This will overwrite the global settings.', 'advanced-shortcodes' ); ?>
							</p>
						</div>
						<div class="form-field">
							<label for="ascodes_shortcode_content">
								<input type="checkbox" name="ascodes_shortcode_content" id="ascodes_shortcode_content" <?php checked( 'yes', get_option( 'ascodes_shortcode_content', 'yes' ) ); ?>/>
								<strong><?php esc_html_e( 'Shortcode Content', 'advanced-shortcodes' ); ?></strong>
							</label>
							<p class="description">
								<?php esc_html_e( 'Enable to display the shortcode content. This will overwrite the global settings.', 'advanced-shortcodes' ); ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
