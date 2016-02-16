<?php

namespace Grammatista\Parser\Pcre;

use Grammatista\Parser\Pcre;
use Grammatista\Entity;

class Smarty extends Pcre
{
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

		if(!isset($this->options['pcre.comment_pattern'])) {
			$this->options['pcre.comment_pattern'] = '/\{\*\s*%s\s*(?P<comment>[^\*\}]+?)\s*\*\}\s*$/';
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function handles(Entity $entity)
	{
		$retval = $entity->type == 'tpl';

		if($retval) {
			\Grammatista\Grammatista::dispatchEvent('grammatista.parser.handles', array('entity' => $entity));
		}

		return $retval;
	}

	/**
	 * {@inheritdoc}
	 */
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

		return false;
	}
}

?>