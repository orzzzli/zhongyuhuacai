<?php

/**
 * @Author: xuren
 * @Date:   2019-05-22 18:41:55
 * @Last Modified by:   xuren
 * @Last Modified time: 2019-05-22 18:42:22
 */
class GameCutModel {
	static $_table = 'ad_cut_percent_byday';
	static $_pk = 'id';
	static $_db_key = DEF_DB_CONN;
	static $_db = null;
	static function db(){
		if(self::$_db)
			return self::$_db;
		
		self::$_db = DbLib::getDbStatic(self::$_db_key,self::$_table,self::$_pk);
		return self::$_db;
	}
	
	public static function __callStatic($func, $arguments){
		return call_user_func_array(array(self::db(),$func), $arguments);
	}
	

}