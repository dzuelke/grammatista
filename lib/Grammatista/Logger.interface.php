<?php

namespace Grammatista;

interface ILogger
{
	/**
	 * Log a Message.
	 *
	 * @param      string  $name      The log message.
	 * @param      mixed[] $arguments An array of additional information.
	 *
	 * @since      0.1.0
	 */
	public function log($name, array $arguments = array());
}

?>