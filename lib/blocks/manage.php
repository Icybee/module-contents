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

use Brickrouge\Element;

class ManageBlock extends \Icybee\Modules\Nodes\ManageBlock
{
	public function __construct(Module $module, array $attributes=array())
	{
		parent::__construct
		(
			$module, $attributes + array
			(
				self::T_COLUMNS_ORDER => array
				(
					'title', 'url', 'is_home_excluded', 'is_online', 'uid', 'date', 'modified'
				),

				self::T_ORDER_BY => array('date', 'desc')
			)
		);
	}

	static protected function add_assets(\Brickrouge\Document $document)
	{
		parent::add_assets($document);

		$document->css->add(DIR . 'public/admin.css');
		$document->js->add(DIR . 'public/admin.js');
	}

	protected function columns()
	{
		return parent::columns() + array
		(
			'date' => array
			(
				'class' => 'date'
			),

			'is_home_excluded' => array
			(
				'label' => null,
				'filters' => array
				(
					'options' => array
					(
						'=1' => "Excluded from home",
						'=0' => "Included in home"
					)
				),

				'sortable' => false
			)
		);
	}

	/**
	 * Updates filters with the `is_home_excluded` filter.
	 */
	protected function update_filters(array $filters, array $modifiers)
	{
		$filters = parent::update_filters($filters, $modifiers);

		if (isset($modifiers['is_home_excluded']))
		{
			$value = $modifiers['is_home_excluded'];

			if ($value === '' || $value === null)
			{
				unset($filters['is_home_excluded']);
			}
			else
			{
				$filters['is_home_excluded'] = !empty($value);
			}
		}

		return $filters;
	}

	/**
	 * Alters query with the `is_home_excluded` filter.
	 */
	protected function alter_query(Query $query, array $filters)
	{
		if (isset($filters['is_home_excluded']))
		{
			$query->where('is_home_excluded = ?', $filters['is_home_excluded']);
		}

		return parent::alter_query($query, $filters);
	}

	/**
	 * Renders a cell of the `is_home_excluded` column.
	 *
	 * @param ActiveRecord $record
	 * @param string $property
	 */
	protected function render_cell_is_home_excluded(ActiveRecord $record, $property)
	{
		return new Element
		(
			'i', array
			(
				'class' => 'icon-home trigger ' . ($record->$property ? 'on' : ''),
				'data-nid' => $record->nid,
				'title' => "Include or exclude the record from the view 'home'"
			)
		);
	}
}