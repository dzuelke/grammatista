<?php

namespace Grammatista;

interface IParser
{
	/**
	 * Checks if an entity is handled by this parser.
	 *
	 * @param      Entity $entity The entity.
	 *
	 * @return     bool
	 *
	 * @since      0.1.0
	 */
	public function handles(Entity $entity);

	/**
	 * Parses an entity to a list of translatable items.
	 *
	 * @param      Entity $entity The entity.
	 *
	 * @return     (Translatable|Warning)[]
	 *
	 * @since      0.1.0
	 */
	public function parse(Entity $entity);
}

?>