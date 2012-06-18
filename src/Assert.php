<?php
namespace src\envtesting;

/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
class Assert {
	/**
	 * Compare $actual and $expected return true when it's equal
	 *
	 * @param mixed $actual
	 * @param mixed $expected
	 * @param string|null $message
	 * @throws Error
	 * @return void
	 */
	public static function same($actual, $expected, $message = null) {
		if ($actual !== $expected) {
			throw new Error($message);
		}
	}

	/**
	 * @param string|null $message
	 * @throws Error
	 * @return void
	 */
	public static function fail($message = null) {
		throw new Error($message);
	}

	/**
	 * @param mixed $value
	 * @param null|string $message
	 * @throws Error
	 * @return void
	 */
	public static function true($value, $message = null) {
		if ($value !== true) {
			throw new Error($message);
		}
	}

}