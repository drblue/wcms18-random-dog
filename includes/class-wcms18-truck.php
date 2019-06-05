<?php

class Truck {

	protected $driver;

	public function __construct($driver) {
		$this->driver = $driver;
	}

	protected function drive() {
		if ($this->driver === "Aaron") {
			throw new Exception("You is Aaron.");
		}

		return true;
	}
}

$feta_lastbilen = new Truck("Aaron");
$feta_lastbilen->drive(); // Fatal Exception: You is Aaron.

$even_more_feta_lastbilen = new Truck("Fabbo");
$even_more_feta_lastbilen->drive(); // true
