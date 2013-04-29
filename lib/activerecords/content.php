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

use ICanBoogie\DateTime;
use ICanBoogie\PropertyNotWritable;

/**
 * Representation of a content.
 *
 * The _content_ extends the _node_ with the following properties:
 *
 * - an optional subtitle
 * - a body (with a customizable editor)
 * - an optional excerpt, that can be generated from the body if it is not defined.
 * - a date
 * - an additionnal visibility option.
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
	protected function volatile_get_excerpt()
	{
		return \ICanBoogie\excerpt((string) $this);
	}

	/**
	 * Date of the content.
	 *
	 * @var string
	 */
	private $date;

	/**
	 * Returns the date of the content.
	 *
	 * @return \ICanBoogie\DateTime
	 */
	protected function volatile_get_date()
	{
		$date = $this->date;

		if ($date instanceof DateTime)
		{
			return $date;
		}

		return $this->date = $date === null ? DateTime::none() : new DateTime($date, 'utc');
	}

	/**
	 * Sets the {@link $date} property.
	 *
	 * @param mixed $value
	 */
	protected function volatile_set_date($value)
	{
		$this->date = $value;
	}

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
	 * The {@link $excerpt} property is unset if it is empty, so that it is created from the body
	 * when read for the first time.
	 *
	 * @param Model|string $model Defaults to "contents".
	 */
	public function __construct($model='contents')
	{
		parent::__construct($model);

		if (empty($this->excerpt))
		{
			unset($this->excerpt);
		}
	}

	/**
	 * @var bool|null true is the cache should be used, false if the cache should not be used, and
	 * null if we don't yet know if the cache should be used or not.
	 */
	private static $use_cache;
	private static $cache_model;

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

		if (self::$use_cache === null)
		{
			self::$use_cache = !empty($core->registry['contents.cache_rendered_body']);
		}

		$rendered_body = $body = $this->body;

		try
		{
			if (self::$use_cache)
			{
				if (self::$cache_model === null)
				{
					self::$cache_model = $core->models['contents/cache'];
				}

				$nid = $this->nid;
				$modified = $this->modified;
				$cached = self::$cache_model->select('body')->filter_by_nid_and_timestamp($nid, $modified)->rc;

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
					self::$cache_model->save
					(
						array
						(
							'nid' => $nid,
							'timestamp' => $modified,
							'body' => $rendered_body
						),

						null, array('on duplicate' => true)
					);
				}
			}
			else if ($this->editor)
			{
				$rendered_body = $this->render_body();
			}
		}
		catch (\Exception $e)
		{
			$rendered_body = $e->getMessage();
		}

		$this->rendered_body = $rendered_body;

		return $rendered_body;
	}

	/**
	 * Adds the {@link $date} property.
	 */
	public function to_array()
	{
		return parent::to_array() + array
		(
			'date' => $this->volatile_get_date()
		);
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
	protected function volatile_get_year()
	{
		return $this->volatile_get_date()->year;
	}

	/**
	 * Returns the month of the date.
	 *
	 * @return string A padded string e.g. "02";
	 */
	protected function volatile_get_month()
	{
		return $this->volatile_get_date()->format('m');
	}

	/**
	 * Returns the day of the date.
	 *
	 * @return string A padded string e.g. "02";
	 */
	protected function volatile_get_day()
	{
		return $this->volatile_get_date()->format('d');
	}

	/**
	 * Overrides the method to support the `date` property.
	 */
	protected function get_previous()
	{
		$ids = $this->model->select('nid')->order('date, created, nid')->own->visible->all(\PDO::FETCH_COLUMN);
		$key = array_search($this->nid, $ids);

		return $key ? $this->model[$ids[$key - 1]] : null;
	}

	/**
	 * Overrides the method to support the `date` property.
	 */
	protected function get_next()
	{
		$ids = $this->model->select('nid')->order('date, created, nid')->own->visible->all(\PDO::FETCH_COLUMN);
		$key = array_search($this->nid, $ids);

		return $key < count($ids) - 1 ? $this->model[$ids[$key + 1]] : null;
	}

	public function excerpt($limit=55)
	{
		return isset($this->excerpt) ? \ICanBoogie\excerpt($this->excerpt, $limit) : \ICanBoogie\excerpt((string) $this, $limit);
	}
}