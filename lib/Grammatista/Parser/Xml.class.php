<?php

abstract class GrammatistaParserXml extends GrammatistaParser
{
	const XMLNS_GRAMMATISTA_PARSER_XML = 'urn:GrammatistaParserXml';
	const XMLNS_SAXON = 'http://icl.com/saxon';
	
	protected $doc;
	protected $xpath;
	
	public function __construct(array $options = array())
	{
		parent::__construct($options);
		
		$xslt = new XSLTProcessor();
		if(!$xslt->hasExsltSupport()) {
			throw new GrammatistaException('EXSLT Support not available');
		}
	}
	
	public function __destruct()
	{
		unset($this->xpath);
		unset($this->doc);
	}
	
	public function handles(GrammatistaEntity $entity)
	{
		return $entity->type == 'xml';
	}
	
	protected function load(GrammatistaEntity $entity)
	{
		$this->doc = new DOMDocument();
		$this->doc->loadXML($entity->content);
		
		$this->xpath = new DOMXPath($this->doc);
		$this->xpath->registerNamespace('grammatista', self::XMLNS_GRAMMATISTA_PARSER_XML);
	}
	
	protected function tagElement(DOMElement $element)
	{
		// generate unique tag to flag the element and set it as an attribute
		// that way we can find it again in XPath and XSL
		$tag = md5(uniqid('', true));
		$element->setAttributeNS(self::XMLNS_GRAMMATISTA_PARSER_XML, 'grammatista:tag', $tag);
		return $tag;
	}
	
	protected function untagElement(DOMElement $element)
	{
		// remove the tag attribute set above
		$element->removeAttributeNS(self::XMLNS_GRAMMATISTA_PARSER_XML, 'grammatista:tag');
	}
	
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