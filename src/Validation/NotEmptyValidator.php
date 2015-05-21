<?php

namespace Bleicker\Distribution\Validation;

use Bleicker\Framework\Validation\AbstractValidator;
use Bleicker\Framework\Validation\Error;
use Bleicker\Framework\Validation\Message;
use Bleicker\Framework\Validation\ResultInterface;

/**
 * Class NotEmptyValidator
 *
 * @package Bleicker\Distribution\Validation
 */
class NotEmptyValidator extends AbstractValidator {

	/**
	 * @param mixed $source
	 * @return $this
	 */
	public function validate($source = NULL) {
		if ($source === NULL || trim($source) === '') {
			$message = new Message('This is required.', 1432036801, $source);
			$this->results->add($message);
		}
		return $this;
	}
}
