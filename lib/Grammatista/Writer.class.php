<?php

abstract class GrammatistaWriter implements IGrammatistaWriter
{
	protected $options = array();
	
	public function __construct(array $options = array())
	{
		$this->options['comment_prefix'] = 'tc:';
		
		$this->options = array_merge($this->options, $options);
	}
	
	abstract protected function formatOutput(GrammatistaTranslatable $translatable);
}

?>