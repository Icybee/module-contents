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

class Module extends \Icybee\Modules\Nodes\Module
{
	const OPERATION_HOME_INCLUDE = 'home_include';
	const OPERATION_HOME_EXCLUDE = 'home_exclude';

	/**
	 * Overrides the "view", "list" and "home" views to provide different providers.
	 */
	protected function lazy_get_views()
	{
		$options = [

			'assets' => [

				'css' => [ DIR . 'public/page.css' ]
			],

			'provider' => __NAMESPACE__ . '\ViewProvider'
		];

		return \ICanBoogie\array_merge_recursive(parent::lazy_get_views(), [

			'view' => $options,
			'list' => $options,
			'home' => $options

		]);
	}
}