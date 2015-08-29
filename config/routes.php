<?php

namespace Icybee\Modules\Contents;

use ICanBoogie\HTTP\Request;
use ICanBoogie\Operation;

use Icybee\Modules\Contents\Operation\HomeExcludeOperation;
use Icybee\Modules\Contents\Operation\HomeIncludeOperation;

return [

	'api:contents:is-home-excluded:set' => [

		'pattern' => '/api/:' . Operation::DESTINATION . '/<' . Operation::KEY . ':\d+>/is-home-excluded',
		'controller' => HomeExcludeOperation::class,
		'via' => Request::METHOD_PUT

	],

	'api:contents:is-home-excluded:unset' => [

		'pattern' => '/api/:' . Operation::DESTINATION . '/<' . Operation::KEY . ':\d+>/is-home-excluded',
		'controller' => HomeIncludeOperation::class,
		'via' => Request::METHOD_DELETE

	]

];
