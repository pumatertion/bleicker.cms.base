<?php

namespace Bleicker\Distribution\TypeConverter\Node;

use Bleicker\Converter\AbstractTypeConverter;
use Bleicker\Distribution\Validation\NotEmptyValidator;
use Bleicker\Framework\Utility\Arrays;
use Bleicker\Framework\Validation\ErrorInterface;
use Bleicker\Framework\Validation\Exception\ValidationException;
use Bleicker\Framework\Validation\ResultsInterface;
use Bleicker\Nodes\Locale;
use Bleicker\Nodes\NodeService;
use Bleicker\Nodes\NodeServiceInterface;
use Bleicker\Nodes\NodeTranslation;
use Bleicker\Distribution\Domain\Model\Nodes\Site;
use Bleicker\ObjectManager\ObjectManager;

/**
 * Class SiteTypeConverter
 *
 * @package Bleicker\Distribution\TypeConverter\Node
 */
class SiteTypeConverter extends AbstractTypeConverter {

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
		if (is_array($source) && $targetType === Site::class) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param array $source
	 * @return Site
	 */
	public function convert($source) {
		if ($this->isUpdate($source)) {
			return $this->getUpdated($source);
		}
		return $this->getNew($source);
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
	 * @return Site
	 */
	protected function getNew(array $source) {
		$node = new Site();
		$node->setTitle(Arrays::getValueByPath($source, 'title') === NULL ? '' : Arrays::getValueByPath($source, 'title'));
		return $node;
	}

	/**
	 * Returns an updated site mapped with source arguments
	 *
	 * @param array $source
	 * @throws ValidationException
	 * @return Site
	 */
	protected function getUpdated(array $source) {
		if ($this->isLocalizationMode()) {
			return $this->getLocalized($source);
		}

		$nodeId = Arrays::getValueByPath($source, $this->getIdPath());
		Arrays::unsetValueByPath($source, $this->getIdPath());

		/** @var Site $node */
		$node = $this->nodeService->get($nodeId);

		$node->setTitle(Arrays::getValueByPath($source, 'title') === NULL ? '' : Arrays::getValueByPath($source, 'title'));
		$node->setHidden((boolean)Arrays::getValueByPath($source, 'hidden'));

		/** @var ResultsInterface $validationResults */
		$validationResults = ObjectManager::get(ResultsInterface::class);
		$notNullValidationResult = NotEmptyValidator::create()->validate($node->getTitle());
		if($notNullValidationResult instanceof ErrorInterface){
			$validationResults->add('title', $node->getTitle(), $notNullValidationResult);
		}

		if(count($validationResults->storage())){
			throw ValidationException::create('Your data is invalid', 1431981824);
		}

		return $node;
	}

	/**
	 * @param array $source
	 * @return Site
	 */
	protected function getLocalized(array $source) {
		$nodeId = Arrays::getValueByPath($source, $this->getIdPath());
		Arrays::unsetValueByPath($source, $this->getIdPath());

		/** @var Site $node */
		$node = $this->nodeService->get($nodeId);

		$titleTranslation = new NodeTranslation('title', $this->getNodeLocale(), Arrays::getValueByPath($source, 'title'));
		$this->nodeService->addTranslation($node, $titleTranslation->setNode($node));

		return $node;
	}

	/**
	 * @return Locale
	 */
	protected function getNodeLocale() {
		return $this->converter->convert($this->locales->getSystemLocale(), Locale::class);
	}
}
