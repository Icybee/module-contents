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

class Model extends \Icybee\Modules\Nodes\Model
{
	protected function get_criteria()
	{
		return parent::get_criteria() + [

			'date' =>  __NAMESPACE__ . '\DateCriterion',
			'day' =>   __NAMESPACE__ . '\DayCriterion',
			'month' => __NAMESPACE__ . '\MonthCriterion',
			'year' =>  __NAMESPACE__ . '\YearCriterion'

		];
	}
}