<?php

interface IGrammatistaStorage
{
	/**
	 * Write a translatable item to the store.
	 *
	 * @param      GrammatistaTranslatable The translatable item.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function writeTranslatable(GrammatistaTranslatable $info);

	/**
	 * Write a warning to the store.
	 *
	 * @param      GrammatistaWarning The warning.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function writeWarning(GrammatistaWarning $info);

	/**
	 * Read all translatable items from thestore.
	 *
	 * @return     mixed[][] An array of translatable items encoded as arrays.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function readTranslatables();

	/**
	 * Read all warnings from the store.
	 *
	 * @return     mixed[][] An array of warnings encoded as arrays.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function readWarnings();
}

?>