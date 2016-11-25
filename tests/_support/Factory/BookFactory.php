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

	public function create_with_author_and_reviews( $goodReviews, $badReviews ) {
		$author = ( new AuthorFactory() )->create();
		$good = ( new ReviewFactory() )->create_many_good( $goodReviews );
		$bad = ( new ReviewFactory() )->create_many_bad( $badReviews );

		$bookId = $this->create( [ 'post_parent' => $author ] );

		$allReviews = array_merge( $good, $bad );

		array_walk( $allReviews, function ( $id ) use ( $bookId ) {
			add_post_meta( $bookId, 'review', $id );
			add_post_meta( $id, 'forBook', $bookId );
		} );

		return $bookId;
	}
}