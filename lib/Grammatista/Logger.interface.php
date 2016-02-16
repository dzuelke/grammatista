<?php

namespace Grammatista;

interface ILogger
{
	/**
	 * Log a Message.
	 *
	 * @param      string  The log message.
	 * @param      mixed[] An array of additional information.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function log($name, array $arguments = array());
}

?>