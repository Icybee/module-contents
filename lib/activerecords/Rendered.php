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

/**
 * Representation of a rendered content record.
 */
class Rendered extends ActiveRecord
{
	use ActiveRecord\UpdatedAtProperty;

	/**
	 * The identifier of the associated content record.
	 *
	 * @var int
	 */
	public $nid;

	/**
	 * The rendered body of the associated content record.
	 *
	 * @var string
	 */
	public $body;
}
