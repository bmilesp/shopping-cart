<?php 
/* SVN FILE: $Id$ */
/* Coupon Fixture generated on: 2010-10-14 11:18:19 : 1287069499*/

class CouponFixture extends CakeTestFixture {
	var $name = 'Coupon';
	var $table = 'coupons';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'site_id' => array('type'=>'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'code' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 250),
		'description' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 250),
		'minprice' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'minitems' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'maxitems' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'requireditem' => array('type'=>'integer', 'null' => false, 'default' => '-1'),
		'discounttype' => array('type'=>'string', 'null' => false, 'default' => 'flat', 'length' => 50),
		'discountamount' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'discountto' => array('type'=>'string', 'null' => false, 'default' => 'total', 'length' => 50),
		'auto' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'uses' => array('type'=>'integer', 'null' => false, 'default' => '10000000'),
		'remove' => array('type'=>'boolean', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'start_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'end_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'usps' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'ups_ground' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'ups_2_day_air' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'ups_next_day_air' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'site_id' => array('column' => 'site_id', 'unique' => 0))
	);
	var $records = array(array(
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
}
?>