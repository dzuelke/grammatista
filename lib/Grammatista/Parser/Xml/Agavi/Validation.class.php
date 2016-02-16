<?php

namespace Grammatista\Parser\Xml\Agavi;

use DOMElement;
use Grammatista\Entity;
use Grammatista\Parser\Xml\Agavi;
use Grammatista\Translatable;
use Grammatista\Warning;

class Validation extends Agavi
{
	const XMLNS_AGAVI_VALIDATION_0_11 = 'http://agavi.org/agavi/1.0/config';
	const XMLNS_AGAVI_VALIDATION_1_0 = 'http://agavi.org/agavi/config/parts/validators/1.0';
	const XMLNS_AGAVI_VALIDATION_1_1 = 'http://agavi.org/agavi/config/parts/validators/1.1';

	/**
	 * {@inheritdoc}
	 */
	protected function load(Entity $entity)
	{
		parent::load($entity);

		$this->xpath->registerNamespace('agavi_validation_0_11', self::XMLNS_AGAVI_VALIDATION_0_11);
		$this->xpath->registerNamespace('agavi_validation_1_0', self::XMLNS_AGAVI_VALIDATION_1_0);
		$this->xpath->registerNamespace('agavi_validation_1_1', self::XMLNS_AGAVI_VALIDATION_1_1);
	}

	/**
	 * {@inheritdoc}
	 */
	public function handles(Entity $entity)
	{
		$handles = parent::handles($entity);

		if($handles) {
			$handles = (bool) $this->xpath->evaluate('count(//agavi_validation_0_11:validator | //agavi_validation_1_0:validator | //agavi_validation_1_1:validator)');
		}

		if($handles) {
			\Grammatista\Grammatista::dispatchEvent('grammatista.parser.handles', array('entity' => $entity));
		}

		return $handles;
	}

	/**
	 * Build the error info for an element.
	 *
	 * @param      DOMElement The errorneous element.
	 *
	 * @return     scalar[] The error info.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	protected function buildErrorInfo(DOMElement $error)
	{
		// tag the element so we can find it later
		$marker = $this->tagElement($error);

		// grab the line of the element
		$line = $this->findLine($marker);

		// next, find comments for this element
		$comment = $this->xpath->evaluate(sprintf('
			normalize-space(
				substring-after(
					normalize-space(
						string(
							preceding-sibling::comment()[starts-with(normalize-space(.), "%1$s")][following-sibling::*[local-name() = "%3$s" and namespace-uri() = "%4$s"][1][@grammatista:tag="%2$s"]][1]
						)
					),
					"%1$s"
				)
			)',
			$this->options['comment_prefix'],
			$marker,
			$error->localName,
			$error->namespaceURI
		), $error);

		// and remove the tag
		$this->untagElement($error);

		// build info
		$info = array(
			'singular_message' => $error->nodeValue,
			'plural_message' => null,
			'line' => $line ? (int)$line : null,
			'comment' => $comment !== "" ? $comment : null,
		);

		return $info;
	}

	/**
	 * {@inheritdoc}
	 */
	public function parse(Entity $entity)
	{
		\Grammatista\Grammatista::dispatchEvent('grammatista.parser.parsing', array('entity' => $entity));

		$retval = array();

		// find all <validator ... translation_domain="..."> elements
		foreach($this->xpath->query('//agavi_validation_0_11:validator[@translation_domain] | //agavi_validation_1_0:validator[@translation_domain] | //agavi_validation_1_1:validator[@translation_domain]') as $validator) {
			// find all <error> elements in the validator block
			foreach($this->xpath->query('agavi_validation_0_11:error | agavi_validation_1_0:error | agavi_validation_1_1:error | agavi_validation_0_11:errors/agavi_validation_0_11:error | agavi_validation_1_0:errors/agavi_validation_1_0:error | agavi_validation_1_1:errors/agavi_validation_1_1:error', $validator) as $error) {
				$info = $this->buildErrorInfo($error);
				$info+= array('domain' => $validator->getAttribute('translation_domain'));

				if($info['singular_message'] != '') {
					$retval[] = new Translatable($info);
				} else {
					$retval[] = new Warning($info);
				}
			}
		}

		// find all <validator> elements without a translation_domain attribute
		foreach($this->xpath->query('//agavi_validation_0_11:validator[not(@translation_domain) and (agavi_validation_0_11:error | agavi_validation_0_11:errors/agavi_validation_0_11:error)] | //agavi_validation_1_0:validator[not(@translation_domain) and (agavi_validation_1_0:error | agavi_validation_1_0:errors/agavi_validation_1_0:error)] | //agavi_validation_1_1:validator[not(@translation_domain) and (agavi_validation_1_1:error | agavi_validation_1_1:errors/agavi_validation_1_1:error)]') as $validator) {
			// find all <error> elements in the validator block
			foreach($this->xpath->query('agavi_validation_0_11:error | agavi_validation_0_11:errors/agavi_validation_0_11:error | agavi_validation_1_0:error | agavi_validation_1_0:errors/agavi_validation_1_0:error | agavi_validation_1_1:error | agavi_validation_1_1:errors/agavi_validation_1_1:error', $validator) as $error) {
				$info = $this->buildErrorInfo($error);
				$info+= array('domain' => null);

				// build error info
				$retval[] = new Warning($info);
			}
		}

		\Grammatista\Grammatista::dispatchEvent('grammatista.parser.parsed', array('entity' => $entity));

		return $retval;
	}
}

?>