<?php

class GrammatistaParserPcreSmarty extends GrammatistaParserPcre
{
	public function handles(GrammatistaEntity $entity)
	{
		return $entity->type == 'tpl';
	}
	
	protected function validate($name, $value)
	{
		switch($name) {
			case 'singular_message':
			case 'plural_message':
				return preg_match('/[\{\}]/', $value) == 0;
			case 'domain':
				return preg_match('/\$/', $value) == 0;
			case 'comment':
				return true;
		}
	}
}

?>