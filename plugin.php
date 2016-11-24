<?php
/**
 * Plugin Name:     WP Integration Tests Example Plugin
 * Plugin URI:      http://theaveragedev.com
 * Description:     An ongoing collection of WordPress integration tests examples and practices.
 * Author:          Luca Tumedei
 * Author URI:      http://theaveragedev.com
 * Text Domain:     acme
 * Domain Path:     /languages
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
	}
}


add_action( 'init', [ new Plugin(), 'init' ] );
