<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$_SERVER['DOCUMENT_ROOT'] = __DIR__;

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

$app = new ICanBoogie\Core(ICanBoogie\array_merge_recursive(\ICanBoogie\get_autoconfig(), [

	'config-path' => [

		__DIR__ . DIRECTORY_SEPARATOR . 'config' => 10

	],

	'module-path' => [

		dirname(__DIR__)

	]

]));

$app->boot();

$errors = $app->modules->install(new ICanBoogie\Errors);
