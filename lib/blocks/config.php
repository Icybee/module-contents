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

use Brickrouge\Element;
use Brickrouge\Group;
use Brickrouge\Text;

/**
 * A block to configure contents.
 */
class ConfigBlock extends \Icybee\ConfigBlock
{
	protected function lazy_get_attributes()
	{
		$attributes = parent::lazy_get_attributes();

		$attributes[Element::GROUPS]['limits'] = [ 'title' => 'limits' ];

		return $attributes;
	}

	protected function lazy_get_children()
	{
		$ns = $this->module->flat_id;

		return array_merge(parent::lazy_get_children(), [

			"local[$ns.default_editor]" => new Text([

				Group::LABEL => 'default_editor'
			]),

			"local[$ns.use_multi_editor]" => new Element(Element::TYPE_CHECKBOX, [

				Element::LABEL => 'use_multi_editor'
			]),

			"local[$ns.limits.home]" => new Text([

				Group::LABEL => 'limits_home',
				Element::DEFAULT_VALUE => 3,
				Element::GROUP => 'limits'
			]),

			"local[$ns.limits.list]" => new Text([

				Group::LABEL => 'limits_list',
				Element::DEFAULT_VALUE => 10,
				Element::GROUP => 'limits'
			])
		]);
	}
}