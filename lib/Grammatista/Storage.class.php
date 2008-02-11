<?php

abstract class GrammatistaStorage implements IGrammatistaStorage
{
	protected $options = array();
	
	public function __construct(array $options = array())
	{
		$this->options = array_merge($this->options, $options);
	}
}

?>