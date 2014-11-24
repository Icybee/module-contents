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

use ICanBoogie\ActiveRecord\Query;
use ICanBoogie\ActiveRecord\Criterion;

class InHomeCriterion extends Criterion
{
	public function alter_query_with_value(Query $query, $value)
	{
		return $query->filter_by_is_home_excluded(!$value);
	}
}
