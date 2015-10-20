<?php
namespace Fisharebest\Algorithm;

/**
 * @package   fisharebest/algorithm
 * @author    Greg Roach <greg@subaqua.co.uk>
 * @copyright (c) 2015 Greg Roach <greg@subaqua.co.uk>
 * @license   GPL-3.0+
 *s
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

class MyersDiffTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Test empty sequences.
	 *
	 * @return string[]
	 */
	public function testBothEmpty() {
		$algorithm = new MyersDiff;
		$x = array();
		$y = array();
		$diff = array();

		$this->assertSame($diff, $algorithm->calculate($x, $y));
	}

	/**
	 * Test one empty sequence.
	 *
	 * @return string[]
	 */
	public function testFirstEmpty() {
		$algorithm = new MyersDiff;
		$x = array();
		$y = array('a', 'b', 'c');
		$diff = array(
			array('a', MyersDiff::INSERT),
			array('b', MyersDiff::INSERT),
			array('c', MyersDiff::INSERT),
		);

		$this->assertSame($diff, $algorithm->calculate($x, $y));
	}

	/**
	 * Test one empty sequence.
	 *
	 * @return string[]
	 */
	public function testSecondEmpty() {
		$algorithm = new MyersDiff;
		$x = array('a', 'b', 'c');
		$y = array();
		$diff = array(
			array('a', MyersDiff::DELETE),
			array('b', MyersDiff::DELETE),
			array('c', MyersDiff::DELETE),
		);

		$this->assertSame($diff, $algorithm->calculate($x, $y));
	}

	/**
	 * Test identical sequences.
	 *
	 * @return string[]
	 */
	public function testIdentical() {
		$algorithm = new MyersDiff;
		$x = array('a', 'b', 'c');
		$y = array('a', 'b', 'c');
		$diff = array(
			array('a', MyersDiff::KEEP),
			array('b', MyersDiff::KEEP),
			array('c', MyersDiff::KEEP),
		);

		$this->assertSame($diff, $algorithm->calculate($x, $y));
	}

	/**
	 * Test two non-empty sequences.
	 *
	 * @return string[]
	 */
	public function testBothNonEmpty() {
		$algorithm = new MyersDiff;
		$x = array('a', 'b', 'c', 'a', 'b', 'b', 'a');
		$y = array('c', 'b', 'a', 'b', 'a', 'c');
		$diff = array(
			array('a', MyersDiff::DELETE),
			array('b', MyersDiff::DELETE),
			array('c', MyersDiff::KEEP),
			array('b', MyersDiff::INSERT),
			array('a', MyersDiff::KEEP),
			array('b', MyersDiff::KEEP),
			array('b', MyersDiff::DELETE),
			array('a', MyersDiff::KEEP),
			array('c', MyersDiff::INSERT),
		);

		$this->assertSame($diff, $algorithm->calculate($x, $y));
	}

	/**
	 * Test delete-before-insert.
	 *
	 * @return string[]
	 */
	public function testDeleteBeforeInsert() {
		$algorithm = new MyersDiff;
		$x = array('a', 'b', 'c');
		$y = array('a', 'd', 'c');
		$diff = array(
			array('a', MyersDiff::KEEP),
			array('b', MyersDiff::DELETE),
			array('d', MyersDiff::INSERT),
			array('c', MyersDiff::KEEP),
		);

		$this->assertSame($diff, $algorithm->calculate($x, $y));
	}
}
