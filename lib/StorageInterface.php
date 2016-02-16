<?php

namespace Grammatista;

interface StorageInterface
{
	/**
	 * Write a translatable item to the store.
	 *
	 * @param      Translatable $info The translatable item.
	 *
	 * @since      0.1.0
	 */
	public function writeTranslatable(Translatable $info);

	/**
	 * Write a warning to the store.
	 *
	 * @param      Warning $info The warning.
	 *
	 * @since      0.1.0
	 */
	public function writeWarning(Warning $info);

	/**
	 * Read all translatable items from thestore.
	 *
	 * @return     mixed[][] An array of translatable items encoded as arrays.
	 *
	 * @since      0.1.0
	 */
	public function readTranslatables();

	/**
	 * Read all warnings from the store.
	 *
	 * @return     mixed[][] An array of warnings encoded as arrays.
	 *
	 * @since      0.1.0
	 */
	public function readWarnings();
}

?>