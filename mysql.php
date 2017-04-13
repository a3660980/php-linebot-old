<?php
	class Database {
		public static function initDB() {
			$db_host = 'localhost';  //主機位置
			$db_user = 'ouvek_kostiva';  //帳號
			$db_pass = ''; //密碼
			$db_name = 'c9';  //資料庫名稱
			$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";
			$db = new PDO($dsn, $db_user, $db_pass);
                        return $db; //回傳
		}

		
	}