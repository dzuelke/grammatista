<?php

class GrammatistaStorageMySQL extends GrammatistaStoragePdo
{
	public function __construct(array $options = array())
	{	
		parent::__construct($options);

		// TODO: make configurable
		$this->connection->exec('
			DROP TABLE IF EXISTS translatables;
			CREATE TABLE translatables(
				item_name TEXT,
				line INTEGER,
				domain TEXT,
				singular_message TEXT,
				plural_message TEXT,
				comment TEXT,
				parser_name TEXT
			) COLLATE utf8_unicode_ci
		');
	
		$this->connection->exec('
			DROP TABLE IF EXISTS warnings;
			CREATE TABLE warnings(
				item_name TEXT,
				line INTEGER,
				domain TEXT,
				singular_message TEXT,
				plural_message TEXT,
				comment TEXT,
				parser_name TEXT
			) COLLATE utf8_unicode_ci
		');
	}
}

?>