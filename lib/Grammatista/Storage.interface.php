<?php

namespace Grammatista;

interface IStorage
{
	/**
	 * Write a translatable item to the store.
	 *
	 * @param      Translatable The translatable item.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function writeTranslatable(Translatable $info);

	/**
	 * Write a warning to the store.
	 *
	 * @param      Warning The warning.
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function writeWarning(Warning $info);

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