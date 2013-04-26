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

/**
 * Saves a content.
 */
class SaveOperation extends \Icybee\Modules\Nodes\SaveOperation
{
	/**
	 * Serialize the `body` property using its editor.
	 */
	protected function get_properties()
	{
		global $core;

		$properties = parent::get_properties();

		if (isset($properties['body']) && isset($properties['editor']))
		{
			$editor = $core->editors[$properties['editor']];

			$properties['body'] = $editor->serialize($properties['body']);
		}

		return $properties;
	}
}