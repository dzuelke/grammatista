<?php

interface IGrammatistaWriter
{
	/**
	 * Write a translatable item.
	 *
	 * @param      GrammatistaTranslatable The translatable item.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function writeTranslatable(GrammatistaTranslatable $translatable);
}

?>