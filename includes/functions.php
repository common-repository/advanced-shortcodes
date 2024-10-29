<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Get shortcode.
 *
 * @param mixed $data The data.
 *
 * @since 1.0.0
 * @return WP_Post|false The shortcode object, or false if not found.
 */
function ascodes_get_shortcode( $data ) {

	if ( is_numeric( $data ) ) {
		$data = get_post( $data );
	}

	if ( $data instanceof WP_Post && 'ascodes_shortcode' === $data->post_type ) {
		return $data;
	}

	return false;
}

/**
 * Get shortcodes.
 *
 * @param array $args The args.
 * @param bool  $count Whether to return a count.
 *
 * @since 1.0.0
 * @return array|int The shortcodes.
 */
function ascodes_get_shortcodes( $args = array(), $count = false ) {
	$defaults = array(
		'post_type'      => 'ascodes_shortcode',
		'posts_per_page' => - 1,
		'orderby'        => 'date',
		'order'          => 'ASC',
	);

	$args  = wp_parse_args( $args, $defaults );
	$query = new WP_Query( $args );

	if ( $count ) {
		return $query->found_posts;
	}

	return array_map( 'ascodes_get_shortcode', $query->posts );
}
