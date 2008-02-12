<?php

class GrammatistaParserXmlAgaviValidation extends GrammatistaParserXmlAgavi
{
	public function handles(GrammatistaEntity $entity)
	{
		$handles = parent::handles($entity);
		
		if($handles) {
			$handles = $this->xpath->query('//agavi:validator')->length > 0;
		}
		
		if($handles) {
			Grammatista::dispatchEvent('grammatista.parser.handles', array('entity' => $entity));
		}
		
		return $handles;
	}
	
	protected function buildErrorInfo(DOMElement $error)
	{
		// tag the element so we can find it later
		$tag = $this->tagElement($error);
		
		// grab the line of the element
		$line = $this->findLine($tag, 'agavi:error', array('agavi' => self::XMLNS_AGAVI_CONFIG));
		
		// next, find comments for this element
		$comment = $this->xpath->evaluate(sprintf('normalize-space(substring-after(normalize-space(string(preceding-sibling::comment()[starts-with(normalize-space(.), "%1$s")][following-sibling::agavi:error[1][@grammatista:tag="%2$s"]][1])), "%1$s"))', $this->options['comment_prefix'], $tag), $error);
		
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
	
	public function parse(GrammatistaEntity $entity)
	{
		Grammatista::dispatchEvent('grammatista.parser.parsing', array('entity' => $entity));
		
		$retval = array();
		
		// find all <validator ... translation_domain="..."> elements
		foreach($this->xpath->query('//agavi:validator[@translation_domain]') as $validator) {
			// find all <error> elements in the validator block
			foreach($this->xpath->query('descendant::agavi:error', $validator) as $error) {
				$info = $this->buildErrorInfo($error);
				$info+= array('domain' => $validator->getAttribute('translation_domain'));
				
				if($info['singular_message'] != '') {
					$retval[] = new GrammatistaTranslatable($info);
				} else {
					$retval[] = new GrammatistaWarning($info);
				}
			}
		}
		
		// find all <validator> elements without a translation_domain attribute
		foreach($this->xpath->query('//agavi:validator[not(@translation_domain) and descendant::agavi:error]') as $validator) {
			// find all <error> elements in the validator block
			foreach($this->xpath->query('descendant::agavi:error', $validator) as $error) {
				$info = $this->buildErrorInfo($error);
				$info+= array('domain' => null);
				
				// build error info
				$retval[] = new GrammatistaWarning($info);
			}
		}
		
		Grammatista::dispatchEvent('grammatista.parser.parsed', array('entity' => $entity));
		
		return $retval;
	}
}

?>