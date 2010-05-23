<?php

class GrammatistaParserDwoo extends GrammatistaParser
{
	// current comment
	protected $comment = null;
	// current entity
	protected $entity = null;
	// all found items
	protected $items = array();
	
	public function __construct(array $options = array())
	{
		parent::__construct($options);
		
		if(!class_exists('Dwoo')) {
			if(isset($this->options['dwoo_autoload_path'])) {
				require($this->options['dwoo_autoload_path']);
			} else {
				require('dwooAutoload.php');
			}
		}
		
		$this->dwoo = new Dwoo(isset($this->options['compile_dir']) ? $this->options['compile_dir'] : sys_get_temp_dir());
		$this->dwoo->_grammatista_parser_dwoo = $this;
		
		foreach(array_merge($this->options['runtime_plugin_dirs'], $this->options['grammatista_plugin_dirs']) as $dir) {
			$this->dwoo->getLoader()->addDirectory($dir);
		}
	}
	
	public function __destruct()
	{
		unset($this->dwoo->_grammatista_parser_dwoo);
		unset($this->dwoo);
	}
	
	public static function extractString($string)
	{
		$tokens = token_get_all('<?php ' . $string);
		if(count($tokens) == 2 && $tokens[1][0] == T_CONSTANT_ENCAPSED_STRING) {
			return eval('return ' . $string . ';');
		}
	}
	
	// the dwoo plugins will call this when they are compiled
	// hax <:
	public function collect($info)
	{
		if(($info->domain === null || $info->domain === '') && $this->entity->default_domain !== null) {
			$info->domain = $this->entity->default_domain;
		}
		
		$info->comment = $this->comment;
		
		$this->items[] = $info;
	}
	
	public function collectComment($offset)
	{
		if($offset > 0) {
			if(preg_match(sprintf('#\{\*(?!.*\{\*)\s*%s\s*(.+?)\s*\*\}\s*$#', $this->options['comment_prefix']), substr($this->entity->content, 0, $offset), $matches)) {
				$this->comment = $matches[1];
				return;
			}
		}
		
		$this->comment = null;
	}
	
	public function handles(GrammatistaEntity $entity)
	{
		return $entity->type == 'tpl';
	}
	
	public function parse(GrammatistaEntity $entity)
	{
		$this->entity = $entity;
		
		$template = new Dwoo_Template_String($entity->content, 0);
		$template->forceCompilation();
		$this->dwoo->setTemplate($template);
		$template->getCompiledTemplate($this->dwoo);
		
		$this->entity = null;
		
		return $this->items;
	}
}

?>