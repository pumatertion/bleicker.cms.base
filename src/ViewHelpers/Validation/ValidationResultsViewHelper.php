<?php

namespace Bleicker\Distribution\ViewHelpers\Validation;

use Bleicker\Framework\Validation\ResultInterface;
use Bleicker\Framework\Validation\ResultsInterface;
use Bleicker\ObjectManager\ObjectManager;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class ValidationResultsViewHelper
 *
 * @package Bleicker\Distribution\ViewHelpers\Validation
 */
class ValidationResultsViewHelper extends AbstractViewHelper {

	/**
	 * @var boolean
	 */
	protected $escapeChildren = FALSE;

	/**
	 * @var boolean
	 */
	protected $escapeOutput = FALSE;

	/**
	 * @var ResultsInterface
	 */
	protected $validationResults;

	public function __construct() {
		$this->validationResults = ObjectManager::get(ResultsInterface::class);
	}

	/**
	 * Initialize the arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerArgument('as', 'string', 'Variablename of assigned results', TRUE, 'validationResults');
		$this->registerArgument('propertyPath', 'string', 'Show only validation results matching this property path', TRUE, NULL);
	}

	/**
	 * @return ResultInterface[]
	 */
	public function render() {
		/** @var string $as */
		$as = $this->arguments['as'];

		$this->templateVariableContainer->add($as, $this->getValidationResults());
		$result = $this->renderChildren();
		$this->templateVariableContainer->remove($as);

		return $result;
	}

	/**
	 * @return ResultInterface[]
	 */
	protected function getValidationResults() {
		$propertyPath = $this->arguments['propertyPath'];
		$allValidationResults = $this->validationResults->storage();
		if ($propertyPath !== NULL) {
			$matchingValidationResults = [];
			foreach ($allValidationResults as $result) {
				if ((boolean)stristr($result->getPropertyPath(), $propertyPath)) {
					$matchingValidationResults[] = $result;
				}
			}
			return $matchingValidationResults;
		}
		return $allValidationResults;
	}
}
