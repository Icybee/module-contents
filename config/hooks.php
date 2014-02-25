<?php

namespace Icybee\Modules\Contents;

$hooks = __NAMESPACE__ . '\Hooks::';

return [

	'events' => [

		'Icybee\Modules\Cache\Collection::collect' => $hooks . 'on_cache_collection_collect',
		'Icybee\Modules\Files\File::move' => $hooks . 'on_file_move'
	]
];