<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Contents;

use ICanBoogie\ActiveRecord\RecordNotFound;
use ICanBoogie\HTTP\ForceRedirect;

use Icybee\Modules\Cache\CacheCollection as CacheCollection;
use Icybee\Modules\Files\File;
use Icybee\Modules\Views\ViewOptions;

class Hooks
{
	/*
	 * Events
	 */

	/**
	 * Adds the `contents.body` cache manager to the cache collection.
	 *
	 * @param CacheCollection\CollectEvent $event
	 * @param CacheCollection $collection
	 */
	static public function on_cache_collection_collect(CacheCollection\CollectEvent $event, CacheCollection $collection)
	{
		$event->collection['contents.body'] = new ContentsCacheManager;
	}

	/**
	 * The callback is called when the `Icybee\Modules\Files\File::move` is triggered, allowing us
	 * to update contents to the changed path of resources.
	 *
	 * @param File\MoveEvent $event
	 * @param File $target
	 */
	static public function on_file_move(File\MoveEvent $event, File $target)
	{
		self::app()->models['contents']->execute
		(
			'UPDATE {self} SET `body` = REPLACE(`body`, ?, ?)', [ $event->from, $event->to ]
		);
	}

	/**
	 * Rescues a not found record by providing the best matching one.
	 *
	 * Match is computed from the slug of the model's own visible records. The rescue is attempted
	 * only if 'slug' is defined in the conditions.
	 *
	 * @param \Icybee\Modules\Views\View\RescueEvent $event
	 * @param View $target
	 *
	 * @throws RecordNotFound when no record can be found.
	 * @throws ForceRedirect when a record with a similar slug is found.
	 */
	static public function on_view_rescue(\Icybee\Modules\Views\View\RescueEvent $event, View $target)
	{
		if ($target->renders != ViewOptions::RENDERS_ONE)
		{
			return;
		}

		$conditions = $target->provider->conditions;
		$model = $target->module->model;

		if (!empty($conditions['nid']) || empty($conditions['slug']))
		{
			return;
		}

		$slug = $conditions['slug'];
		$tries = $model->select('nid, slug')->own->visible->order('date DESC')->pairs;
		$best_score = 0;
		$best_nid = null;

		foreach ($tries as $nid => $compare)
		{
			similar_text($slug, $compare, $p);

			if ($p > $best_score)
			{
				$best_nid = $nid;
				$best_score = $p;
			}

			if ($p > 90) break;
		}

		if ($best_score < 60)
		{
			throw new RecordNotFound('Record not found.', []);
		}
		else if ($best_nid)
		{
			$record = $model[$best_nid];

			\ICanBoogie\log('The record %title was rescued!', [ 'title' => $record->title ]);

			throw new ForceRedirect($record->url, 301);
		}
	}

	/**
	 * @return \ICanBoogie\Core|\ICanBoogie\Binding\ActiveRecord\CoreBindings
	 */
	static private function app()
	{
		return \ICanBoogie\app();
	}
}
