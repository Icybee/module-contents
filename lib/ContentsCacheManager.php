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

use ICanBoogie\I18n;
use Icybee\Modules\Cache\CacheManager;

/**
 * Manages cache for contents body.
 *
 * The state of the cache is saved in the registry under `contents.cache_rendered_body`.
 */
class ContentsCacheManager implements CacheManager
{
	public $title = "Contents body";
	public $description = "The rendered body of contents is cached.";
	public $group = 'contents';
	public $state = false;
	public $config_preview;

	/**
	 * @var \ICanBoogie\Core|\Icybee\Binding\CoreBindings
	 */
	private $app;

	public function __construct()
	{
		$this->app = \ICanBoogie\app();
		$this->state = !empty($this->app->registry['contents.cache_rendered_body']);
	}

	public function enable()
	{
		return $this->app->registry['contents.cache_rendered_body'] = true;
	}

	public function disable()
	{
		return $this->app->registry['contents.cache_rendered_body'] = false;
	}

	public function stat()
	{
		$app = $this->app;
		$model = $app->models['contents/rendered'];

		list($count, $size) = $model
			->select('COUNT(nid) count, SUM(LENGTH(body)) size')
			->one(\PDO::FETCH_NUM);

		return [ (int) $count, $app->translate(':count records<br /><span class="small">:size</span>', [ ':count' => (int) $count, 'size' => \ICanBoogie\I18n\format_size($size) ]) ];
	}

	function clear()
	{
		return $this->app->models['contents/rendered']->truncate();
	}
}
