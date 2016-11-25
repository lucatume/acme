<?php

use Acme\TestCase\MySecondTestCase;

class FactoryTest extends MySecondTestCase {

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
		$bookId = $this->factory()->book->create_with_author_and_reviews( 3, 3 );

		$this->assertInternalType( 'int', $bookId );

		$book = get_post( $bookId );

		$this->assertInstanceOf( WP_Post::class, $book );
		$this->assertEquals( 'book', $book->post_type );
		$this->assertNotEquals( 0, $book->post_parent );

		$author = get_post( $book->post_parent );

		$this->assertInstanceOf( WP_Post::class, $author );
		$this->assertEquals( 'author', $author->post_type );

		$reviewsIds = get_post_meta( $bookId, 'review' );
		$this->assertCount( 6, $reviewsIds );

		$reviews = array_filter( array_map( 'get_post', $reviewsIds ), function ( $post ) {
			return is_a( $post, WP_Post::class )
				   && $post->post_type === 'review';
		} );

		$this->assertCount( 6, $reviews );
	}

	/**
	 * get top three good books
	 */
	public function test_get_top_three_good_books() {
		$first = $this->factory()->book->create_with_author_and_reviews( 10, 1 );
		$second = $this->factory()->book->create_with_author_and_reviews( 5, 1 );
		$third = $this->factory()->book->create_with_author_and_reviews( 2, 1 );
		$fourth = $this->factory()->book->create_with_author_and_reviews( 0, 20 );

		$expected = ( [ $first => 10, $second => 5, $third => 2 ] );

		$top_three = \Acme\acme_get_top_three_books();

		$this->assertInternalType( 'array', $top_three );
		$this->assertEquals( $expected, $top_three );
	}

	/**
	 * get top three bad books
	 */
	public function test_get_top_three_bad_books() {
		$first = $this->factory()->book->create_with_author_and_reviews( 10, 1 );
		$second = $this->factory()->book->create_with_author_and_reviews( 5, 5 );
		$third = $this->factory()->book->create_with_author_and_reviews( 2, 2 );
		$fourth = $this->factory()->book->create_with_author_and_reviews( 0, 20 );

		$expected = ( [ $fourth => 20, $second => 5, $third => 2 ] );

		$top_three = \Acme\acme_get_top_three_books( false );

		$this->assertInternalType( 'array', $top_three );
		$this->assertEquals( $expected, $top_three );
	}
}
