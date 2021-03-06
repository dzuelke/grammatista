<?php

namespace Grammatista\Parser;

use Grammatista\Entity;
use Grammatista\Grammatista;
use Grammatista\Parser;
use Grammatista\Translatable;
use Grammatista\Warning;

abstract class Pcre extends Parser
{
	/**
	 * {@inheritdoc}
	 */
	public function parse(Grammatista $grammatista, Entity $entity)
	{
		$grammatista->dispatchEvent('grammatista.parser.parsing', array('entity' => $entity));

		$retval = array();

		$lastComment = null;

		foreach($this->options['pcre.patterns'] as $pattern => $patternInfo) {
			if(preg_match_all($pattern, $entity->content, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
				// var_dump('match!', $pattern, $matches);
				foreach($matches as $match) {
					$problem = false;

					if($patternInfo === false) {
						// instructed not to match this, but emit warning instead!
						$problem = true;
					}

					$info = array();
					foreach($match as $key => $data) {
						if($key === 'subpattern') {
							// assume no children matched initially
							$problem = true;

							if(is_array($patternInfo)) {
								foreach((array)$patternInfo as $subpattern => $subpatternInfo) {
									if(preg_match($subpattern, $data[0], $submatches)) {
										// var_dump('submatch!', $subpattern, $submatches);
										foreach($submatches as $subkey => $subdata) {
											if(is_string($subkey)) {
												$info[$subkey] = $subdata;
											}
										}
										// true or false, dictated by the subpattern
										$problem = !$subpatternInfo;
										// var_dump($info, $problem);
										break;
									}
								}
							}
						} elseif(is_string($key)) {
							$info[$key] = $data[0];
						}
					}

					if((!isset($info['domain']) || $info['domain'] === '') && isset($entity->default_domain)) {
						$info['domain'] = $entity->default_domain;
					}

					// find comment

					if(isset($this->options['pcre.comment_pattern'])) {
						if(preg_match(sprintf($this->options['pcre.comment_pattern'], $this->options['comment_prefix']), substr($entity->content, 0, $match[0][1]), $cmatches)) {
							$info['comment'] = $cmatches['comment'];
						}
					}

					foreach($info as $key => $value) {
						if(!$this->validate($key, $value)) {
							$problem = true;
							// var_dump('problem!');
						}
					}

					$problem = $problem && isset($info['singular_message']) && $info['singular_message'] != '';

					// var_dump('<<<<<<', $info, $problem, '>>>>>>');

					if($problem) {
						$retval[] = new Warning(array(
							'singular_message' => isset($info['singular_message']) ? $info['singular_message'] : null,
							'plural_message' => isset($info['plural_message']) ? $info['plural_message'] : null,
							'line' => $this->findLine($entity->content, $match[0][1]), //(int)$match[0][1], // offset, not line (yet)
							'domain' => isset($info['domain']) ? $info['domain'] : null,
							'comment' => isset($info['comment']) ? $info['comment'] : null,
						));
					} else {
						$retval[] = new Translatable(array(
							'singular_message' => isset($info['singular_message']) ? $info['singular_message'] : null,
							'plural_message' => isset($info['plural_message']) ? $info['plural_message'] : null,
							'line' => $this->findLine($entity->content, $match[0][1]), //(int)$match[0][1], // offset, not line (yet)
							'domain' => isset($info['domain']) ? $info['domain'] : null,
							'comment' => isset($info['comment']) ? $info['comment'] : null,
						));
					}
				}
			}
		}

		$grammatista->dispatchEvent('grammatista.parser.parsed', array('entity' => $entity));

		return $retval;
	}

	/**
	 * Get the line at a offset
	 *
	 * @param      string $content The file content.
	 * @param      int    $offset  The offset.
	 *
	 * @return     string The transformed item.
	 *
	 * @since      0.1.0
	 */
	protected function findLine($content, $offset)
	{
		return preg_match_all('/$/m', substr($content, 0, $offset), $matches);
	}

	/**
	 * Checks if the value is valid for a field.
	 *
	 * @param      string $name The field name.
	 * @param      int $value The field value.
	 *
	 * @return     bool
	 *
	 * @since      0.1.0
	 */
	abstract protected function validate($name, $value);
}

?>