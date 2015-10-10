<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Contents\Facets;

use ICanBoogie\Facets\BooleanCriterion;
use ICanBoogie\Facets\QueryString;

class IsHomeExcludedCriterion extends BooleanCriterion
{
	protected $query_string_mapping = [

		'is:home-included' => false,
		'is:home-excluded' => true,
		'in:home' => false,
		'out:home' => true

	];

	public function parse_query_string(QueryString $q)
	{
		foreach ($q->not_matched as $word)
		{
			$w = (string) $word;

			if (isset($this->query_string_mapping[$w]))
			{
				$word->match = [ $this->id => $this->query_string_mapping[$w] ];
			}
		}
	}
}
