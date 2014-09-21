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

class View extends \Icybee\Modules\Nodes\View
{
	protected function get_default_conditions()
	{
		return [

			'order' => '-date' // TODO-20120528: Should be "-date,-created_at" but multiple order is not supported yet

		] + parent::get_default_conditions();
	}

	/**
	 * If the view type is `home` the condition `is_home_excluded = false` is added to the
	 * conditions.
	 */
	protected function get_important_conditions()
	{
		$conditions = parent::get_important_conditions();

		if ($this->type == 'home')
		{
			$conditions['is_home_excluded'] = false;
		}

		return $conditions;
	}
}