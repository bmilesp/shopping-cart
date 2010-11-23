<?php 
require_once('connections.php');

class Coupons extends Connections {
	
	var $sessionName = null;
	var $evalSession = null;
	
	function __construct($sessionName = "cart.code"){
		parent::__construct();
		$this->sessionName = $sessionName;
		$splitter = split("\.",$sessionName);
		$this->evalSession = '$_SESSION[\''.implode("']['",$splitter)."']";
	}
	
	function getPosted(){
		return eval('return '.$this->evalSession.';');
	}
	
	
	function postSessionCoupon($couponName){
		if($couponName = $this->getDBCoupon($couponName)){
			$coupons = eval('return '.$this->evalSession.'');
			$coupons[strtolower($couponsName)] = 1;
			$postEval = $this->evalSession.' = $coupons;';
			eval($postEval);
		}
	}
	
	
	function getDBCoupon($couponCode = null){
		$code_sql = "SELECT * FROM carts.coupons WHERE (code LIKE '$couponCode') 
					 AND (auto = 0) AND site_id = {$this->site_id}";
		$code_query = mysql_query($code_sql) or die (mysql_error() . " <br><br>Query failed coupons Coupon class");
		$row = mysql_fetch_assoc($code_query);
		print_r($row);
	}
	
	private function getSessionVariable(){
		$totalKeys = count($this->sessionVarKeys);
		for($i = 0; $i < $totalKeys; $i++){
			$sessionArray = $this->buildKeys($sessionNameKeys[$i],$sessionArrayEval);
		} 
	}
	
	private function postSessionVariableVal(){
		
	}
	
	private function buildKeys($keyName,$array){
		return $array[$keyName];
	}
	
}?>