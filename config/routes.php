<?php

namespace Icybee\Modules\Contents;

use ICanBoogie\Operation;

return [

	'api:contents:is-home-excluded:set' => [

		'pattern' => '/api/:' . Operation::DESTINATION . '/<' . Operation::KEY . ':\d+>/is-home-excluded',
		'controller' => __NAMESPACE__ . '\HomeExcludeOperation',
		'via' => 'PUT'
	],

	'api:contents:is-home-excluded:unset' => [

		'pattern' => '/api/:' . Operation::DESTINATION . '/<' . Operation::KEY . ':\d+>/is-home-excluded',
		'controller' => __NAMESPACE__ . '\HomeIncludeOperation',
		'via' => 'DELETE'
	]
];