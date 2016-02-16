<?php

namespace Grammatista\Writer;

use Grammatista\Writer;
use Grammatista\Translatable;

abstract class File extends Writer
{
	/**
	 * @var        resource The open file handle.
	 */
	protected $fp = null;

	/**
	 * {@inheritdoc}
	 */
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

	/**
	 * Destructor. Closes all open resources.
	 *
	 * @since      0.1.0
	 */
	public function __destruct()
	{
		if($this->fp !== null) {
			fclose($this->fp);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function writeTranslatable(Translatable $translatable)
	{
		fwrite($this->fp, $this->formatOutput($translatable));

		\Grammatista\Grammatista::dispatchEvent('grammatista.writer.written');
	}
}

?>