<?php

namespace Bleicker\Distribution\TypeConverter;

use Bleicker\Converter\AbstractTypeConverter;
use Bleicker\Translation\Locale;
use Bleicker\Nodes\Locale as NodeLocale;

/**
 * Class NodeLocaleTypeConverter
 *
 * @package Bleicker\Distribution\TypeConverter
 */
class NodeLocaleTypeConverter extends AbstractTypeConverter {

	/**
	 * @param Locale $source
	 * @param string $targetType
	 * @return boolean
	 */
	public static function canConvert($source = NULL, $targetType) {
		return $source instanceof Locale && $targetType === NodeLocale::class;
	}

	/**
	 * @param Locale $source
	 * @return NodeLocale
	 */
	public function convert($source) {
		return new NodeLocale($source->getLanguage(), $source->getRegion());
	}
}
