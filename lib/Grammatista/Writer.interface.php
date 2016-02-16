<?php

namespace Grammatista;

interface IWriter
{
	/**
	 * Write a translatable item.
	 *
	 * @param      Translatable $translatable The translatable item.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function writeTranslatable(Translatable $translatable);
}

?>