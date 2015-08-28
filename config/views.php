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

			Options::ASSETS => $assets

		],

		'home' => [

			Options::ASSETS => $assets,
			Options::CONDITIONS => [

				'in:home' => true

			]

		]

	]

];
