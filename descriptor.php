<?php

namespace Icybee\Modules\Contents;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Module;

return [

	Module::T_CATEGORY => 'contents',
	Module::T_DESCRIPTION => 'Base module for content nodes such as articles or news.',
	Module::T_EXTENDS => 'nodes',

	Module::T_MODELS => [

		'primary' => [

			Model::T_EXTENDS => 'nodes',
			Model::T_SCHEMA => [

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

		'cache' => [

			Model::ACTIVERECORD_CLASS => 'ICanBoogie\ActiveRecord',
			Model::CLASSNAME => 'ICanBoogie\ActiveRecord\Model',
			Model::CONNECTION => 'local',
			Model::SCHEMA => [

				'fields' => [

					'nid' => [ 'foreign', 'primary' => true ],
					'timestamp' => 'timestamp',
					'body' => 'text'
				]
			]
		]
	],

	Module::T_NAMESPACE => __NAMESPACE__,
	Module::T_REQUIRED => true,
	Module::T_TITLE => 'Contents'
];