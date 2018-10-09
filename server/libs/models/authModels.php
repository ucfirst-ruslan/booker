<?php
/**
 * User 10: ruslan
 */

namespace libs\models;

use libs\helpers\Validator;
use libs\sql\DBService;
use libs\authService;

class authModels
{
	private $db;
	private $auth;

	public function __construct()
	{
		$this->db = new DBService();
		$this->auth = new authService();
	}

	public function loginUser($email, $pass)
	{
		if(Validator::checkEmail($email))
		{
			$sql = 'SELECT `id`, `password` FROM '.PRF.'users where `email` = :email';
			$userData =  $this->db->select($sql, array(':email' => $email));

			if (password_verify($pass, $userData[0]['password']))
			{
				$token = $this->auth->createToken();

				$sql = 'INSERT INTO ' . PRF . 'tokens (`id_user`, `token`, `expires`) VALUES (?,?,?)';
				$this->db->insert($sql, array($userData[0]['id'], $token, time() + EXPIRE_TOKEN));

				$this->auth->sendToken($token);

				$result = true;
			}
			else
			{
				$result = false;
			}

			$this->auth->delOldToken();

			return $result;
		}
	}


	/**
	 * @param $id
	 * @return bool|int
	 */
	public function logOutUser($id)
	{
		if(Validator::checkNumber($id))
		{
			return $this->auth->delUserToken($id);
		}
		return false;
	}
}