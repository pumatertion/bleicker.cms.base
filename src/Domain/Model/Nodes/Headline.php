<?php

namespace Bleicker\Distribution\Domain\Model\Nodes;

use Bleicker\Nodes\AbstractContentNode;

/**
 * Class Headline
 *
 * @package Bleicker\Distribution\Domain\Model\Nodes
 */
class Headline extends AbstractContentNode {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $subtitle;

	/**
	 * @param string $subtitle
	 * @return $this
	 */
	public function setSubtitle($subtitle = NULL) {
		$this->subtitle = $subtitle;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}

	/**
	 * @param string $title
	 * @return $this
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
}
