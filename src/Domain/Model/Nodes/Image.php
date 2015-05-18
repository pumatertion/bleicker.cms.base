<?php

namespace Bleicker\Distribution\Domain\Model\Nodes;

use Bleicker\Nodes\AbstractContentNode;

/**
 * Class Image
 *
 * @package Bleicker\Distribution\Domain\Model\Nodes
 */
class Image extends AbstractContentNode {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $alt;

	/**
	 * @var string
	 */
	protected $resource;

	/**
	 * @param string $alt
	 * @return $this
	 */
	public function setAlt($alt = NULL) {
		$this->alt = $alt;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAlt() {
		return $this->alt;
	}

	/**
	 * @param string $title
	 * @return $this
	 */
	public function setTitle($title = NULL) {
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $resource
	 * @return $this
	 */
	public function setResource($resource = NULL) {
		$this->resource = $resource;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getResource() {
		return $this->resource;
	}
}
