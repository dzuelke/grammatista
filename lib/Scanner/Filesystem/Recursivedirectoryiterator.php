<?php

namespace Grammatista\Scanner\Filesystem;

use ReflectionClass;
use Grammatista\Exception;

class Recursivedirectoryiterator extends \RecursiveDirectoryIterator
{
	/**
	 * @var        ReflectionClass
	 */
	private $rc = null;

	/**
	 * @var        mixed[] An array of option values.
	 */
	protected $options = array();

	/**
	 * Constructor. Accepts an array of options.
	 *
	 * Available options:
	 *  - string   filesystem.path
	 *  - string[] filesystem.skip_patterns
	 *
	 * @param      mixed[] $options The options.
	 *
	 * @throws     Exception If the filesystem.path option is not given.
	 *
	 * @since      0.1.0
	 */
	public function __construct(array $options = array())
	{
		$this->options = $options;

		if(!isset($options['filesystem.path'])) {
			throw new Exception('No path given for Grammatista\\Scanner\\Filesystem\\Recursivedirectoryiterator');
		}

		parent::__construct($options['filesystem.path']);
	}

	/**
	 * Iterate to the next valid item.
	 *
	 * @since      0.1.0
	 */
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

	/**
	 * Move forward to next element.
	 *
	 * @since      0.1.0
	 */
	public function next()
	{
		parent::next();
		$this->fetch();
	}

	/**
	 * Rewind the Iterator to the first element.
	 *
	 * @since      0.1.0
	 */
	public function rewind()
	{
		parent::rewind();
		$this->fetch();
	}

	/**
	 * Get the iterator for the current (directory) entry.
	 *
	 * @return     Recursivedirectoryiterator The iterator.
	 *
	 * @since      0.1.0
	 */
	public function getChildren()
	{
		if($this->rc === null) {
			$this->rc = new ReflectionClass($this);
		}

		return $this->rc->newInstance(array('filesystem.path' => $this->getPathname()) + $this->options);
	}

	/**
	 * Check whether the current element of the iterator is acceptable.
	 *
	 * @return     bool
	 *
	 * @since      0.1.0
	 */
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