<?php

namespace Grammatista;

abstract class Parser implements IParser
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
		$this->options['comment_prefix'] = 'tc:';

		$this->options = array_merge($this->options, $options);
	}
}

?>