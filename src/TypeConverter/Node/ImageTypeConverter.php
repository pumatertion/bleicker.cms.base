<?php

namespace Bleicker\Distribution\TypeConverter\Node;

use Bleicker\Cms\Validation\NotEmptyValidator;
use Bleicker\Converter\AbstractTypeConverter;
use Bleicker\Distribution\Domain\Model\Nodes\Image;
use Bleicker\Framework\Utility\Arrays;
use Bleicker\Framework\Validation\ArrayValidator;
use Bleicker\Framework\Validation\Exception\ValidationException;
use Bleicker\Nodes\Locale;
use Bleicker\Nodes\NodeService;
use Bleicker\Nodes\NodeServiceInterface;
use Bleicker\Nodes\NodeTranslation;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Registry\Registry;
use Bleicker\Translation\Translation;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImageTypeConverter
 *
 * @package Bleicker\Distribution\TypeConverter\Node
 */
class ImageTypeConverter extends AbstractTypeConverter {

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
		if (is_array($source) && $targetType === Image::class) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param array $source
	 * @return Image
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
		$titleNotEmptyValidator = new NotEmptyValidator();
		$altNotEmptyValidator = new NotEmptyValidator();
		$validationResults = ArrayValidator::create()
			->addValidatorForPropertyPath('title', $titleNotEmptyValidator)
			->addValidatorForPropertyPath('alt', $altNotEmptyValidator)
			->validate($source)
			->getResults();
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
	 * @return Image
	 */
	protected function getNew(array $source) {
		$node = new Image();
		$node->setTitle(Arrays::getValueByPath($source, 'title') !== NULL ? : '');
		$node->setAlt(Arrays::getValueByPath($source, 'alt') !== NULL ? : '');
		$node->setCaption(Arrays::getValueByPath($source, 'caption') !== NULL ? : '');
		$node->setHidden(TRUE);
		return $node;
	}

	/**
	 * Returns an updated site mapped with source arguments
	 *
	 * @param array $source
	 * @return Image
	 */
	protected function getUpdated(array $source) {
		if ($this->isLocalizationMode()) {
			return $this->getLocalized($source);
		}

		$nodeId = Arrays::getValueByPath($source, $this->getIdPath());
		Arrays::unsetValueByPath($source, $this->getIdPath());

		/** @var Image $node */
		$node = $this->nodeService->get($nodeId);

		$node->setTitle(Arrays::getValueByPath($source, 'title'));
		$node->setAlt(Arrays::getValueByPath($source, 'alt'));
		$node->setCaption(Arrays::getValueByPath($source, 'caption'));
		$node->setHidden((boolean)Arrays::getValueByPath($source, 'hidden'));

		$figure = Arrays::getValueByPath($source, 'figure');
		if ($figure instanceof UploadedFile) {
			$this->remove($node->getFigure());
			$fileName = $this->move($figure);
			$node->setFigure($fileName);
		}

		return $node;
	}

	/**
	 * @param array $source
	 * @return Image
	 */
	protected function getLocalized(array $source) {
		$nodeId = Arrays::getValueByPath($source, $this->getIdPath());
		Arrays::unsetValueByPath($source, $this->getIdPath());

		/** @var Image $node */
		$node = $this->nodeService->get($nodeId);

		$titleTranslation = new NodeTranslation('title', $this->getNodeLocale(), Arrays::getValueByPath($source, 'title'));
		$this->nodeService->addTranslation($node, $titleTranslation->setNode($node));

		$altTranslation = new NodeTranslation('alt', $this->getNodeLocale(), Arrays::getValueByPath($source, 'alt'));
		$this->nodeService->addTranslation($node, $altTranslation->setNode($node));

		$captionTranslation = new NodeTranslation('caption', $this->getNodeLocale(), Arrays::getValueByPath($source, 'caption'));
		$this->nodeService->addTranslation($node, $captionTranslation->setNode($node));

		$figure = Arrays::getValueByPath($source, 'figure');
		if ($figure instanceof UploadedFile) {
			$translation = new Translation('figure', $this->locales->getSystemLocale());
			if ($node->hasTranslation($translation)) {
				$this->remove($node->getTranslation($translation)->getValue());
			}
			$fileName = $this->move($figure);
			$figureTranslation = new NodeTranslation('figure', $this->getNodeLocale(), $fileName);
			$this->nodeService->addTranslation($node, $figureTranslation->setNode($node));
		}

		return $node;
	}

	/**
	 * @return Locale
	 */
	protected function getNodeLocale() {
		return $this->converter->convert($this->locales->getSystemLocale(), Locale::class);
	}

	/**
	 * @param string $figure
	 * @return boolean
	 */
	protected function remove($figure = NULL) {
		if ($figure !== NULL || !empty($figure)) {
			$directory = realpath(Registry::get('paths.uploads.default'));
			$figurePath = $directory . '/' . $figure;
			if (file_exists($figurePath)) {
				return unlink($figurePath);
			}
		}
		return FALSE;
	}

	/**
	 * @param UploadedFile $figure
	 * @return string The name of the file after upload
	 */
	protected function move(UploadedFile $figure) {
		$directory = realpath(Registry::get('paths.uploads.default'));
		$movedFile = $figure->move($directory, $figure->getClientOriginalName() . uniqid('_', TRUE) . '.' . $figure->guessExtension());
		return $movedFile->getFilename();
	}
}
