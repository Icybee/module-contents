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

use ICanBoogie\Facets\QueryString;

class IsHomeExcludedCriterionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_test_parse_query_string
	 *
	 * @param string $query_string
	 * @param boolean $expected
	 */
	public function test_parse_query_string($query_string, $expected)
	{
		$q = new QueryString($query_string);

		$criterion = new IsHomeExcludedCriterion('is_home_excluded');
		$criterion->parse_query_string($q);

		$this->assertSame([ 'is_home_excluded' => $expected ], $q->conditions);
	}

	public function provide_test_parse_query_string()
	{
		return [

			[ "is:home-included", false ],
			[ "is:home-excluded", true ],
			[ "in:home", false ],
			[ "out:home", true ]

		];
	}
}
