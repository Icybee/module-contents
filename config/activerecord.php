<?php

namespace Icybee\Modules\Contents\Facets;

use ICanBoogie\Facets\DateCriterion;

return [

	'facets' => [

		'contents' => [

			'date' =>  DateCriterion::class,
			'day' =>   DayCriterion::class,
			'month' => MonthCriterion::class,
			'year' =>  YearCriterion::class,
			'is_home_excluded' => IsHomeExcludedCriterion::class

		]

	]

];
