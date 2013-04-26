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

use ICanBoogie\ActiveRecord;
use ICanBoogie\ActiveRecord\Query;
use ICanBoogie\ActiveRecord\RecordNotFound;

class ViewProvider extends \Icybee\Modules\Nodes\ViewProvider
{
	/**
	 * Tries to rescue the record if finding the record failed.
	 */
	public function __invoke()
	{
		$rc = parent::__invoke();

		if (!$rc && $this->returns == self::RETURNS_ONE)
		{
			$rc = $this->rescue();
		}

		return $rc;
	}

	/**
	 * Support for the `year`, `month` and `day` conditions. Changes the order to
	 * `date DESC, created DESC`.
	 *
	 * If the view is of type "home" the query is altered to search for nodes which are not
	 * excluded from _home_.
	 */
	protected function alter_query(Query $query, array $conditions)
	{
		foreach ($conditions as $property => $value)
		{
			switch ($property)
			{
				case 'year':
					$query->where('YEAR(date) = ?', (int) $value);
					break;

				case 'month':
					$query->where('MONTH(date) = ?', (int) $value);
					break;

				case 'day':
					$query->where('DAY(date) = ?', (int) $value);
					break;
			}
		}

		if ($this->view->type == 'home')
		{
			$query->where('is_home_excluded = 0');
		}

		return parent::alter_query($query, $conditions)->order('date DESC, created DESC');
	}

	/**
	 * Rescues a missing record by providing the best matching one.
	 *
	 * Match is computed from the slug of the module's own visible records, thus rescue if only
	 * triggered if 'slug' is defined in the conditions.
	 *
	 * @return Content|null The record best matching the condition slug, or null if
	 * none was similar enough.
	 *
	 * @throws RecordNotFound if the record could not be rescued.
	 */
	protected function rescue()
	{
		$conditions = $this->conditions;

		if (!empty($conditions['nid']) || empty($conditions['slug']))
		{
			return;
		}

		$slug = $conditions['slug'];
		$model = $this->module->model;
		$tries = $model->select('nid, slug')->own->visible->order('date DESC')->pairs;
		$key = null;
		$max = 0;

		foreach ($tries as $nid => $compare)
		{
			similar_text($slug, $compare, $p);

			if ($p > $max)
			{
				$key = $nid;

				if ($p > 90)
				{
					break;
				}

				$max = $p;
			}
		}

		if ($p < 60)
		{
			throw new RecordNotFound('Record not found.', array());
		}
		else if ($key)
		{
			# FIXME-20130310: We MUST throw an exception !

			$record = $model[$key];

			\ICanBoogie\log('The record %title was rescued!', array('title' => $record->title));

			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . $record->url);

			exit;

			/*
			//TODO-20120109: should we redirect to the correct record URL ?

			return $record;
			*/
		}
	}
}