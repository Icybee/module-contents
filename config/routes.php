<?php

namespace Icybee\Modules\Contents;

return array
(
	'api:contents:is-home-excluded:set' => array
	(
		'pattern' => '/api/:_operation_module/<_operation_key:\d+>/is-home-excluded',
		'controller' => __NAMESPACE__ . '\HomeExcludeOperation',
		'via' => 'PUT'
	),

	'api:contents:is-home-excluded:unset' => array
	(
		'pattern' => '/api/:_operation_module/<_operation_key:\d+>/is-home-excluded',
		'controller' => __NAMESPACE__ . '\HomeIncludeOperation',
		'via' => 'DELETE'
	)
);