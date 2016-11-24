*An ongoing playground to showcase examples and "gotchas" of WordPress integration tests.*

## Installation
Clone the plugin in your local WordPress installation plugins folder:

```shell
cd /var/www/wp/wp-content/plugins
git clone https://github.com/lucatume/acme.git
```

From the plugin root install [Composer](https://getcomposer.org/) dependencies:

```shell
cd acme
composer install
```

Finally run the tests:

```shell
codecept run integration && codecept run muintegration
```

See why running single site and multisite tests in the same run is not a good idea [here](http://theaveragedev.com/running-single-site-and-multisite-wordpress-integration-tests/).

## Usage
The plugin offers no functions and is meant to be an ongoing list of examples about WordPress integration testing.  
While you can activate it on your website it will not do anything.

## Reference
I will update this plugin code with more examples as I write more and more about WordPress integration testing in [my blog](http://theaveragedev.com); here are some good starters:

* the Core [PhpUnit](https://phpunit.de/ "PHPUnit – The PHP Testing Framework") based [testing suite](https://make.wordpress.org/core/handbook/testing/automated-testing/ "Automated Testing – Make WordPress Core")
* [Codeception](http://codeception.com/ "Codeception - BDD-style PHP testing."), the testing framework on whic `wp-browser` builds
* [wp-cli package](http://theaveragedev.com/wp-cli-wp-browser-package-added-to-the-package-index/) to scaffold [wp-browser](https://github.com/lucatume/wp-browser "lucatume/wp-browser · GitHub") based plugin tests
* [some basic principles of WordPress integration testing](http://theaveragedev.com/four-wordpress-integration-testing-easy-pieces/) 
* [running integration tests in multisite mode with wp-browser](http://theaveragedev.com/wp-browser-and-multisite/)
* [multisite integration testing basic principles](http://theaveragedev.com/four-wordpress-integration-testing-multisite-pieces/) 
* [the `post` factory](http://theaveragedev.com/using-the-post-factory-in-wordpress-integration-tests/) 
* [caveats about running single and multisite mode integration tests](http://theaveragedev.com/running-single-site-and-multisite-wordpress-integration-tests/)

