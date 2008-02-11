<?php

abstract class GrammatistaWriterFile extends GrammatistaWriter
{
	public function __construct(array $options = array())
	{
		// TODO: options checks
		$this->options['file.basedir'] = getcwd();
		
		parent::__construct($options);
		
		if(!is_readable($this->options['file.basedir'])) {
			mkdir($this->options['file.basedir']);
		}
	}
	
	public function writeTranslatable(GrammatistaTranslatable $translatable)
	{
		file_put_contents($this->options['file.basedir'] . '/' . sprintf($this->options['file.pattern'], $translatable->domain), $this->formatOutput($translatable), FILE_APPEND);
	}
}

?>