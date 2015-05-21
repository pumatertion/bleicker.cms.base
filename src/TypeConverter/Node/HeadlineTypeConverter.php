<?php

namespace Bleicker\Distribution\TypeConverter\Node;

use Bleicker\Cms\Validation\NotEmptyValidator;
use Bleicker\Converter\AbstractTypeConverter;
use Bleicker\Distribution\Domain\Model\Nodes\Headline;
use Bleicker\Framework\Utility\Arrays;
use Bleicker\Framework\Validation\ArrayValidator;
use Bleicker\Framework\Validation\Exception\ValidationException;
use Bleicker\Nodes\Locale;
use Bleicker\Nodes\NodeService;
use Bleicker\Nodes\NodeServiceInterface;
use Bleicker\Nodes\NodeTranslation;
use Bleicker\ObjectManager\ObjectManager;

/**
 * Class HeadlineTypeConverter
 *
 * @package Bleicker\Distribution\TypeConverter\Node
 */
class HeadlineTypeConverter extends AbstractTypeConverter {

	/**
	 * @var NodeServiceInterface
	 */
	protected $nodeService;

	public function __construct() {
		parent::__construct();
		$this->nodeService = ObjectManager::get(NodeServiceInterface::class, NodeService::class);
	}

	/**
	 * @param array $source
	 * @param string $targetType
	 * @return boolean
	 */
	public static function canConvert($source = NULL, $targetType) {
		if (is_array($source) && $targetType === Headline::class) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param array $source
	 * @return Headline
	 */
	public function convert($source) {
		if ($this->isUpdate($source)) {
			return $this->validate($source)->getUpdated($source);
		}
		return $this->getNew($source);
	}

	/**
	 * @param array $source
	 * @throws ValidationException
	 * @return $this
	 */
	protected function validate(array $source = []) {
		$notEmptyValidator = new NotEmptyValidator();
		$validationResults = ArrayValidator::create()->addValidatorForPropertyPath('title', $notEmptyValidator)->validate($source)->getResults();
		if ($validationResults->count() > 0) {
			throw ValidationException::create($validationResults, 'Validation failed', 1432156045);
		}
		return $this;
	}

	/**
	 * Returns true if value of path "className.id" not null
	 *
	 * @param array $source
	 * @return boolean
	 */
	protected function isUpdate(array $source) {
		return $this->getIdFromSource($source) !== NULL;
	}

	/**
	 * @param array $source
	 * @return mixed
	 */
	protected function getIdFromSource(array $source) {
		return Arrays::getValueByPath($source, $this->getIdPath());
	}

	/**
	 * @return string
	 */
	protected function getIdPath() {
		return 'id';
	}

	/**
	 * Returns a new site mapped with source arguments
	 *
	 * @param array $source
	 * @return Headline
	 */
	protected function getNew(array $source) {
		$node = new Headline();
		$node->setTitle(Arrays::getValueByPath($source, 'title') !== NULL ? : '');
		$node->setSubtitle(Arrays::getValueByPath($source, 'subtitle'));
		$node->setHidden(TRUE);
		return $node;
	}

	/**
	 * Returns an updated site mapped with source arguments
	 *
	 * @param array $source
	 * @return Headline
	 */
	protected function getUpdated(array $source) {
		if ($this->isLocalizationMode()) {
			return $this->getLocalized($source);
		}
		$nodeId = Arrays::getValueByPath($source, $this->getIdPath());
		Arrays::unsetValueByPath($source, $this->getIdPath());
		/** @var Headline $node */
		$node = $this->nodeService->get($nodeId);
		$node->setTitle(Arrays::getValueByPath($source, 'title'));
		$node->setSubtitle(Arrays::getValueByPath($source, 'subtitle'));
		$node->setHidden((boolean)Arrays::getValueByPath($source, 'hidden'));
		return $node;
	}

	/**
	 * @param array $source
	 * @return Headline
	 */
	protected function getLocalized(array $source) {
		$nodeId = Arrays::getValueByPath($source, $this->getIdPath());
		Arrays::unsetValueByPath($source, $this->getIdPath());
		/** @var Headline $node */
		$node = $this->nodeService->get($nodeId);
		$titleTranslation = new NodeTranslation('title', $this->getNodeLocale(), Arrays::getValueByPath($source, 'title'));
		$this->nodeService->addTranslation($node, $titleTranslation->setNode($node));
		$subtitleTranslation = new NodeTranslation('subtitle', $this->getNodeLocale(), Arrays::getValueByPath($source, 'subtitle'));
		$this->nodeService->addTranslation($node, $subtitleTranslation->setNode($node));
		return $node;
	}

	/**
	 * @return Locale
	 */
	protected function getNodeLocale() {
		return $this->converter->convert($this->locales->getSystemLocale(), Locale::class);
	}
}
