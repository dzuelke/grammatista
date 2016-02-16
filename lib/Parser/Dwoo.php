<?php

namespace Grammatista\Parser;

use Dwoo_Template_String;
use Grammatista\Entity;
use Grammatista\Grammatista;
use Grammatista\Parser;

class Dwoo extends Parser
{
	/**
	 * @var        string The current comment.
	 */
	protected $comment = null;

	/**
	 * @var         Entity The current entity.
	 */
	protected $entity = null;

	/**
	 * @var         (\Grammatista\Translatable|\Grammatista\Warning)[] All found items.
	 */
	protected $items = array();

	/**
	 * Constructor. Accepts an array of options.
	 *
	 * @param      mixed[] $options The options.
	 *
	 * @since      0.1.0
	 */
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

	/**
	 * Destructor. Closes all open resources.
	 *
	 * @since      0.1.0
	 */
	public function __destruct()
	{
		unset($this->dwoo->_grammatista_parser_dwoo);
		unset($this->dwoo);
	}

	/**
	 * Convert a source string into it's represented value.
	 *
	 * @param      string $string The PHP string. E.g '"Line1\nLine2"'.
	 *
	 * @return     string The represented value.
	 *
	 * @since      0.1.0
	 */
	public static function extractString($string)
	{
		$tokens = token_get_all('<?php ' . $string);
		if(count($tokens) == 2 && isset($tokens[1][0])) {
			if($tokens[1][0] == T_CONSTANT_ENCAPSED_STRING) {
				return eval('return ' . $string . ';');
			} elseif($tokens[1][0] == T_STRING && strtolower($tokens[1][1]) == 'null') {
				return null;
			}
		}

		return false;
	}

	/**
	 * The dwoo plugins will call this when they are compiled.
	 *
	 * @param      \Grammatista\Translatable|\Grammatista\Warning $info The translatable item
	 *
	 * @since      0.1.0
	 */
	public function collect($info)
	{
		if(($info->domain === null || $info->domain === '') && $this->entity->default_domain !== null) {
			$info->domain = $this->entity->default_domain;
		}

		$info->comment = $this->comment;

		$this->items[] = $info;
	}

	/**
	 * The dwoo plugins will call this when they are compiled.
	 *
	 * @param      int $offset The offset
	 *
	 * @since      0.1.0
	 */
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

	/**
	 * {@inheritdoc}
	 */
	public function handles(Grammatista $grammatista, Entity $entity)
	{
		return $entity->type == 'tpl';
	}

	/**
	 * {@inheritdoc}
	 */
	public function parse(Grammatista $grammatista, Entity $entity)
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