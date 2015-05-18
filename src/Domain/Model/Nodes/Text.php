<?php

namespace Bleicker\Distribution\Domain\Model\Nodes;

use Bleicker\Nodes\AbstractContentNode;

/**
 * Class Text
 *
 * @package Bleicker\Distribution\Domain\Model\Nodes
 */
class Text extends AbstractContentNode implements TextInterface {

	/**
	 * @var string
	 */
	protected $body;

	/**
	 * @param string $body
	 * @return $this
	 */
	public function setBody($body = NULL) {
		$this->body = $body;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBody() {
		return $this->body;
	}
}
