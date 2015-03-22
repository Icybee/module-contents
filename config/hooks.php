<?php

namespace Icybee\Modules\Contents;

$hooks = Hooks::class . '::';

return [

	'events' => [

		\Icybee\Modules\Cache\Collection::class . '::collect' => $hooks . 'on_cache_collection_collect',
		\Icybee\Modules\Files\File::class . '::move' => $hooks . 'on_file_move',
		\Icybee\Modules\Views\ActiveRecordProvider::class . '::alter_result' => Content::class . '::on_views_activerecordprovider_alter_result',
		View::class . '::rescue' => $hooks . 'on_view_rescue'

	]
];
