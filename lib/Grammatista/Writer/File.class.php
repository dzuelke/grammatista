<?php

abstract class GrammatistaWriterFile extends GrammatistaWriter
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
	 * @author     David Zülke <david.zuelke@bitextender.com>
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
	public function writeTranslatable(GrammatistaTranslatable $translatable)
	{
		fwrite($this->fp, $this->formatOutput($translatable));

		Grammatista::dispatchEvent('grammatista.writer.written');
	}
}

?>