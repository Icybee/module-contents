<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie;

$_SERVER['DOCUMENT_ROOT'] = __DIR__;

chdir(__DIR__);

require __DIR__ . '/../vendor/autoload.php';

/*
 * Dummy `excerpt()` function.
 */
if (!function_exists('ICanBoogie\excerpt'))
{
	function excerpt($str)
	{
		return $str;
	}
}

$app = boot();
$app->modules->install();
