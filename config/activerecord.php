<?php

namespace Icybee\Modules\Contents;

return [

	'facets' => [

		'contents' => [

			'date' =>  DateCriterion::class,
			'day' =>   DayCriterion::class,
			'month' => MonthCriterion::class,
			'year' =>  YearCriterion::class,
			'in:home' => InHomeCriterion::class

		]

	]

];
