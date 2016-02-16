<?php

namespace Grammatista;

interface WriterInterface
{
	/**
	 * Write a translatable item.
	 *
	 * @param      Translatable $translatable The translatable item.
	 *
	 * @since      0.1.0
	 */
	public function writeTranslatable(Translatable $translatable);
}

?>