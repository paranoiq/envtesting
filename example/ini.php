<?php
/**
 * Test chek php.ini variables
 *
 * @author Roman Ozana <roman@omdesign.cz>
 */
require_once __DIR__ . '/../Envtesting.php';

use \envtesting\Check;
use \envtesting\Suite;
use \envtesting\Assert;

$suite = new Suite('php.ini settings');

// check log_errors
$suite->addTest(
	'error_reporting', function() {
		Assert::true(Check::ini('log_errors', '1'), 'log_errors is OFF');
	}
)->setType('INI');

// check display errors
$suite->addTest(
	'display_errors', function() {
		Assert::true(Check::ini('display_errors', '1'), 'display_errors is OFF');
	}
)->setType('INI');

// check post_max_size

$suite->addTest(
	'post_max_size', function() {
		$size = Check::ini('post_max_size');
		Assert::true($size > 256, 'post_max_size = ' . $size . ' is smaller then 256MB');
	}
)->setType('INI');

echo $suite->run();


echo '--------------------------------------------------------------------------------' . PHP_EOL; // or KISS way

try {
	Assert::true(Check::ini('post_max_size') > 10000, 'post_max_size is smaller then 10000 MB');
	Assert::true(Check::ini('log_errors', '1'), 'log_errors is OFF');
	Assert::true(Check::ini('display_errors', '1'), 'log_errors is OFF');
} catch (\envtesting\Error $e) {
	echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
