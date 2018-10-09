<?php
/**
 * User 10: ruslan
 */

namespace libs\models;

use libs\sql\DBService;
use libs\helpers\Validator;

class usersModels
{
	public $db;

	public function __construct()
	{
		$this->db = new DBService();
	}


	/**
	 * Get data one user
	 * @param $id
	 * @return array|bool
	 */
	public function getOneUser($id)
	{
		if (!Validator::checkNumber($id))
		{
			return false;
		}

		$sql = 'SELECT `id`, `username`, `email`, `role`, `active` FROM '.PRF.'users where `id` = :id';
		return $this->db->select($sql, array(':id' => $id));
	}


	/**
	 * Get data all users
	 * @return array
	 */
	public function getAllUsers()
	{
		$sql = 'SELECT `id`, `username`, `email`, `role`, `active` FROM '.PRF.'users';
		return $this->db->select($sql, null);
	}


	/**
	 * Create new user
	 * @return bool|string
	 */
	public function createUser()
	{
		$name = Validator::checkValueString($_POST['name']);
		$email = Validator::checkEmail($_POST['email']);
		$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

		if ($name && $email && $pass) {
			$sql = 'INSERT INTO ' . PRF . 'users (`username`, `email`, `password`) VALUES (?,?,?)';

			return $this->db->insert($sql, array($name,$email,$pass));
		}
		return false;
	}

	/**
	 * Update data user
	 *
	 * @param $id
	 * @param $data
	 * @return bool|int
	 */
	public function updateUser($id, $data)
	{
		$rec = array($id);
		$field = array();

		if(!empty($data['name']) && Validator::checkValueString($data['name']))
		{
			$field[] = 'username=?';
			$rec[] = $data['name'];
		}

		if(!empty($data['email']) && Validator::checkEmail($data['email']))
		{
			$field[] = 'email=?';
			$rec[] = $data['email'];
		}

		if(!empty($data['pass']))
		{
			$field[] = 'password=?';
			$rec[] = password_hash($data['pass'], PASSWORD_DEFAULT);
		}

		$fields = implode(', ', $field);

		if(!empty($fields) && Validator::checkNumber($id))
		{
			$sql = 'UPDATE '.PRF.'users SET '.$fields.' WHERE id=?';
			return $this->db->update($sql, array($rec));
		}
		return false;
	}


	/**
	 * Mark user as inactive
	 *
	 * @param $id
	 * @return bool|int
	 */
	public function inactiveUser($id)
	{
		if(Validator::checkNumber($id))
		{
			$sql = 'SELECT COUNT(*) FROM '.PRF.'events WHERE id_user = :id AND end_time > UNIX_TIMESTAMP()';
			$data = $this->db->select($sql, array(':id' => $id));

			if(!empty($data[0]['COUNT(*)']>1))
			{
				$sql = 'UPDATE '.PRF.'rooms SET `active`=? WHERE id=?';
				return $this->db->update($sql, array('NULL', $id));
			}
			return 'null';
		}
		return false;
	}
}