<?php
namespace Acme\Factory;

use WP_UnitTest_Factory_For_Post;
use WP_UnitTest_Generator_Sequence;

class AuthorFactory extends WP_UnitTest_Factory_For_Post {

	public function __construct( $factory = null ) {
		parent::__construct( $factory );
		$this->default_generation_definitions = array(
			'post_status'  => 'publish',
			'post_title'   => new WP_UnitTest_Generator_Sequence( 'Author name %s' ),
			'post_content' => new WP_UnitTest_Generator_Sequence( 'Author bio %s' ),
			'post_excerpt' => new WP_UnitTest_Generator_Sequence( 'Author CV %s' ),
			'post_type'    => 'author'
		);
	}
}