<?php

namespace Bleicker\Distribution\Validation;

use Bleicker\Framework\Validation\AbstractValidator;
use Bleicker\Framework\Validation\Error;
use Bleicker\Framework\Validation\ResultInterface;

/**
 * Class NotEmptyValidator
 *
 * @package Bleicker\Distribution\Validation
 */
class NotEmptyValidator extends AbstractValidator {

	/**
	 * @param mixed $source
	 * @return ResultInterface
	 */
	public function validate($source = NULL) {
		if ($source === NULL) {
			return Error::create('Validation Error (%1s): NULL is not allowed for property "%2s".', 1432036800);
		}
		if (empty($source)) {
			return Error::create('Validation Error (%1s): Property "%2s" is empty.', 1432036801);
		}
	}
}
