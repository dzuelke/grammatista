<?php

class GrammatistaStoragePdo extends GrammatistaStorage
{
	protected $connection = null;
	
	public function __construct(array $options = array())
	{
		$this->options['pdo.dsn'] = null;
		$this->options['pdo.username'] = null;
		$this->options['pdo.password'] = null;
		$this->options['pdo.driver_options'] = array();
		$this->options['pdo.attributes'] = array();
		$this->options['pdo.init_queries'] = array();
		$this->options['pdo.translatable_class_name'] = 'GrammatistaTranslatablePdo';
		$this->options['pdo.translatable_class_ctorargs'] = array();
		
		parent::__construct($options);
		
		// TODO: checks <:
		if(!isset($this->options['pdo.attributes'][PDO::ATTR_ERRMODE])) {
			$this->options['pdo.attributes'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		}
		
		$this->connection = new PDO($this->options['pdo.dsn'], $this->options['pdo.username'], $this->options['pdo.password'], $this->options['pdo.driver_options']);
		foreach((array)$this->options['pdo.attributes'] as $attribute => $value) {
			$this->connection->setAttribute($attribute, $value);
		}
		foreach((array)$this->options['pdo.init_queries'] as $query) {
			$this->connection->executeQuery($query);
		}
		
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
	
	public function readTranslatables($unique = true, $order = 'domain')
	{
		return $this->connection->query('SELECT * FROM translatables ' . ($unique ? 'GROUP BY domain, singular_message ' : '') . 'ORDER BY domain, item_name, line', PDO::FETCH_CLASS, $this->options['pdo.translatable_class_name'], $this->options['pdo.translatable_class_ctorargs']);
	}
	
	public function readWarnings()
	{
		return $this->connection->query('SELECT * FROM warnings', PDO::FETCH_CLASS, $this->options['pdo.translatable_class_name'], $this->options['pdo.translatable_class_ctorargs']);
	}
	
	public function writeTranslatable(GrammatistaTranslatable $info)
	{
		Grammatista::dispatchEvent('grammatista.storage.translatable.writing', array('translatable' => $info));
		
		$stmt = $this->connection->prepare('INSERT INTO translatables (item_name, line, domain, singular_message, plural_message, comment, parser_name) VALUES(:item_name, :line, :domain, :singular_message, :plural_message, :comment, :parser_name)');
		$stmt->bindValue(':item_name', $info['item_name'], PDO::PARAM_STR);
		$stmt->bindValue(':line', $info['line'], PDO::PARAM_INT);
		$stmt->bindValue(':domain', $info['domain'], PDO::PARAM_STR);
		$stmt->bindValue(':singular_message', $info['singular_message'], PDO::PARAM_STR);
		$stmt->bindValue(':plural_message', $info['plural_message'], PDO::PARAM_STR);
		$stmt->bindValue(':comment', $info['comment'], PDO::PARAM_STR);
		$stmt->bindValue(':parser_name', $info['parser_name'], PDO::PARAM_STR);
		$stmt->execute();
		
		Grammatista::dispatchEvent('grammatista.storage.translatable.written', array('translatable' => $info));
	}
	
	public function writeWarning(GrammatistaWarning $info)
	{
		Grammatista::dispatchEvent('grammatista.storage.warning.writing', array('warning' => $info));
		
		$stmt = $this->connection->prepare('INSERT INTO warnings (item_name, line, domain, singular_message, plural_message, comment, parser_name) VALUES(:item_name, :line, :domain, :singular_message, :plural_message, :comment, :parser_name)');
		$stmt->bindValue(':item_name', $info['item_name'], PDO::PARAM_STR);
		$stmt->bindValue(':line', $info['line'], PDO::PARAM_INT);
		$stmt->bindValue(':domain', $info['domain'], PDO::PARAM_STR);
		$stmt->bindValue(':singular_message', $info['singular_message'], PDO::PARAM_STR);
		$stmt->bindValue(':plural_message', $info['plural_message'], PDO::PARAM_STR);
		$stmt->bindValue(':comment', $info['comment'], PDO::PARAM_STR);
		$stmt->bindValue(':parser_name', $info['parser_name'], PDO::PARAM_STR);
		$stmt->execute();
		
		Grammatista::dispatchEvent('grammatista.storage.warning.written', array('warning' => $info));
	}
	
	public function __destruct()
	{
		// close PDO connection
		$this->connection = null;
	}
}

?>