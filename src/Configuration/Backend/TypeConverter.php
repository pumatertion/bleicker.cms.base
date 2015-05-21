<?php

use Bleicker\Cms\TypeConverter\NodeLocaleTypeConverter;
use Bleicker\Converter\TypeConverter\FloatTypeConverter;
use Bleicker\Converter\TypeConverter\IntegerTypeConverter;
use Bleicker\Converter\TypeConverter\StringTypeConverter;
use Bleicker\Distribution\TypeConverter\Node\GridElementTypeConverter;
use Bleicker\Distribution\TypeConverter\Node\GridTypeConverter;
use Bleicker\Distribution\TypeConverter\Node\HeadlineTypeConverter;
use Bleicker\Distribution\TypeConverter\Node\ImageTypeConverter;
use Bleicker\Distribution\TypeConverter\Node\PageTypeConverter;
use Bleicker\Distribution\TypeConverter\Node\SectionTypeConverter;
use Bleicker\Distribution\TypeConverter\Node\SiteTypeConverter;
use Bleicker\Distribution\TypeConverter\Node\TextTypeConverter;

ImageTypeConverter::register();
IntegerTypeConverter::register();
FloatTypeConverter::register();
StringTypeConverter::register();
SiteTypeConverter::register();
PageTypeConverter::register();
HeadlineTypeConverter::register();
TextTypeConverter::register();
GridTypeConverter::register();
GridElementTypeConverter::register();
NodeLocaleTypeConverter::register();
SectionTypeConverter::register();
