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

class DeleteBlock extends \Icybee\Modules\Nodes\DeleteBlock
{
	/**
	 * Returns the record excerpt as preview.
	 */
	protected function render_preview(ActiveRecord $record)
	{
		return $record->excerpt;
	}
}