<?php

namespace Acme\TestCase;

use Acme\Factory\AuthorFactory;
use Acme\Factory\BookFactory;
use Acme\Factory\ReviewFactory;
use Codeception\TestCase\WPTestCase;

class MyTestCase extends WPTestCase {

	function setUp() {
		parent::setUp();

		$this->factory()->book   = new BookFactory();
		$this->factory()->author = new AuthorFactory();
		$this->factory()->review = new ReviewFactory();
	}
}