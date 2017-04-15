<?php

namespace Icybee\Modules\Contents;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Module\Descriptor;

return [

	Descriptor::ID => 'contents',
	Descriptor::CATEGORY => 'contents',
	Descriptor::DESCRIPTION => "Base module for content nodes such as articles or news.",
	Descriptor::INHERITS => 'nodes',

	Descriptor::MODELS => [

		'primary' => [

			Model::EXTENDING => 'nodes',
			Model::SCHEMA => [

				'subtitle' => 'varchar',
				'body' => 'text',
				'excerpt' => 'text',
				'date'=> 'datetime',
				'editor' => [ 'varchar', 32 ],
				'is_home_excluded' => [ 'boolean', 'indexed' => true ]

			]
		],

		'rendered' => [

			Model::CLASSNAME => Model::class,
			Model::CONNECTION => 'local',
			Model::SCHEMA => [

				'nid' => [ 'foreign', 'primary' => true ],
				'updated_at' => 'datetime',
				'body' => 'text'

			]
		]
	],

	Descriptor::NS => __NAMESPACE__,
	Descriptor::TITLE => "Contents"

];
