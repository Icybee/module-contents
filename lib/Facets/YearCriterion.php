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

use ICanBoogie\ActiveRecord\Query;
use ICanBoogie\Facets\Criterion\BasicCriterion;

class YearCriterion extends BasicCriterion
{
	public function alter_query_with_value(Query $query, $value)
	{
		// TODO-20140527: support Set and Interval

		return $query->and('YEAR(date) = ?', (int) $value);
	}
}
