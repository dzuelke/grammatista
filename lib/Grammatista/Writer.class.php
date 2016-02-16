<?php

abstract class GrammatistaWriter implements IGrammatistaWriter
{
	/**
	 * @var        mixed[] An array of option values.
	 */
	protected $options = array();

	/**
	 * Constructor. Accepts an array of options.
	 *
	 * @param      mixed[] The options.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function __construct(array $options = array())
	{
		$this->options['comment_prefix'] = 'tc:';

		$this->options = array_merge($this->options, $options);
	}

	/**
	 * Transform the translatable item into an item suitable for the target format.
	 *
	 * @param      GrammatistaTranslatable The translatable item.
	 *
	 * @return     string The transformed item.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	abstract protected function formatOutput(GrammatistaTranslatable $translatable);
}

?>