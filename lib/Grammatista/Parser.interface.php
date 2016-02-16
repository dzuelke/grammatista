<?php

interface IGrammatistaParser
{
	public function handles(GrammatistaEntity $entity);

	public function parse(GrammatistaEntity $entity);
}

?>