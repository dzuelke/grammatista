<?php

namespace Grammatista;

abstract class Storage implements IStorage
{
	/**
	 * @var        mixed[] An array of option values.
	 */
	protected $options = array();

	/**
	 * Constructor. Accepts an array of options.
	 *
	 * @param      mixed[] $options The options.
	 *
	 * @since      0.1.0
	 */
	public function __construct(array $options = array())
	{
		$this->options = array_merge($this->options, $options);
	}
}

?>