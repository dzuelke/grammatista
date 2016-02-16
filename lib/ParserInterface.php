<?php

namespace Grammatista;

interface ParserInterface
{
	/**
	 * Checks if an entity is handled by this parser.
	 *
	 * @param      Grammatista $grammatista The grammatista instance.
	 * @param      Entity      $entity      The entity.
	 *
	 * @return     bool
	 *
	 * @since      0.1.0
	 */
	public function handles(Grammatista $grammatista, Entity $entity);

	/**
	 * Parses an entity to a list of translatable items.
	 *
	 * @param      Grammatista $grammatista The grammatista instance.
	 * @param      Entity      $entity      The entity.
	 *
	 * @return     (Translatable|Warning)[]
	 *
	 * @since      0.1.0
	 */
	public function parse(Grammatista $grammatista, Entity $entity);
}

?>