<?php

namespace Icybee\Modules\Contents;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Module\Descriptor;

return [

	Descriptor::CATEGORY => 'contents',
	Descriptor::DESCRIPTION => 'Base module for content nodes such as articles or news.',
	Descriptor::INHERITS => 'nodes',

	Descriptor::MODELS => [

		'primary' => [

			Model::EXTENDING => 'nodes',
			Model::SCHEMA => [

				'fields' => [

					'subtitle' => 'varchar',
					'body' => 'text',
					'excerpt' => 'text',
					'date'=> 'datetime',
					'editor' => [ 'varchar', 32 ],
					'is_home_excluded' => [ 'boolean', 'indexed' => true ]
				]
			]
		],

		'rendered' => [

			Model::CLASSNAME => 'ICanBoogie\ActiveRecord\Model',
			Model::CONNECTION => 'local',
			Model::SCHEMA => [

				'fields' => [

					'nid' => [ 'foreign', 'primary' => true ],
					'updated_at' => 'datetime',
					'body' => 'text'
				]
			]
		]
	],

	Descriptor::NS => __NAMESPACE__,
	Descriptor::REQUIRED => true,
	Descriptor::TITLE => 'Contents'

];
