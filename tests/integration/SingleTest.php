<?php

class SingleTest extends \Codeception\TestCase\WPTestCase
{

    public function setUp()
    {
        // before
        parent::setUp();

        // your set up methods here
    }

    public function tearDown()
    {
        // your tear down methods here

        // then
        parent::tearDown();
    }

    public function testSingle()
    {
        $this->assertTrue(is_plugin_active('acme/plugin.php' ));

        $this->assertEquals('single', get_option('acme_wp_installation'));
    }
}
