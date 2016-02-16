<?php

interface IGrammatistaStorage
{
	public function writeTranslatable(GrammatistaTranslatable $info);

	public function writeWarning(GrammatistaWarning $info);

	public function readTranslatables();

	public function readWarnings();
}

?>