<?php

namespace Grammatista\Logger;

use Grammatista\Logger;

class Shell extends Logger
{
	public function log($name, array $arguments = array())
	{
		echo $name . "\n";
	}
}

?>