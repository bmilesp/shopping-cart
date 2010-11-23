<?php 
/* SVN FILE: $Id$ */
/* CouponsController Test cases generated on: 2010-10-14 10:58:17 : 1287068297*/
App::import('Controller', 'Coupons');

class TestCoupons extends CouponsController {
	var $autoRender = false;
}

class CouponsControllerTest extends CakeTestCase {
	var $Coupons = null;
	//var $fixtures = array('app.coupon');

	function startTest() {
		$this->Coupons = new TestCoupons();
		$this->Coupons->constructClasses();
	}
	

	function testCouponsControllerInstance() {
		$this->assertTrue(is_a($this->Coupons, 'CouponsController'));
	}

	function endTest() {
		unset($this->Coupons);
		//ClassRegistry::flush();
	}
}
?>