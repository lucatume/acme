<?php

use Acme\TestCase\MyFirstTestCase;

class ExtendingTestCaseTest extends MyFirstTestCase {

	/**
	 * getting the first top three good books
	 */
	public function test_getting_the_first_top_three_good_books() {
		$reviews_count = [
			[ 10, 1 ],
			[ 5, 2 ],
			[ 3, 3 ],
			[ 1, 20 ]
		];

		$books = $this->create_many_books_with_authors_and_reviews( $reviews_count );

		$expected = ( [ $books[0] => 10, $books[1] => 5, $books[2] => 3 ] );

		$top_three = \Acme\acme_get_top_three_books();

		$this->assertInternalType( 'array', $top_three );
		$this->assertEquals( $expected, $top_three );
	}


	/**
	 * getting the first top three bad books
	 */
	public function test_getting_the_first_top_three_bad_books() {
		$reviews_count = [
			[ 10, 1 ],
			[ 5, 2 ],
			[ 3, 3 ],
			[ 1, 20 ]
		];

		$books = $this->create_many_books_with_authors_and_reviews( $reviews_count );

		$expected = ( [ $books[3] => 20, $books[2] => 3, $books[1] => 2 ] );

		$top_three = \Acme\acme_get_top_three_books( false );

		$this->assertInternalType( 'array', $top_three );
		$this->assertEquals( $expected, $top_three );
	}
}
