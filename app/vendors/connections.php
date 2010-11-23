<?php 
class Connections{
	/* just change the $site var to the name cell in the carts.sites table: */
	var $site = null;//assign site in webroot/site.php
	/* ----------------------------------------------------------------- */ 
	var $cartHost = "localhost";
	var $cartUser = "ugpadmin";
	var $cartPasswd = "P13g4u31.";
	var $cartDbname = "carts";
	var $cartTableName = "sites";
	var $adminDbname = "admin";
	var $security_salt = '';
	var $host_name = '';
	var $page_title = '';
	var $site_id = null;
	
	
	function __construct($site = null){//site is now set from an include file in webroot called site.php
		
		if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
			if(file_exists('unique/site.php')){
				include('unique/site.php');
			}
			$q="SELECT site_id,page_title,host_name,security_salt,name FROM `{$this->cartTableName}` WHERE `name` = '{$this->site}' LIMIT 1";
		}else{
			$q="SELECT site_id,page_title,host_name,security_salt,name FROM `{$this->cartTableName}` WHERE `ftp_server` = '{$_SERVER['SERVER_ADDR']}' LIMIT 1";
			
		}
		$this->connectToCartsDB();
		
		$r=mysql_query($q);
		$row = mysql_fetch_assoc($r);
		$this->site = $row['name'];
		$this->host_name = $row['host_name'];
		$this->page_title = $row['page_title'];
		$this->security_salt = $row['security_salt'];
		$this->site_id = $row['site_id'];
	}
	
	function getCartDBField($field='id'){
		$q="SELECT $field FROM `sites` WHERE `name` = '{$this->site}' LIMIT 1";
		$r=mysql_query($q);
		$row = mysql_fetch_assoc($r);
		return $row[$field];
	}
	
	function connectToCartsDB(){
		$conn = mysql_connect( $this->cartHost, $this->cartUser, $this->cartPasswd )
		or die ( "Couldn't connect to carts server." );
		$db = mysql_select_db( 'carts', $conn )
		or die ( "Couldn't select carts database" );
	}
}
?>