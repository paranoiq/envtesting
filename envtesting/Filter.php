<?php
namespace envtesting;
/**
 * @author Roman Ozana <ozana@omdesign.cz>
 */
class Filter {

	/** @var null|string */
	public $type = null;
	/** @var null|string */
	public $group = null;
	/** @var null|string */
	public $name = null;


	/**
	 * @param null|string $name
	 * @param null|string $type
	 * @param null|string $group
	 */
	public function __construct($name = null, $type = null, $group = null) {
		$this->name = $name;
		$this->group = $group;
		$this->type = $type;
	}

	/**
	 * @return bool
	 */
	public function isActive() {
		return $this->type !== null || $this->name !== null || $this->group !== null;
	}

	/**
	 * Check if input test is active
	 *
	 * @param Test $test
	 * @param Suit $suit
	 * @return boolean
	 */
	public function isValid(Test $test, Suit $suit) {
		return $this->isActive() ? ($this->name && $test->getName() === $this->name) ||
			($this->type && $test->getType() === $this->type) ||
			($this->group && $suit->getCurrentGroupName() === $this->group) : true;
	}


	/**
	 * @param array $array
	 * @return Filter
	 */
	public static function instanceFromArray(array $array) {
		return new self(
			isset($array['name']) ? (string)$array['name'] : null,
			isset($array['type']) ? (string)$array['type'] : null,
			isset($array['group']) ? (string)$array['group'] : null
		);
	}

}