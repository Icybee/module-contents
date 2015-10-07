<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Contents\Block\ManageBlock;

use Brickrouge\Element;

use Icybee\Block\ManageBlock;
use Icybee\Block\ManageBlock\BooleanColumn;
use Icybee\Modules\Contents\Content;

/**
 * Representation of the `is_home_excluded` column.
 */
class IsHomeExcludedColumn extends BooleanColumn
{
	public function __construct(ManageBlock $manager, $id, array $options = [])
	{
		parent::__construct($manager, $id, $options + [

			'filters' => [

				'options' => [

					'=1' => "Excluded from home",
					'=0' => "Included in home"
				]
			]

		]);
	}

	/**
	 * @param Content $record
	 *
	 * @return Element
	 */
	public function render_cell($record)
	{
		return new Element('i', [

			Element::INNER_HTML => '',

			'class' => 'icon-home trigger ' . ($record->{ $this->id } ? 'on' : ''),
			'data-nid' => $record->nid,
			'title' => "Include or exclude the record from the view 'home'"

		]);
	}
}
