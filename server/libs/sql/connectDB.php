<?php
/**
 * User 10: ruslan
 * Date: 20.09.18
 * Time: 16:24
 */

namespace libs\sql;

use PDO;

class connectDB
{
	protected static $instance;


	private function __construct()
	{
		try
		{
			$opt = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false
			];

			self::$instance = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_DB , DB_USER, DB_PASS, $opt);
		}
		catch (PDOException $e)
		{
			echo "MySql Connection Error: " . $e->getMessage();
		}
	}


	public static function getInstance()
	{
		if (!self::$instance) {
			new connectDB();
		}

		return self::$instance;
	}

}