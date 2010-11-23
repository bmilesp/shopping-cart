<?php 
/* SVN FILE: $Id$ */
/* Coupon Test cases generated on: 2010-10-14 11:18:19 : 1287069499*/
App::import('Model', 'Coupon');

class CouponTestCase extends CakeTestCase {
	var $Coupon = null;
	var $fixtures = array('app.coupon', 'app.coupons_used');

	function startTest() {
		$this->Coupon =& ClassRegistry::init('Coupon');
	}

	function testCouponInstance() {
		$this->assertTrue(is_a($this->Coupon, 'Coupon'));
	}

	function testCouponFind() {
		$this->Coupon->recursive = -1;
		$results = $this->Coupon->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Coupon' => array(
			'id'  => 1,
			'site_id'  => 1,
			'code'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet',
			'minprice'  => 1,
			'minitems'  => 1,
			'maxitems'  => 1,
			'requireditem'  => 1,
			'discounttype'  => 'Lorem ipsum dolor sit amet',
			'discountamount'  => 'Lorem ipsum dolor sit amet',
			'discountto'  => 'Lorem ipsum dolor sit amet',
			'auto'  => 1,
			'uses'  => 1,
			'remove'  => 1,
			'modified'  => 1,
			'start_date'  => '2010-10-14',
			'end_date'  => '2010-10-14',
			'usps'  => 1,
			'ups_ground'  => 1,
			'ups_2_day_air'  => 1,
			'ups_next_day_air'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>