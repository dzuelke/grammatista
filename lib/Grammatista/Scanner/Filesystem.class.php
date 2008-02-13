<?php

class GrammatistaScannerFilesystem extends FilterIterator implements IGrammatistaScanner
{
	protected $options = array();
	
	public function __construct(array $options)
	{
		if(!isset($options['filesystem.path'])) {
			throw new GrammatistaException('No path given for GrammatistaScannerFilesystem');
		}
		
		if(!isset($options['filesystem.ident.strip'])) {
			$options['filesystem.ident.strip'] = $options['filesystem.path'] . '/';
		}
		
		$this->options = $options;
		
		$this->innerIterator = new RecursiveIteratorIterator(new GrammatistaScannerFilesystemRecursivedirectoryiterator($options), RecursiveIteratorIterator::LEAVES_ONLY | RecursiveIteratorIterator::CHILD_FIRST);
		
		parent::__construct($this->innerIterator);
	}
	
	public function __call($name, $args)
	{
		return call_user_func_array(array($this->innerIterator, $name), $args);
	}
	
	public function getInnerIterator()
	{
		return $this->innerIterator;
	}
	
	public function accept()
	{
		return $this->innerIterator->isFile();
	}
	
	public function current()
	{
		$current = $this->innerIterator->current();
		
		$retval = new GrammatistaEntity(array(
			'ident' => preg_replace('#^' . preg_quote($this->options['filesystem.ident.strip'], '#') . '#', '', $current->getRealpath()),
			'type' => pathinfo($current->getPathname(), PATHINFO_EXTENSION),
			'content' => file_get_contents($current->getRealpath()),
		));
		
		return $retval;
	}
}

?>