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

use ICanBoogie\Updater\Update;
use ICanBoogie\Updater\AssertionFailed;

/**
 * - Renames table `contents__cache` as `contents__rendered`.
 *
 * @module contents
 */
class Update20140330 extends Update
{
	public function update_rename_model_cache_as_rendered()
	{
		$connection = $this->app->connections['local'];

		if ($connection->table_exists('contents__rendered'))
		{
			throw new AssertionFailed(__FUNCTION__, []);
		}

		$connection->exec('CREATE TABLE contents__rendered AS SELECT `nid`, `timestamp` AS `updated_at`, `body` FROM contents__cache');
		$connection->exec('DROP TABLE contents__cache');
	}
}