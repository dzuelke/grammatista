<?php

class GrammatistaStorageSQLite extends GrammatistaStoragePdo
{
	public function __construct(array $options = array())
	{
		parent::__construct($options);

		// TODO: make configurable
		$this->connection->exec('
			CREATE TABLE translatables(
				item_name TEXT,
				line INTEGER,
				domain TEXT,
				singular_message TEXT,
				plural_message TEXT,
				comment TEXT,
				parser_name TEXT
			)
		');
		
		$this->connection->exec('
			CREATE TABLE warnings(
				item_name TEXT,
				line INTEGER,
				domain TEXT,
				singular_message TEXT,
				plural_message TEXT,
				comment TEXT,
				parser_name TEXT
			)
		');
	}
}

?>