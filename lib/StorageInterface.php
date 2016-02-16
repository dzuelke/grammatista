<?php

namespace Grammatista;

interface StorageInterface
{
	/**
	 * Write a translatable item to the store.
	 *
	 * @param      Grammatista  $grammatista The grammatista instance.
	 * @param      Translatable $info        The translatable item.
	 *
	 * @since      0.1.0
	 */
	public function writeTranslatable(Grammatista $grammatista, Translatable $info);

	/**
	 * Write a warning to the store.
	 *
	 * @param      Grammatista $grammatista The grammatista instance.
	 * @param      Warning     $info        The warning.
	 *
	 * @since      0.1.0
	 */
	public function writeWarning(Grammatista $grammatista, Warning $info);

	/**
	 * Read all translatable items from thestore.
	 *
	 * @param      Grammatista $grammatista The grammatista instance.
	 *
	 * @return     mixed[][] An array of translatable items encoded as arrays.
	 *
	 * @since      0.1.0
	 */
	public function readTranslatables(Grammatista $grammatista);

	/**
	 * Read all warnings from the store.
	 *
	 * @param      Grammatista $grammatista The grammatista instance.
	 *
	 * @return     mixed[][] An array of warnings encoded as arrays.
	 *
	 * @since      0.1.0
	 */
	public function readWarnings(Grammatista $grammatista);
}

?>