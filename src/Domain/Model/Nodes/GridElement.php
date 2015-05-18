<?php

namespace Bleicker\Distribution\Domain\Model\Nodes;

use Bleicker\Nodes\AbstractContentNode;

/**
 * Class GridElement
 *
 * @package Bleicker\Distribution\Domain\Model\Nodes
 */
class GridElement extends AbstractContentNode implements GridElementInterface {

	/**
	 * @var integer
	 */
	protected $colspan;

	/**
	 * @var integer
	 */
	protected $offset;

	/**
	 * @param int $colspan
	 * @return $this
	 */
	public function setColspan($colspan = NULL) {
		$this->colspan = $colspan;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getColspan() {
		return $this->colspan;
	}

	/**
	 * @param int $offset
	 * @return $this
	 */
	public function setOffset($offset = NULL) {
		$this->offset = $offset;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getOffset() {
		return $this->offset;
	}
}
