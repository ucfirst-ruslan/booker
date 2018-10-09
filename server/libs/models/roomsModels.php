<?php
/**
 * User 10: ruslan
 */

namespace libs\models;

use libs\sql\DBService;
use libs\helpers\Validator;

class roomsModels
{
	public $db;


	public function __construct()
	{
		$this->db = new DBService();
	}


	/**
	 * Get one room
	 * @param $id
	 * @return mixed
	 */
	public function getOneRoom($id)
	{
		if (!Validator::checkNumber($id))
		{
			return false;
		}

		$sql = 'SELECT * FROM '.PRF.'rooms where `id` = :id';
		return $this->db->select($sql, array(':id' => $id));
	}


	/**
	 * @return array
	 */
	public function getAllRooms()
	{
		$sql = 'SELECT * FROM '.PRF.'rooms';
		return $this->db->select($sql, null);
	}


	/**
	 * @return string
	 */
	public function createRoom()
	{
		$name = Validator::checkValueString($_POST['name']);
		if ($name) {
			$sql = 'INSERT INTO ' . PRF . 'rooms (`name`) VALUES (?)';

			return $this->db->insert($sql, array($name));
		}
		return false;
	}


	/**
	 * @param $id
	 * @param $name
	 * @return int
	 */
	public function updateRoom($id, $name)
	{
		$name = Validator::checkValueString($name);

		if($name && Validator::checkNumber($id))
		{
			$sql = 'UPDATE '.PRF.'rooms SET `name`=? WHERE id=?';
			return $this->db->update($sql, array($name, $id));
		}
		return false;
	}


	/**
	 * @param $id
	 * @return int
	 */
	public function deleteRoom($id)
	{
		if (!Validator::checkNumber($id))
		{
			return false;
		}

		$sql = 'SELECT `id` FROM '.PRF.'rooms WHERE `id` = :id';
		$idRoom = $this->db->select($sql, array(':id' => $id));

		if (!empty($idRoom))
		{
			$sql = 'SELECT `end_time`, `id_room` FROM '.PRF.'events WHERE `id_room` = :id AND `end_time` <= NOW()';
			$result = $this->db->select($sql, array(':id' => $id));
		}

		if(empty($result))
		{
			$sql = 'DELETE FROM '.PRF.'rooms WHERE id = ?';
			return $this->db->delete($sql, array($id));
		}

		return false;
	}



}