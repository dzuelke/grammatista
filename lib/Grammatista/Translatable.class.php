<?php

namespace Grammatista;

class Translatable extends Valueholder
{
	/**
	 * Checks if this translatable is valid.
	 *
	 * @return     bool
	 *
	 * @since      0.1.0
	 */
	public function isValid()
	{
		return isset($this->singular_message) && $this->singular_message != '' && isset($this->domain) && $this->domain != '';
	}

	// public function __get($name)
	// {
	// 	return isset($this->info[$name]) ? $this->info[$name] : null;
	// }
	//
	// public function __isset($name)
	// {
	// 	return isset($this->info[$name]);
	// }
	//
	// public function __unset($name)
	// {
	// 	unset($this->info[$name]);
	// }
	//
	// public function __set($name, $value)
	// {
	// 	$this->info[$name] = $value;
	// }
}

?>