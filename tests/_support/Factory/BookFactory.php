<?php
namespace Acme\Factory;

use WP_UnitTest_Factory_For_Post;
use WP_UnitTest_Generator_Sequence;

class BookFactory extends WP_UnitTest_Factory_For_Post {

	public function __construct( $factory = null ) {
		parent::__construct( $factory );
		$this->default_generation_definitions = array(
			'post_status'  => 'publish',
			'post_title'   => new WP_UnitTest_Generator_Sequence( 'Book title %s' ),
			'post_content' => new WP_UnitTest_Generator_Sequence( 'Book content %s' ),
			'post_excerpt' => new WP_UnitTest_Generator_Sequence( 'Book excerpt %s' ),
			'post_type'    => 'book'
		);
	}

	public function create_with_author_and_reviews( $reviews ) {
		$author     = ( new AuthorFactory() )->create();
		$reviewsIds = ( new ReviewFactory() )->create_many( $reviews );

		return $this->create( [
			'post_parent' => $author,
			'meta_input'  => [
				'reviews' => $reviewsIds
			]
		] );
	}
}