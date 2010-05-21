<?php

class GrammatistaParserDwoo extends GrammatistaParser
{
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
		
		$this->dwoo = new Dwoo();
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
	
	// the dwoo plugins will call this when they are compiled
	// hax <:
	public function collect($info, Dwoo_Compiler $compiler)
	{
		$info->line = $compiler->getLine();
		$info->comment = $this->extractComment($compiler);
		
		$this->items[] = $info;
	}
	
	protected function extractComment(Dwoo_Compiler $compiler)
	{
		return null;
	}
	
	public function handles(GrammatistaEntity $entity)
	{
		return $entity->type == 'tpl';
	}
	
	public function parse(GrammatistaEntity $entity)
	{
		$template = new Dwoo_Template_String($entity->content, 0);
		$template->forceCompilation();
		$this->dwoo->setTemplate($template);
		$template->getCompiledTemplate($this->dwoo);
		
		foreach($this->items as $item) {
			if($item->domain === null && $entity->default_domain !== null) {
				$item->domain = $entity->default_domain;
			}
		}
		
		return $this->items;
	}
}

?>