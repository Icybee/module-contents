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

use ICanBoogie\ErrorCollection;
use ICanBoogie\Module;
use ICanBoogie\Operation;

use Icybee\Modules\Contents\Content;

/**
 * Includes a record is the home page.
 *
 * @property Content $record
 */
class HomeIncludeOperation extends Operation
{
	/**
	 * Controls for the operation: permission(maintain), record and ownership.
	 */
	protected function get_controls()
	{
		return [

			self::CONTROL_PERMISSION => Module::PERMISSION_MAINTAIN,
			self::CONTROL_RECORD => true,
			self::CONTROL_OWNERSHIP => true

		] + parent::get_controls();
	}

	/**
	 * @inheritdoc
	 */
	protected function validate(ErrorCollection $errors)
	{
		return $errors;
	}

	protected function process()
	{
		$record = $this->record;
		$record->is_home_excluded = false;
		$record->save();

		$this->response->message = $this->format('%title is now included in the home page', [ '%title' => $record->title ]);

		return true;
	}
}
