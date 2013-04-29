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

		$r = Content::from(array('body' => '<p>BODY</p>', 'excerpt' => '<p>EXCERPT</p>'));
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

		$r = Content::from(array('body' => '<p>BODY</p>'));
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

	public function test_get_year()
	{
		$r = Content::from(array('date' => '2013-12-11'));
		$this->assertEquals(2013, $r->year);
	}

	/**
	 * @expectedException ICanBoogie\PropertyNotWritable
	 */
	public function test_set_year()
	{
		$r = Content::from(array('date' => '2013-12-11'));
		$r->year = true;
	}

	public function test_get_month()
	{
		$r = Content::from(array('date' => '2013-12-11'));
		$this->assertSame('12', $r->month);

		$r = Content::from(array('date' => '2013-01-11'));
		$this->assertSame('01', $r->month);
	}

	/**
	 * @expectedException ICanBoogie\PropertyNotWritable
	 */
	public function test_set_month()
	{
		$r = Content::from(array('date' => '2013-12-11'));
		$r->month = true;
	}

	public function test_get_day()
	{
		$r = Content::from(array('date' => '2013-12-11'));
		$this->assertSame('11', $r->day);

		$r = Content::from(array('date' => '2013-12-01'));
		$this->assertSame('01', $r->day);
	}

	/**
	 * @expectedException ICanBoogie\PropertyNotWritable
	 */
	public function test_set_day()
	{
		$r = Content::from(array('date' => '2013-12-11'));
		$r->day = true;
	}
}