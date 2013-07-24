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

class ManageBlock extends \Icybee\Modules\Nodes\ManageBlock
{
	static protected function add_assets(\Brickrouge\Document $document)
	{
		parent::add_assets($document);

		$document->css->add(DIR . 'public/admin.css');
		$document->js->add(DIR . 'public/admin.js');
	}

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

	/**
	 * Adds the following columns:
	 *
	 * - `date`: An instance of {@link \Icybee\ManageBlock\DateColumn}.
	 * - `is_home_excluded`: An instance of {@link ManageBlock\IsHomeExcludedColumn}.
	 *
	 * @return array
	 */
	protected function get_available_columns()
	{
		return array_merge(parent::get_available_columns(), array
		(
			'date' => 'Icybee\ManageBlock\DateColumn',
			'is_home_excluded' => __CLASS__ . '\IsHomeExcludedColumn'
		));
	}
}

namespace Icybee\Modules\Contents\ManageBlock;

use Brickrouge\Element;

/**
 * Representation of the `is_home_excluded` column.
 */
class IsHomeExcludedColumn extends \Icybee\ManageBlock\BooleanColumn
{
	public function __construct(\Icybee\ManageBlock $manager, $id, array $options=array())
	{
		parent::__construct
		(
			$manager, $id, $options + array
			(
				'filters' => array
				(
					'options' => array
					(
						'=1' => "Excluded from home",
						'=0' => "Included in home"
					)
				),

				'cell_renderer' => __NAMESPACE__ . '\IsHomeExcludedCellRenderer'
			)
		);
	}
}

/**
 * Renderer for the `is_home_excluded` column cell.
 */
class IsHomeExcludedCellRenderer extends \Icybee\ManageBlock\BooleanCellRenderer
{
	/**
	 * Returns a _boolean_ element representing a little house.
	 *
	 * @return \Brickrouge\Element
	 */
	public function __invoke($record, $property)
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