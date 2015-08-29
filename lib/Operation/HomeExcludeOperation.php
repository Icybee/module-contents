<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Contents\Operation;

use Icybee\Modules\Contents\Content;

/**
 * Excludes a record from the home page.
 *
 * @property Content $record
 */
class HomeExcludeOperation extends HomeIncludeOperation
{
	protected function process()
	{
		$record = $this->record;
		$record->is_home_excluded = true;
		$record->save();

		$this->response->message = $this->format('%title is now excluded from the home page', [ '%title' => $record->title ]);

		return true;
	}
}
