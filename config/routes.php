<?php

namespace Icybee\Modules\Contents;

use ICanBoogie\Operation;

return array
(
	'api:contents:is-home-excluded:set' => array
	(
		'pattern' => '/api/:' . Operation::DESTINATION . '/<' . Operation::KEY . ':\d+>/is-home-excluded',
		'controller' => __NAMESPACE__ . '\HomeExcludeOperation',
		'via' => 'PUT'
	),

	'api:contents:is-home-excluded:unset' => array
	(
		'pattern' => '/api/:' . Operation::DESTINATION . '/<' . Operation::KEY . ':\d+>/is-home-excluded',
		'controller' => __NAMESPACE__ . '\HomeIncludeOperation',
		'via' => 'DELETE'
	)
);