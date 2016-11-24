<?php

class MultisiteTest extends \Codeception\TestCase\WPTestCase
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

    public function testMultisite()
    {
        $this->assertTrue(defined('MULTISITE') && MULTISITE === true);
        
        $this->assertTrue(is_plugin_active_for_network('acme/plugin.php'));

        $this->assertFalse(get_option('acme'));

        $this->assertEquals('multisite', get_network_option(null, 'acme_wp_installation'));
    }
}