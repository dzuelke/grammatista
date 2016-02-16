<?php

namespace Grammatista\Parser;

use DOMDocument;
use DOMElement;
use DOMXPath;
use XSLTProcessor;
use Grammatista\Exception;
use Grammatista\Entity;
use Grammatista\Parser;

abstract class Xml extends Parser
{
	const XMLNS_GRAMMATISTA_PARSER_XML = 'urn:GrammatistaParserXml';
	const XMLNS_SAXON = 'http://icl.com/saxon';

	/**
	 * @var        DOMDocument The parsed document.
	 */
	protected $doc;

	/**
	 * @var        DOMXPath The xpath instance.
	 */
	protected $xpath;

	/**
	 * Constructor. Accepts an array of options.
	 *
	 * @param      mixed[] $options The options.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function __construct(array $options = array())
	{
		parent::__construct($options);

		$xslt = new XSLTProcessor();
		if(!$xslt->hasExsltSupport()) {
			throw new Exception('EXSLT Support not available');
		}
	}

	/**
	 * Destructor. Closes all open resources.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function __destruct()
	{
		unset($this->xpath);
		unset($this->doc);
	}

	/**
	 * {@inheritdoc}
	 */
	public function handles(Entity $entity)
	{
		return $entity->type == 'xml';
	}

	/**
	 * Load an entity.
	 *
	 * @param      Entity $entity The entity.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	protected function load(Entity $entity)
	{
		$this->doc = new DOMDocument();
		$this->doc->loadXML($entity->content);

		$this->xpath = new DOMXPath($this->doc);
		$this->xpath->registerNamespace('grammatista', self::XMLNS_GRAMMATISTA_PARSER_XML);
	}

	/**
	 * Tag an element of the document with an unique identifier, which is then returned.
	 *
	 * @param      DOMElement $element The element.
	 *
	 * @return     string The unique identifier.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	protected function tagElement(DOMElement $element)
	{
		// generate unique tag to flag the element and set it as an attribute
		// that way we can find it again in XPath and XSL
		$tag = md5(uniqid('', true));
		$element->setAttributeNS(self::XMLNS_GRAMMATISTA_PARSER_XML, 'grammatista:tag', $tag);
		return $tag;
	}

	/**
	 * Remove the unique identifier from an element.
	 *
	 * @param      DOMElement $element The element.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	protected function untagElement(DOMElement $element)
	{
		// remove the tag attribute set above
		$element->removeAttributeNS(self::XMLNS_GRAMMATISTA_PARSER_XML, 'grammatista:tag');
	}

	/**
	 * Find the line of a tagged element.
	 *
	 * @param      string $marker The unique identifier.
	 *
	 * @return     int The line.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	protected function findLine($marker)
	{
		// stylesheet to find that tagged element
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml.= sprintf('<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:grammatista="%1$s" xmlns:saxon="%2$s">', self::XMLNS_GRAMMATISTA_PARSER_XML, self::XMLNS_SAXON);
		$xml.= '<xsl:strip-space elements="*" />';
		$xml.= '<xsl:output method="text" encoding="utf-8" indent="yes" />';
		$xml.= sprintf('<xsl:template match="*[@grammatista:tag=\'%s\']"><xsl:value-of select="saxon:line-number(.)" /></xsl:template>', $marker);
		$xml.= '<xsl:template match="text()|@*" />';
		$xml.= '</xsl:stylesheet>';

		$xsl = new DOMDocument();
		$xsl->loadXML($xml);

		$xslt = new XSLTProcessor();
		$xslt->importStylesheet($xsl);

		// grab the line number by running the stylesheet
		$line = trim($xslt->transformToXML($this->doc));

		// cleanup
		unset($xslt);
		unset($xsl);

		return $line;
	}
}

?>