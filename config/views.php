<?php

namespace Icybee\Modules\Contents;

use Icybee\Modules\Views\ViewOptions as Options;

$assets = [ '../public/page.css' ];

return [

	'contents' => [

		'@inherits' => 'nodes',

		'view' => [

			Options::ASSETS => $assets

		],

		'list' => [

			Options::ASSETS => $assets,
			Options::DEFAULT_CONDITIONS => [

				'order' => '-date'

			]

		],

		'home' => [

			Options::ASSETS => $assets,
			Options::CONDITIONS => [

				'is_home_excluded' => false

			],

			Options::DEFAULT_CONDITIONS => [

				'order' => '-date'

			]

		]

	]

];
