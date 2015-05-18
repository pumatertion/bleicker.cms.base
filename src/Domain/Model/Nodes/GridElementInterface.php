<?php

namespace Bleicker\Distribution\Domain\Model\Nodes;

/**
 * Class GridElement
 *
 * @package Bleicker\Distribution\Domain\Model\Nodes
 */
interface GridElementInterface {

	/**
	 * @return int
	 */
	public function getOffset();

	/**
	 * @param int $colspan
	 * @return $this
	 */
	public function setColspan($colspan = NULL);

	/**
	 * @return int
	 */
	public function getColspan();

	/**
	 * @param int $offset
	 * @return $this
	 */
	public function setOffset($offset = NULL);
}