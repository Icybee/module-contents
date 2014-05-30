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

class ViewProvider extends \Icybee\Modules\Nodes\ViewProvider
{
	/**
	 * Tries to rescue the record if finding the record failed.
	 */
	public function __invoke(array $conditions)
	{
		return parent::__invoke($conditions + [

			'order' => '-date' // FIXME-20120528: Should be "-date,-created_at" but multiple order is not supported yet

		]);
	}
}