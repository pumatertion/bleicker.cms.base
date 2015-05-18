<?php

namespace Bleicker\Distribution\Domain\Model\Nodes;

/**
 * Class Text
 *
 * @package Bleicker\Distribution\Domain\Model\Nodes
 */
interface TextInterface {

	/**
	 * @return string
	 */
	public function getBody();

	/**
	 * @param string $body
	 * @return $this
	 */
	public function setBody($body = NULL);
}