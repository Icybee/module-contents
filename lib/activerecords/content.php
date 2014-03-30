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

use ICanBoogie\ActiveRecord\DateTimePropertySupport;
use ICanBoogie\DateTime;
use ICanBoogie\PropertyNotWritable;

/**
 * Representation of a content.
 *
 * The {@link Content} class extends the {@link \Icybee\Modules\Nodes\Node} class with the
 * following properties:
 *
 * - {@link $subtitle}: An optional subtitle.
 * - {@link $body}: A body (with a customizable editor).
 * - {@link $excerpt}: An optional excerpt, that can be generated from the body if it is not
 * defined.
 * - {@link $date}: The date of the content.
 * - {@link $editor}: The editor used to edit the body of the content.
 * - {@link $is_home_excluded}: An additionnal visibility option.
 *
 * @property \ICanBoogie\DateTime $date The date of the content.
 */
class Content extends \Icybee\Modules\Nodes\Node
{
	const SUBTITLE = 'subtitle';
	const BODY = 'body';
	const EXCERPT = 'excerpt';
	const DATE = 'date';
	const EDITOR = 'editor';
	const IS_HOME_EXCLUDED = 'is_home_excluded';

	/**
	 * Subtitle.
	 *
	 * @var string
	 */
	public $subtitle;

	/**
	 * Body of the content.
	 *
	 * The body needs to be rendered by its editor in order to obtain the real body.
	 *
	 * @var string
	 */
	public $body;

	/**
	 * An excerpt of the body.
	 *
	 * @var string
	 */
	public $excerpt;

	/**
	 * Returns an excerpt of the body.
	 *
	 * The getter is invoked when the {@link $excerpt} property is not accessible.
	 *
	 * @return string
	 */
	protected function get_excerpt()
	{
		return \ICanBoogie\excerpt((string) $this);
	}

	use DateProperty;

	/**
	 * The identifier of the editor that was used to edit the body.
	 *
	 * @var string
	 */
	public $editor;

	/**
	 * `true` if the content should not appear on the "home" view.
	 *
	 * @var bool
	 */
	public $is_home_excluded;

	/**
	 * The {@link $excerpt} property is unset if it is empty, until it is defined again, the
	 * {@link get_excerpt()} getter provides a default value made from the {@link $body}
	 * property.
	 *
	 * @param Model|string $model Defaults to "contents".
	 */
	public function __construct($model='contents')
	{
		if (empty($this->excerpt))
		{
			unset($this->excerpt);
		}

		parent::__construct($model);
	}

	/**
	 * @var bool|null true is the cache should be used, false if the cache should not be used, and
	 * null if we don't yet know if the cache should be used or not.
	 */
	static private $use_cache;
	static private $cache_model;

	static private function obtain_cache()
	{
		global $core;

		if (self::$cache_model)
		{
			return self::$cache_model;
		}

		if (self::$use_cache === null)
		{
			self::$use_cache = !empty($core->registry['contents.cache_rendered_body']);
		}

		if (!self::$use_cache)
		{
			return;
		}

		return self::$cache_model = $core->models['contents/cache'];
	}

	private $rendered_body;

	/**
	 * Renders the body of the activerecord into a string.
	 *
	 * The body is rendered using the editor that was used to edit the content.
	 *
	 * A cache maybe used to store et retrieve the rendered content.
	 *
	 * @return string The rendered body.
	 */
	public function __toString()
	{
		global $core;

		$rendered_body = $this->rendered_body;

		if ($rendered_body)
		{
			return $rendered_body;
		}

		$rendered_body = $body = $this->body;

		try
		{
			$cache = self::obtain_cache();

			if ($cache)
			{
				$nid = $this->nid;
				$updated_at = $this->updated_at;
				$cached = $cache->select('body')->filter_by_nid_and_timestamp($nid, $updated_at)->rc;

				if ($cached)
				{
					return $cached;
				}

				if ($this->editor)
				{
					$rendered_body = $this->render_body();
				}

				if ($rendered_body && $rendered_body != $body)
				{
					$cache->save([

						'nid' => $nid,
						'timestamp' => $updated_at,
						'body' => $rendered_body

					], null, [ 'on duplicate' => true ] );
				}
			}
			else if ($this->editor)
			{
				$rendered_body = $this->render_body();
			}
		}
		catch (\Exception $e)
		{
			$rendered_body = \ICanBoogie\Debug::format_alert($e);
		}

		$this->rendered_body = $rendered_body;

		return $rendered_body;
	}

	/**
	 * Renders the body using the associated editor.
	 *
	 * @return string
	 */
	protected function render_body()
	{
		$body = $this->body;

		if (!$this->editor)
		{
			return $body;
		}

		$editor = \ICanBoogie\Core::get()->editors[$this->editor];

		return (string) $editor->render($editor->unserialize($body));
	}

	/**
	 * Returns the year of the date.
	 *
	 * @return string
	 */
	protected function get_year()
	{
		return $this->get_date()->year;
	}

	/**
	 * Returns the month of the date.
	 *
	 * @return string A padded string e.g. "02";
	 */
	protected function get_month()
	{
		return $this->get_date()->format('m');
	}

	/**
	 * Returns the day of the date.
	 *
	 * @return string A padded string e.g. "02";
	 */
	protected function get_day()
	{
		return $this->get_date()->format('d');
	}

	/**
	 * Overrides the method to support the `date` property.
	 */
	protected function lazy_get_previous()
	{
		$ids = $this->model->select('nid')->order('date, created_at, nid')->own->visible->all(\PDO::FETCH_COLUMN);
		$key = array_search($this->nid, $ids);

		return $key ? $this->model[$ids[$key - 1]] : null;
	}

	/**
	 * Overrides the method to support the `date` property.
	 */
	protected function lazy_get_next()
	{
		$ids = $this->model->select('nid')->order('date, created_at, nid')->own->visible->all(\PDO::FETCH_COLUMN);
		$key = array_search($this->nid, $ids);

		return $key < count($ids) - 1 ? $this->model[$ids[$key + 1]] : null;
	}

	/**
	 * Returns an excerpt of the content.
	 *
	 * If the {@link $excerpt} property is not empty the excerpt is created from it, otherwise it
	 * is created from the {@link $body}.
	 *
	 * @param number $limit The number of words desired.
	 *
	 * @return string
	 */
	public function excerpt($limit=55)
	{
		return isset($this->excerpt) ? \ICanBoogie\excerpt($this->excerpt, $limit) : \ICanBoogie\excerpt((string) $this, $limit);
	}
}

/**
 * Implements the`date` property.
 *
 * @property \ICanBoogie\DateTime $date The date of the record.
 */
trait DateProperty
{
	/**
	 * The date of the record.
	 *
	 * @var mixed
	 */
	private $date;

	/**
	 * Returns the date of the record.
	 *
	 * @return \ICanBoogie\DateTime
	 */
	protected function get_date()
	{
		return DateTimePropertySupport::datetime_get($this->date);
	}

	/**
	 * Sets the date of the record.
	 *
	 * @param mixed $datetime
	 */
	protected function set_date($datetime)
	{
		DateTimePropertySupport::datetime_set($this->date, $datetime);
	}
}