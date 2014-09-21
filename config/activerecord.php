<?php

namespace Icybee\Modules\Contents;

return [

	'facets' => [

		'contents' => [

			'date' =>  __NAMESPACE__ . '\DateCriterion',
			'day' =>   __NAMESPACE__ . '\DayCriterion',
			'month' => __NAMESPACE__ . '\MonthCriterion',
			'year' =>  __NAMESPACE__ . '\YearCriterion'

		]

	]

];