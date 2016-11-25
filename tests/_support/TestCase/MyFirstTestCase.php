<?php

namespace Acme\TestCase;

use Codeception\TestCase\WPTestCase;

class MyFirstTestCase extends WPTestCase {

	public function create_book_with_author_and_reviews( $good, $bad ) {
		$book = $this->factory()->post->create( [ 'post_type' => 'book' ] );

		$author = $this->factory()->post->create( [ 'post_type' => 'author' ] );

		wp_update_post( [ 'ID' => $book, 'post_parent' => $author ] );

		$good = $this->factory()->post->create_many( $good, [
			'post_type'   => 'review',
			'post_status' => 'good'
		] );
		$bad = $this->factory()->post->create_many( $bad, [ 'post_type' => 'review', 'post_status' => 'bad' ] );

		foreach ( array_merge( $good, $bad ) as $review_id ) {
			add_post_meta( $book, 'review', $review_id );
		}

		return $book;
	}

	public function create_many_books_with_authors_and_reviews( $reviews_count ) {
		return array_map( function ( $review_count ) {
			return $this->create_book_with_author_and_reviews( $review_count[0], $review_count[1] );
		}, $reviews_count );
	}
}