<?php

abstract class GrammatistaWriterFile extends GrammatistaWriter
{
	protected $fp = null;
	
	public function __construct(array $options = array())
	{
		// TODO: options checks
		$this->options['file.basedir'] = getcwd();
		
		parent::__construct($options);
		
		if(!is_readable($this->options['file.basedir'])) {
			mkdir($this->options['file.basedir']);
		}
		
		$this->fp = fopen($this->options['file.basedir'] . '/' . $this->options['file.pattern'], 'w');
	}
	
	public function __destruct()
	{
		if($this->fp !== null) {
			fclose($this->fp);
		}
	}
	
	public function writeTranslatable(GrammatistaTranslatable $translatable)
	{
		fwrite($this->fp, $this->formatOutput($translatable));
		
		Grammatista::dispatchEvent('grammatista.writer.written');
	}
}

?>