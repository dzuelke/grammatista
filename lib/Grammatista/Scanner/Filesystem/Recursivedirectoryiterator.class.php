<?php

class GrammatistaScannerFilesystemRecursivedirectoryiterator extends RecursiveDirectoryIterator
{
	private $rc = null;

	protected $options = array();

	public function __construct(array $options = array())
	{
		$this->options = $options;

		if(!isset($options['filesystem.path'])) {
			throw new GrammatistaException('No path given for GrammatistaScannerFilesystemRecursivedirectoryiterator');
		}

		parent::__construct($options['filesystem.path']);
	}

	protected function fetch()
	{
		while($this->valid()) {
			if($this->accept()) {
				return;
			}
			// not $this-> !
			parent::next();
		}
	}

	public function next()
	{
		parent::next();
		$this->fetch();
	}

	public function rewind()
	{
		parent::rewind();
		$this->fetch();
	}

	public function getChildren()
	{
		if($this->rc === null) {
			$this->rc = new ReflectionClass($this);
		}

		return $this->rc->newInstance(array('filesystem.path' => $this->getPathname()) + $this->options);
	}

	public function accept()
	{
		foreach($this->options['filesystem.skip_patterns'] as $pattern) {
			if(preg_match($pattern, $this->getPathname())) {
				return false;
			}
		}
		return true;
	}
}

?>