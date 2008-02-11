<?php

class GrammatistaValueholder extends ArrayObject
{
	/**
	 * Constructor. Accepts an array of initial values as an argument.
	 *
	 * @param      array An array of values to be set right away.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0
	 */
	public function __construct(array $values = array())
	{
		parent::__construct($values, ArrayObject::ARRAY_AS_PROPS | ArrayObject::STD_PROP_LIST);
	}
}

?>