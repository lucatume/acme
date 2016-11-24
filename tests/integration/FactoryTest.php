<?php

use Acme\TestCase\MyTestCase;

class FactoryTest extends MyTestCase {
	/**
	 * my factory works
	 */
	public function test_my_factory_works() {
		$this->factory()->book->create();

		$this->assertCount( 1, get_posts( [ 'post_type' => 'book' ] ) );
	}

	/**
	 * book factory can create books with authors and reviews
	 */
	public function test_book_factory_can_create_books_with_authors_and_reviews() {
		$bookId = $this->factory()->book->create_with_author_and_reviews( 3 );

		$this->assertInternalType( 'int', $bookId );

		$book = get_post( $bookId );

		$this->assertInstanceOf( WP_Post::class, $book );
		$this->assertEquals( 'book', $book->post_type );
		$this->assertNotEquals( 0, $book->post_parent );

		$author = get_post( $book->post_parent );

		$this->assertInstanceOf( WP_Post::class, $author );
		$this->assertEquals( 'author', $author->post_type );

		$reviewsIds = get_post_meta( $bookId, 'reviews', true );
		$this->assertCount( 3, $reviewsIds );

		$reviews = array_filter( array_map( 'get_post', $reviewsIds ), function ( $post ) {
			return is_a( $post, WP_Post::class ) && $post->post_type === 'review';
		} );

		$this->assertCount( 3, $reviews );
	}
}
