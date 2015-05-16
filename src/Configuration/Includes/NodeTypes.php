<?php

use Bleicker\Nodes\Configuration\NodeConfigurationInterface;
use Bleicker\Nodes\ContentNodeInterface;
use Bleicker\Nodes\PageNodeInterface;
use Bleicker\NodeTypes\Grid;
use Bleicker\NodeTypes\GridElement;
use Bleicker\NodeTypes\GridElementInterface;
use Bleicker\NodeTypes\Headline;
use Bleicker\NodeTypes\Image;
use Bleicker\NodeTypes\Page;
use Bleicker\NodeTypes\Section;
use Bleicker\NodeTypes\Site;
use Bleicker\NodeTypes\Text;

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
