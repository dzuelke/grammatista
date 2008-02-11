<?php

class GrammatistaWriterFilePo extends GrammatistaWriterFile
{
	public function __construct(array $options = array())
	{
		$this->options['file.pattern'] = '%s.pot';
		
		parent::__construct($options);
	}
	
	protected function formatOutput(GrammatistaTranslatable $translatable)
	{
		$lines = array();
		
		if($translatable->comment !== null) {
			$lines[] = '#. ' . preg_replace('/\s+/m', ' ', $translatable->comment);
		}
		
		$lines[] = '#: ' . $translatable->item_name . ':' . $translatable->line;
		
		$lines[] = sprintf('msgid "%s"', addslashes($translatable->singular_message));
		if($translatable->plural_message !== null) {
			$lines[] = sprintf('msgid_plural "%s"', addslashes($translatable->plural_message));
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