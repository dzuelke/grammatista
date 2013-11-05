<?php

abstract class GrammatistaParserXmlAgavi extends GrammatistaParserXml
{
	const XMLNS_AGAVI_ENVELOPE_0_11 = 'http://agavi.org/agavi/1.0/config';
	const XMLNS_AGAVI_ENVELOPE_1_0 = 'http://agavi.org/agavi/config/global/envelope/1.0';
	const XMLNS_AGAVI_ENVELOPE_1_1 = 'http://agavi.org/agavi/config/global/envelope/1.1';
	
	static $envelopeNamespaces = array(
		self::XMLNS_AGAVI_ENVELOPE_0_11,
		self::XMLNS_AGAVI_ENVELOPE_1_0,
		self::XMLNS_AGAVI_ENVELOPE_1_1,
	);
	
	protected function load(GrammatistaEntity $entity)
	{
		parent::load($entity);
		
		$this->xpath->registerNamespace('agavi_envelope_0_11', self::XMLNS_AGAVI_ENVELOPE_0_11);
		$this->xpath->registerNamespace('agavi_envelope_1_0', self::XMLNS_AGAVI_ENVELOPE_1_0);
		$this->xpath->registerNamespace('agavi_envelope_1_1', self::XMLNS_AGAVI_ENVELOPE_1_1);
	}
	
	public function handles(GrammatistaEntity $entity)
	{
		$handles = parent::handles($entity);
		
		if($handles) {
			$this->load($entity);
			
			$handles = in_array($this->doc->documentElement->namespaceURI, self::$envelopeNamespaces);
		}
		
		return $handles;
	}
}

?>