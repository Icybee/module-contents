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
 * The class doesn't do a thing but make config events more accurate because one can listen to the
 * configuration of a "contents" type module.
 */
class ConfigOperation extends \Icybee\Modules\Nodes\Operation\ConfigOperation
{
	protected function lazy_get_properties()
	{
		$properties = parent::lazy_get_properties();

		$properties['local'] += [

			"{$this->module->flat_id}.use_multi_editor" => false

		];

		return $properties;
	}
}
