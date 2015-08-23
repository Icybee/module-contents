<?php

namespace Icybee\Modules\Contents;

use ICanBoogie;
use Icybee;

$hooks = Hooks::class . '::';

return [

	Icybee\Modules\Cache\CacheCollection::class . '::collect' => $hooks . 'on_cache_collection_collect',
	Icybee\Modules\Files\File::class . '::move' => $hooks . 'on_file_move',
	ICanBoogie\Facets\RecordCollection::class . '::alter' => Content::class . '::on_alter_record_collection',
	View::class . '::rescue' => $hooks . 'on_view_rescue'

];
