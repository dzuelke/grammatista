<?php

interface IGrammatistaParser
{
	/**
	 * Checks if an entity is handled by this parser.
	 *
	 * @param      GrammatistaEntity The entity.
	 *
	 * @return     bool
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function handles(GrammatistaEntity $entity);

	/**
	 * Parses an entity to a list of translatable items.
	 *
	 * @param      GrammatistaEntity The entity.
	 *
	 * @return     (GrammatistaTranslatable|GrammatistaWarning)[]
	 *
	 * @author     David Zülke <david.zuelke@bitextender.com>
	 * @since      0.1.0
	 */
	public function parse(GrammatistaEntity $entity);
}

?>