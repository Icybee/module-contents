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

use Icybee\ManageBlock\DateColumn;

class ManageBlock extends \Icybee\Modules\Nodes\ManageBlock
{
	static protected function add_assets(\Brickrouge\Document $document)
	{
		parent::add_assets($document);

		$document->css->add(DIR . 'public/admin.css');
		$document->js->add(DIR . 'public/admin.js');
	}

	public function __construct(Module $module, array $attributes = [])
	{
		parent::__construct($module, $attributes + [

			self::T_COLUMNS_ORDER => [

				'title', 'url', 'is_home_excluded', 'is_online', 'uid', 'date', 'updated_at'
			],

			self::T_ORDER_BY => [ 'date', 'desc' ]

		]);
	}

	/**
	 * Adds the following columns:
	 *
	 * - `date`: An instance of {@link DateColumn}.
	 * - `is_home_excluded`: An instance of {@link ManageBlock\IsHomeExcludedColumn}.
	 *
	 * @return array
	 */
	protected function get_available_columns()
	{
		return array_merge(parent::get_available_columns(), [

			'date' => DateColumn::class,
			'is_home_excluded' => ManageBlock\IsHomeExcludedColumn::class
		]);
	}

	protected function get_available_jobs()
	{
		return array_merge(parent::get_available_jobs(), [

			'home_include' => $this->t('home_include.operation.short_title'),
			'home_exclude' => $this->t('home_exclude.operation.short_title')

		]);
	}
}

namespace Icybee\Modules\Contents\ManageBlock;

use Brickrouge\Element;
use Icybee\Modules\Contents\Content;

/**
 * Representation of the `is_home_excluded` column.
 */
class IsHomeExcludedColumn extends \Icybee\ManageBlock\BooleanColumn
{
	public function __construct(\Icybee\ManageBlock $manager, $id, array $options = [])
	{
		parent::__construct($manager, $id, $options + [

			'filters' => [

				'options' => [

					'=1' => "Excluded from home",
					'=0' => "Included in home"
				]
			],

			'cell_renderer' => IsHomeExcludedCellRenderer::class

		]);
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
	 * @param Content $record
	 * @param string $property
	 *
	 * @return \Brickrouge\Element
	 */
	public function __invoke($record, $property)
	{
		return new Element('i', [

			'class' => 'icon-home trigger ' . ($record->$property ? 'on' : ''),
			'data-nid' => $record->nid,
			'title' => "Include or exclude the record from the view 'home'"

		]);
	}
}
