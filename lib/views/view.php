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
	/**
	 * If the view type is `home` the condition `is_home_excluded = false` is added to the
	 * conditions.
	 */
	protected function provide($provider, array $conditions)
	{
		if ($this->type == 'home')
		{
			$conditions['is_home_excluded'] = false;
		}

		return parent::provide($provider, $conditions);
	}
}