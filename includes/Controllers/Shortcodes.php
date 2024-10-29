<?php

namespace AdvancedShortcodes\Controllers;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Shortcodes Class.
 *
 * @since 1.0.0
 * @package AdvancedShortcodes/Controllers
 */
class Shortcodes {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_shortcode( 'a_shortcode', array( $this, 'shortcode' ) );
	}

	/**
	 * Shortcode.
	 *
	 * @param array  $atts The shortcode attributes.
	 * @param string $content The shortcode content.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function shortcode( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts,
			'a_shortcode'
		);

		$id = isset( $atts['id'] ) ? intval( $atts['id'] ) : '';

		if ( empty( $id ) ) {
			return '';
		}

		$shortcode = get_post( $id );

		if ( ! $shortcode || ! is_a( $shortcode, 'WP_Post' ) || 'publish' !== $shortcode->post_status ) {
			return '';
		}

		$is_title     = 'yes' === get_option( 'ascodes_shortcode_title' ) ? get_option( 'ascodes_shortcode_title' ) : get_post_meta( $shortcode->ID, 'ascodes_shortcode_title', true );
		$is_sub_title = 'yes' === get_option( 'ascodes_shortcode_sub_title' ) ? get_option( 'ascodes_shortcode_sub_title' ) : get_post_meta( $shortcode->ID, 'ascodes_shortcode_sub_title', true );
		$is_content   = 'yes' === get_option( 'ascodes_shortcode_content' ) ? get_option( 'ascodes_shortcode_content' ) : get_post_meta( $shortcode->ID, 'ascodes_shortcode_content', true );

		ob_start();
		?>
		<div class="ascodes-shortcode">
			<?php if ( 'yes' === $is_title ) : ?>
			<div class="ascodes-shortcode__title">
				<h2><?php echo esc_html( $shortcode->post_title ); ?></h2>
				<?php if ( 'yes' === $is_sub_title && ! empty( $content ) ) : ?>
					<p><?php echo esc_html( $content ); ?></p>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<?php if ( 'yes' === $is_content && ! empty( $shortcode->post_content ) ) : ?>
			<div class="ascodes-shortcode__content">
				<?php echo wp_kses_post( $shortcode->post_content ); ?>
			</div>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}
