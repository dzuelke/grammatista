<?php

namespace Grammatista;

use ArrayObject;

class Valueholder extends ArrayObject
{
	/**
	 * Constructor. Accepts an array of initial values as an argument.
	 *
	 * @param      array An array of values to be set right away.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function __construct(array $values = array())
	{
		parent::__construct($values, ArrayObject::ARRAY_AS_PROPS);
	}
}

?>