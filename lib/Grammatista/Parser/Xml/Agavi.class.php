<?php

abstract class GrammatistaParserXmlAgavi extends GrammatistaParserXml
{
	const XMLNS_AGAVI_CONFIG = 'http://agavi.org/agavi/1.0/config';
	
	protected function load(GrammatistaEntity $entity)
	{
		parent::load($entity);
		
		$this->xpath->registerNamespace('agavi', self::XMLNS_AGAVI_CONFIG);
	}
	
	public function handles(GrammatistaEntity $entity)
	{
		$handles = parent::handles($entity);
		
		if($handles) {
			$this->load($entity);
			
			$handles = $this->doc->documentElement->namespaceURI == self::XMLNS_AGAVI_CONFIG;
		}
		
		return $handles;
	}
}

?>