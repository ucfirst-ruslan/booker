<?php
/**
 * User 10: ruslan
 */

namespace libs\sql;

use libs\sql\connectDB;

class DBService
{
	private $pdo;

	/**
	 * DBService constructor.
	 */
	public function __construct()
	{
		$this->pdo = connectDB::getInstance();
	}


	/**
	 * @param $sql | String
	 * @param $data | Array [':key1'=>val1, ':key2'=>val2, ... ':key-n'=>val-n]
	 * @return array
	 */
	public function select($sql, $data = array())
	{   //$sql = 'SELECT `status` FROM bg_users where token = :token';
		try
		{
			$sth = $this->pdo->prepare($sql);
			if (!empty($data))
			{
				foreach ($data as $key => &$param)
				{
					$sth->bindParam($key, $param);
				}
			}
			$sth->execute();

			//var_dump($sth->fetchAll());
			return $sth->fetchAll();
		}
		catch (Exception $e)
		{
			print $e->getMessage();
		}
	}


	/**
	 * @param $sql | String
	 * @param $data | Array [val1, val2, ... val-n]
	 * @return string
	 */
	public function insert($sql, $data)
	{	//$sql = "INSERT INTO bg_rooms (`name`) VALUES (?)"
		try
		{
			$sth = $this->pdo->prepare($sql);

			$sth->execute($data);

			return $this->pdo->lastInsertId();
		}
		catch (Exception $e)
		{
			print $e->getMessage();

		}
	}

	/**
	 * @param $sql | String
	 * @param $data | Array [val1, val2, ... val-n]
	 * @return int
	 */
	public function update($sql, $data)
	{ //$sql = "UPDATE bg_rooms SET name = ? WHERE id = ?";
		try
		{
			$sth = $this->pdo->prepare($sql);
			$sth->execute($data);
			return $sth->rowCount();
		}
		catch (Exception $e)
		{
			print $e->getMessage();

		}
	}


	/**
	 * @param $sql | String
	 * @param $data | Array [val1, val2, ... val-n]
	 * @return int
	 */
	public function delete($sql, $data)
	{ //$sql = DELETE FROM bg_rooms WHERE id = ?;
		try
		{
			$sth = $this->pdo->prepare($sql);

			$sth->execute($data);

			return $sth->rowCount();
		}
		catch (Exception $e)
		{
			print $e->getMessage();

		}
	}
}