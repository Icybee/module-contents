<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Contents\Block;

use Brickrouge\Document;

use Icybee\Block\ManageBlock\DateColumn;
use Icybee\Modules\Contents as Root;
use Icybee\Modules\Contents\Module;

class ManageBlock extends \Icybee\Modules\Nodes\Block\ManageBlock
{
	static protected function add_assets(Document $document)
	{
		parent::add_assets($document);

		$document->css->add(Root\DIR . 'public/admin.css');
		$document->js->add(Root\DIR . 'public/admin.js');
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
