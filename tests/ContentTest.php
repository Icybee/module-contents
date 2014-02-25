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

use ICanBoogie\DateTime;

class ContentTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_test_readonly_properties
	 * @expectedException ICanBoogie\PropertyNotWritable
	 * @param string $property Property name.
	 */
	public function test_readonly_properties($property)
	{
		Content::from()->$property = null;
	}

	public function provide_test_readonly_properties()
	{
		$properties = 'year month day';

		return array_map(function($v) { return (array) $v; }, explode(' ', $properties));
	}

	/**
	 * @dataProvider provide_test_get_property
	 */
	public function test_get_property($property, $fixture, $expected)
	{
		$this->assertSame($expected, Content::from($fixture)->$property);
	}

	public function provide_test_get_property()
	{
		global $core;

		return [

			[ 'year', [ 'date' => '2013-12-11' ], 2013 ],
			[ 'month', [ 'date' => '2013-12-11' ], '12' ],
			[ 'month', [ 'date' => '2013-01-11' ], '01' ],
			[ 'day', [ 'date' => '2013-12-11' ], '11' ],
			[ 'day', [ 'date' => '2013-12-01' ], '01' ]
		];
	}

	/**
	 * Checks that the defined excerpt is returned and not created from the body, and that the
	 * excerpt is exported by {@link Node::to_array()} and `__sleep`.
	 */
	public function testDefinedExcerpt()
	{
		$r = new Content;
		$r->body = '<p>BODY</p>';
		$r->excerpt = '<p>EXCERPT</p>';
		$this->assertEquals('<p>EXCERPT</p>', $r->excerpt);
		$this->assertArrayHasKey('excerpt', $r->to_array());
		$this->assertContains('excerpt', $r->__sleep());

		$r = Content::from([ 'body' => '<p>BODY</p>', 'excerpt' => '<p>EXCERPT</p>' ]);
		$this->assertEquals('<p>EXCERPT</p>', $r->excerpt);
		$this->assertArrayHasKey('excerpt', $r->to_array());
		$this->assertContains('excerpt', $r->__sleep());
	}

	/**
	 * The `excerpt` getter MUST NOT create the property.
	 */
	public function testUndefinedExcerpt()
	{
		$r = new Content;
		$r->body = '<p>BODY</p>';
		$this->assertEquals('<p>BODY</p>', $r->excerpt);
		$this->assertArrayNotHasKey('excerpt', $r->to_array());
		$this->assertNotContains('excerpt', $r->__sleep());

		$r = Content::from([ 'body' => '<p>BODY</p>' ]);
		$this->assertEquals('<p>BODY</p>', $r->excerpt);
		$this->assertArrayNotHasKey('excerpt', $r->to_array());
		$this->assertNotContains('excerpt', $r->__sleep());
	}

	public function test_date()
	{
		$r = new Content;
		$d = $r->date;
		$this->assertInstanceOf('ICanBoogie\DateTime', $d);
		$this->assertTrue($d->is_empty);
		$this->assertEquals('UTC', $d->zone->name);
		$this->assertEquals('0000-00-00 00:00:00', $d->as_db);

		$r->date = '2013-03-07 18:30:45';
		$d = $r->date;
		$this->assertInstanceOf('ICanBoogie\DateTime', $d);
		$this->assertFalse($d->is_empty);
		$this->assertEquals('UTC', $d->zone->name);
		$this->assertEquals('2013-03-07 18:30:45', $d->as_db);

		$r->date = new DateTime('2013-03-07 18:30:45', 'utc');
		$d = $r->date;
		$this->assertInstanceOf('ICanBoogie\DateTime', $d);
		$this->assertFalse($d->is_empty);
		$this->assertEquals('UTC', $d->zone->name);
		$this->assertEquals('2013-03-07 18:30:45', $d->as_db);

		$r->date = null;
		$this->assertInstanceOf('ICanBoogie\DateTime', $d);

		$r->date = DateTime::now();
		$properties = $r->__sleep();
		$this->assertArrayHasKey('date', $properties);
		$array = $r->to_array();
		$this->assertArrayHasKey('date', $array);
	}
}