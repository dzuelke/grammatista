<?php

namespace Grammatista;

interface IParser
{
	/**
	 * Checks if an entity is handled by this parser.
	 *
	 * @param      Entity The entity.
	 *
	 * @return     bool
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function handles(Entity $entity);

	/**
	 * Parses an entity to a list of translatable items.
	 *
	 * @param      Entity The entity.
	 *
	 * @return     (Translatable|Warning)[]
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function parse(Entity $entity);
}

?>