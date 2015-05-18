<?php

use Bleicker\Nodes\Configuration\NodeConfigurationInterface;
use Bleicker\Nodes\ContentNodeInterface;
use Bleicker\Nodes\PageNodeInterface;
use Bleicker\Distribution\Domain\Model\Nodes\Grid;
use Bleicker\Distribution\Domain\Model\Nodes\GridElement;
use Bleicker\Distribution\Domain\Model\Nodes\GridElementInterface;
use Bleicker\Distribution\Domain\Model\Nodes\Headline;
use Bleicker\Distribution\Domain\Model\Nodes\Image;
use Bleicker\Distribution\Domain\Model\Nodes\Page;
use Bleicker\Distribution\Domain\Model\Nodes\Section;
use Bleicker\Distribution\Domain\Model\Nodes\Site;
use Bleicker\Distribution\Domain\Model\Nodes\Text;

/** Register Sites and allow child types */
Site::register('Website', 'The root page of a domain', NodeConfigurationInterface::SITE_GROUP)
	->allowChild(PageNodeInterface::class)
	->allowChild(ContentNodeInterface::class)
	->forbidChild(GridElementInterface::class);

/** Register Pages */
Page::register('Page', 'A simple page', NodeConfigurationInterface::PAGE_GROUP)
	->allowChild(PageNodeInterface::class)
	->allowChild(ContentNodeInterface::class)
	->forbidChild(GridElementInterface::class);

/** Register Headline */
Headline::register('Headline', 'Title and subtitle', NodeConfigurationInterface::CONTENT_GROUP);

/** Register Text */
Text::register('Text', 'Just text', NodeConfigurationInterface::CONTENT_GROUP);

/** Register Image */
Image::register('Image', 'A simple image', NodeConfigurationInterface::CONTENT_GROUP);

/** Register Grid */
Grid::register('Grid', 'Grid wich can contain grid-elements', NodeConfigurationInterface::CONTENT_GROUP)
	->allowChild(GridElementInterface::class);

/** Register Gridelement */
GridElement::register('Grid-Element', 'A Grid-Element', NodeConfigurationInterface::CONTENT_GROUP)
	->allowChild(ContentNodeInterface::class)
	->forbidChild(GridElementInterface::class);

Section::register('Section', 'A section element', NodeConfigurationInterface::CONTENT_GROUP)
	->allowChild(ContentNodeInterface::class)->forbidChild(Section::class)->forbidChild(GridElement::class);
