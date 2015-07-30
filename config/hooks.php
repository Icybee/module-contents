<?php

namespace Icybee\Modules\Contents;

use ICanBoogie\Facets\RecordCollection;
use Icybee\Modules\Cache\CacheCollection as CacheCollection;
use Icybee\Modules\Files\File;

$hooks = Hooks::class . '::';

return [

	'events' => [

		CacheCollection::class . '::collect' => $hooks . 'on_cache_collection_collect',
		File::class . '::move' => $hooks . 'on_file_move',
		RecordCollection::class . '::alter' => Content::class . '::on_alter_record_collection',
		View::class . '::rescue' => $hooks . 'on_view_rescue'

	]
];
