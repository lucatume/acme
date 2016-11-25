<?php
/**
 * Plugin Name:     WP Integration Tests Example Plugin
 * Plugin URI:      http://theaveragedev.com
 * Description:     An ongoing collection of WordPress integration tests
 * examples and practices. Author:          Luca Tumedei Author URI:
 * http://theaveragedev.com Text Domain:     acme Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Acme
 */

namespace Acme;

class Plugin {

	public function init() {
		$this->register_installation_type();
		$this->register_post_types();
	}

	protected function register_installation_type() {
		if ( is_multisite() ) {
			update_network_option( null, 'acme_wp_installation', 'multisite' );
		} else {
			update_option( 'acme_wp_installation', 'single' );
		}
	}

	protected function register_post_types() {
		register_post_type( 'book' );
		register_post_type( 'author' );
		register_post_type( 'review' );

		register_post_status( 'good' );
		register_post_status( 'bad' );
	}

	public function get_top_three_books( $good = true ) {
		$status = $good ? 'good' : 'bad';

		/** @var \wpdb $wpdb */
		global $wpdb;

		$target_reviews = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'review' and post_status = '{$status}'" );

		if ( empty( $target_reviews ) ) {
			return [];
		}

		$review_ids = implode( ',', $target_reviews );

		$query
			= "SELECT p.ID, COUNT(m.post_id) AS 'count' FROM {$wpdb->postmeta} m
            RIGHT JOIN {$wpdb->posts} p
            ON p.ID = m.post_id
            WHERE p.post_type = 'book' AND p.post_status = 'publish'
            AND m.meta_value IN ({$review_ids}) AND m.meta_key = 'review'
            GROUP BY(m.post_id)
            ORDER BY COUNT(m.post_id) DESC LIMIT 3";

		$top_three = $wpdb->get_results( $query );

		return empty( $top_three ) ? [] : array_combine( wp_list_pluck( $top_three, 'ID' ), wp_list_pluck( $top_three, 'count' ) );
	}
}


add_action( 'init', [ new Plugin(), 'init' ] );

function acme_get_top_three_books($good = true) {
	return ( new Plugin )->get_top_three_books( $good );
}
