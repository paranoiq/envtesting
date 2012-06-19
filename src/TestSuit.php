<?php
namespace src\envtesting;

/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
class TestSuit implements \ArrayAccess, \IteratorAggregate {

	/** @var array */
	protected $tests = array();

	/** @var string */
	protected $name = __CLASS__;

	/**
	 * @param string $name
	 */
	public function __construct($name = __CLASS__) {
		$this->name = $name;
	}

	/**
	 * Randomize tests order in suit
	 * does not matter on test groups
	 *
	 * @return TestSuit
	 */
	public function shuffle() {
		shuffle($this->tests);
		return $this;
	}

	/**
	 * Run all tests in test suit
	 *
	 * @return TestSuit
	 */
	public function run() {
		foreach ($this->tests as $key => $test/** @var \envtesting\Test $test */) {
			try {
				$test->run()->setResult('OK'); // result is OK
			} catch (Error $error) {
				$test->setResult($error);
			} catch (Warning $warning) {
				$test->setResult($warning);
			} catch (\Exception $e) {
				$test->setResult($e);
			}
		}
		return $this;
	}

	/**
	 * Return testSuit name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Add new callback test to suit
	 *
	 * @param string $name
	 * @param string $group
	 * @param mixed $callback
	 * @return Test
	 */
	public function addTest($name, $callback) {
		return $this->tests[] = new Test($name, $callback);
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return str_repeat(':', 80) . PHP_EOL . str_pad($this->name, 80, ' ', STR_PAD_BOTH) . PHP_EOL . str_repeat(':', 80) .
			PHP_EOL . implode(PHP_EOL, $this->tests) . PHP_EOL;
	}

	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	// Interfaces implementation
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	/**
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset) {
		return array_key_exists($offset, $this->tests);
	}

	/**
	 * @param mixed $offset
	 * @return Test
	 */
	public function offsetGet($offset) {
		return $this->tests[$offset];
	}


	/**
	 * @param mixed $offset
	 * @param mixed $value
	 * @throws \Exception
	 */
	public function offsetSet($offset, $value) {
		if (!$value instanceof Test) {
			throw new \Exception('Usupported test type');
		}

		if ($offset === null) {
			$this->tests[] = $value;
		} else {
			$this->tests[$offset] = $value;
		}
	}

	/**
	 * @param mixed $offset
	 * @return void
	 */
	public function offsetUnset($offset) {
		if (isset($this->tests[$offset])) {
			unset($this->tests[$offset]);
		}
	}

	/**
	 * @return \ArrayIterator|\Traversable
	 */
	public function getIterator() {
		return new \ArrayIterator($this->tests);
	}
}
