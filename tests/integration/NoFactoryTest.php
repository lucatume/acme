<?php


class NoFactoryTest extends \Codeception\TestCase\WPTestCase {

	/**
	 * getting the first top three good books
	 */
	public function test_getting_the_first_top_three_good_books() {
		$books = $this->factory()->post->create_many( 4, [ 'post_type' => 'book' ] );

		$reviews_count = array_combine( $books, [
			[ 10, 1 ],
			[ 5, 2 ],
			[ 3, 3 ],
			[ 1, 20 ]
		] );

		array_walk( $books, function ( $book ) use ( $reviews_count ) {
			$author = $this->factory()->post->create( [ 'post_type' => 'author' ] );
			wp_update_post( [ 'ID' => $book, 'post_parent' => $author ] );
			$good = $this->factory()
				->post->create_many( $reviews_count[ $book ][0], [ 'post_type' => 'review', 'post_status' => 'good'] );
			$bad = $this->factory()
				->post->create_many( $reviews_count[ $book ][1], [ 'post_type' => 'review', 'post_status' => 'bad' ] );
			foreach ( array_merge( $good, $bad ) as $review_id ) {
				add_post_meta( $book, 'review', $review_id );
			}
		} );

		$expected = ( [ $books[0] => 10, $books[1] => 5, $books[2] => 3 ] );

		$top_three = \Acme\acme_get_top_three_books( );

		$this->assertInternalType( 'array', $top_three );
		$this->assertEquals( $expected, $top_three );
	}

	/**
	 * getting the first top three bad books
	 */
	public function test_getting_the_first_top_three_bad_books() {
		$books = $this->factory()->post->create_many( 4, [ 'post_type' => 'book' ] );

		$reviews_count = array_combine( $books, [
			[ 10, 1 ],
			[ 5, 2 ],
			[ 3, 3 ],
			[ 1, 20 ]
		] );

		array_walk( $books, function ( $book ) use ( $reviews_count ) {
			$author = $this->factory()->post->create( [ 'post_type' => 'author' ] );
			wp_update_post( [ 'ID' => $book, 'post_parent' => $author ] );
			$good = $this->factory()
				->post->create_many( $reviews_count[ $book ][0], [ 'post_type' => 'review', 'post_status' => 'good'] );
			$bad = $this->factory()
				->post->create_many( $reviews_count[ $book ][1], [ 'post_type' => 'review', 'post_status' => 'bad' ] );
			foreach ( array_merge( $good, $bad ) as $review_id ) {
				add_post_meta( $book, 'review', $review_id );
			}
		} );

		$expected = ( [ $books[3] => 20, $books[2] => 3, $books[1] => 2 ] );

		$top_three = \Acme\acme_get_top_three_books( false );

		$this->assertInternalType( 'array', $top_three );
		$this->assertEquals( $expected, $top_three );
	}
}