<?php
// Here you can initialize variables that will be available to your tests

use Codeception\Configuration;
use Codeception\Util\Autoload;

Autoload::addNamespace( 'Acme\TestCase', Configuration::supportDir() . 'TestCase' );
Autoload::addNamespace( 'Acme\Factory', Configuration::supportDir() . 'Factory' );
