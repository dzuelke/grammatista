<?php

namespace Grammatista\Scanner;

use FilterIterator;
use RecursiveIteratorIterator;
use Grammatista\Entity;
use Grammatista\Exception;
use Grammatista\IScanner;
use Grammatista\Scanner\Filesystem\Recursivedirectoryiterator;

class Filesystem extends FilterIterator implements IScanner
{
	/**
	 * @var        mixed[] An array of option values.
	 */
	protected $options = array();

	/**
	 * Constructor. Accepts an array of options.
	 *
	 * Available options:
	 *  - string   filesystem.path
	 *  - string   filesystem.ident.strip
	 *
	 * @param      mixed[] $options The options.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function __construct(array $options)
	{
		if(!isset($options['filesystem.path'])) {
			throw new Exception('No path given for Grammatista\\Scanner\\Filesystem');
		}

		if(!isset($options['filesystem.ident.strip'])) {
			$options['filesystem.ident.strip'] = '#^' . preg_quote($options['filesystem.path'] . '/', '#') . '#';
		}

		$this->options = $options;

		$this->innerIterator = new RecursiveIteratorIterator(new Recursivedirectoryiterator($options), RecursiveIteratorIterator::LEAVES_ONLY | RecursiveIteratorIterator::CHILD_FIRST);

		parent::__construct($this->innerIterator);
	}

	/**
	 * Passes all calls to the inner iterator.
	 *
	 * @param      string  $name The name.
	 * @param      mixed[] $args The arguments.
	 *
	 * @return     mixed
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function __call($name, $args)
	{
		return call_user_func_array(array($this->innerIterator, $name), $args);
	}

	/**
	 * Get the inner iterator.
	 *
	 * @return     \Iterator
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function getInnerIterator()
	{
		return $this->innerIterator;
	}

	/**
	 * Check whether the current element of the iterator is acceptable.
	 *
	 * @return     bool
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function accept()
	{
		return $this->innerIterator->isFile();
	}

	/**
	 * Return the current element.
	 *
	 * @return     Entity The current element.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function current()
	{
		$current = $this->innerIterator->current();

		$retval = new Entity(array(
			'ident' => preg_replace($this->options['filesystem.ident.strip'], '', $current->getRealpath()),
			'type' => pathinfo($current->getPathname(), PATHINFO_EXTENSION),
			'content' => file_get_contents($current->getRealpath()),
		));

		return $retval;
	}
}

?>