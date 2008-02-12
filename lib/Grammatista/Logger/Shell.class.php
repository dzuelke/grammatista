<?php

class GrammatistaLoggerShell extends GrammatistaLogger
{
	public function log($name, array $arguments = array())
	{
		echo $name . "\n";
	}
}

?>