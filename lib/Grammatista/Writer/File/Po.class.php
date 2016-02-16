<?php

namespace Grammatista\Writer\File;

use Grammatista\Writer\File;
use Grammatista\Translatable;

class Po extends File
{
	/**
	 * {@inheritdoc}
	 */
	public function __construct(array $options = array())
	{
		if(!isset($options['file.pattern'])) {
			$this->options['file.pattern'] = '%s.pot';
		}

		parent::__construct($options);

		$headers = array();
		$headers[] = 'msgid ""';
		$headers[] = 'msgstr ""';
		$headers[] = '"MIME-Version: 1.0\\n"';
		$headers[] = '"Content-Type: text/plain; charset=utf-8\\n"';
		$headers[] = '"Content-Transfer-Encoding: 8bit\\n"';

		fwrite($this->fp, implode("\n", $headers) . "\n\n");
	}

	/**
	 * Escape a string for usage in " delimited parts of the po file.
	 *
	 * @param      string The string.
	 *
	 * @return     string The escaped string.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	protected function escapeString($string)
	{
		$parts = preg_split('/\\n/', $string);

		foreach($parts as &$part) {
			$part = addcslashes($part, "\\\0\n\r\t\"");
		}

		$retval = join('\\n"' . "\n" . '"', $parts);

		if(count($parts) > 1) {
			$retval = "\"\n\"" . $retval;
		}

		return $retval;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function formatOutput(Translatable $translatable)
	{
		$lines = array();

		if($translatable->comment !== null) {
			$lines[] = '#. ' . preg_replace('/\s+/m', ' ', $translatable->comment);
		}

		$lines[] = '#: ' . $translatable->item_name . ':' . $translatable->line;

		$lines[] = sprintf('msgid "%s"', $this->escapeString($translatable->singular_message));
		if($translatable->plural_message !== null) {
			$lines[] = sprintf('msgid_plural "%s"', $this->escapeString($translatable->plural_message));
		}

		if($translatable->plural_message !== null) {
			$lines[] = 'msgstr[0] ""';
			$lines[] = 'msgstr[1] ""';
		} else {
			$lines[] = 'msgstr ""';
		}

		return implode("\n", $lines) . "\n\n";
	}
}

?>