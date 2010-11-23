<?php 
/* SVN FILE: $Id$ */
/* MyOtherApp schema generated on: 2010-10-14 10:10:11 : 1287067151*/
class MyOtherAppSchema extends CakeSchema {
	var $name = 'MyOtherApp';

	var $path = 'C:\bp\wamp\www\cartsite2.0\app\tmp\tests';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => 0, 'key' => 'primary'),
		'article_id' => array('type' => 'integer', 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => false),
		'comment' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'published' => array('type' => 'string', 'null' => true, 'default' => 'N', 'length' => 1),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => true))
	);
	var $posts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => 0, 'key' => 'primary'),
		'author_id' => array('type' => 'integer', 'null' => false),
		'title' => array('type' => 'string', 'null' => false),
		'body' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'published' => array('type' => 'string', 'null' => true, 'default' => 'N', 'length' => 1),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => true))
	);
	var $posts_tags = array(
		'post_id' => array('type' => 'integer', 'null' => false, 'key' => 'primary'),
		'tag_id' => array('type' => 'string', 'null' => false, 'key' => 'primary'),
		'indexes' => array('posts_tag' => array('column' => array('tag_id', 'post_id'), 'unique' => 1))
	);
	var $tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => 0, 'key' => 'primary'),
		'tag' => array('type' => 'string', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => true))
	);
	var $datatypes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => 0, 'key' => 'primary'),
		'float_field' => array('type' => 'float', 'null' => false, 'length' => '5,2'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => true))
	);
}
?>