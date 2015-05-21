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
	protected $figure;

	/**
	 * @var string
	 */
	protected $caption;

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
	 * @param string $figure
	 * @return $this
	 */
	public function setFigure($figure = NULL) {
		$this->figure = $figure;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFigure() {
		return $this->figure;
	}

	/**
	 * @param string $caption
	 * @return $this
	 */
	public function setCaption($caption = NULL) {
		$this->caption = $caption;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCaption() {
		return $this->caption;
	}
}
