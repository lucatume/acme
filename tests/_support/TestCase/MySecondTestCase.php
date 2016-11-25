<?php

namespace Acme\TestCase;

use Acme\Factory\AuthorFactory;
use Acme\Factory\BookFactory;
use Acme\Factory\ReviewFactory;

class MySecondTestCase extends MyFirstTestCase {

	function setUp() {
		parent::setUp();

		$this->factory()->book = new BookFactory();
		$this->factory()->author = new AuthorFactory();
		$this->factory()->review = new ReviewFactory();
	}

	public function create_book_with_author_and_reviews( $good, $bad ) {
		$author = $this->factory()->author->create();
		$book = $this->factory()->book->create( [ 'post_parent' => $author ] );

		$good = $this->factory()->review->create_many_good( $good );
		$bad = $this->factory()->post->create_many_bad( $bad );

		foreach ( array_merge( $good, $bad ) as $review_id ) {
			add_post_meta( $book, 'review', $review_id );
		}

		return $book;
	}
}