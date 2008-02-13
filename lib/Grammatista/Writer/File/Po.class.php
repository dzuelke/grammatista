<?php

class GrammatistaWriterFilePo extends GrammatistaWriterFile
{
	public function __construct(array $options = array())
	{
		$this->options['file.pattern'] = '%s.pot';
		
		parent::__construct($options);
	}
	
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
	
	protected function formatOutput(GrammatistaTranslatable $translatable)
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