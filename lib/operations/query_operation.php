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

class QueryOperationOperation extends \Icybee\Modules\Nodes\QueryOperationOperation
{
	protected function query_home_include()
	{
		return [

			'params' => [

				'keys' => $this->request['keys']

			]

		];
	}

	protected function query_home_exclude()
	{
		return [

			'params' => [

				'keys' => $this->request['keys']

			]

		];
	}
}