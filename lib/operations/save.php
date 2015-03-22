<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Contents;

use ICanBoogie\DateTime;

/**
 * Saves a content.
 */
class SaveOperation extends \Icybee\Modules\Nodes\SaveOperation
{
	/**
	 * Serialize the `body` property using its editor.
	 */
	protected function lazy_get_properties()
	{
		$properties = parent::lazy_get_properties();

		if (isset($properties['body']) && isset($properties['editor']))
		{
			/* @var $editor \Icybee\Modules\Editor\Editor */

			$editor = $this->app->editors[$properties['editor']];

			$properties['body'] = $editor->serialize($properties['body']);
		}

		if (array_key_exists('date', $properties))
		{
			$properties['date'] = DateTime::from($properties['date']);
		}

		return $properties;
	}
}
