<?php
/**
 * User 10: ruslan
 */

namespace libs;

use libs\helpers\Validator;
use libs\sql\DBService;

class authService
{
	private $token;
	private $db;


	/**
	 * authService constructor.
	 * Get token from header
	 * Create DB obj
	 */
	public function __construct()
	{
		$headers = getallheaders();
		$this->token = $headers['_token'];
		$this->db = new DBService();

		if (empty($this->token) && $_POST['email'] && $_POST['pass'])
		{
			$this->authUser();
		}
	}



	/**
	 * Get user
	 * @return array | boolean
	 */
	public function getUser()
	{
		if(!Validator::checkToken($this->token))
		{
			return false;
		}

		$getToken = $this->getToken();

		if(!empty($getToken))
		{
			// Send token
			$this->sendToken($this->token);

			//Update User token
			$this->updateToken($getToken[0]['id']);

			//Get user data
			return $this->getUserData($getToken[0]['id_user']);
		}

		return false;
	}

	/**
	 * Get token from DB
	 * @return array
	 */
	private function getToken()
	{
		$sql = 'SELECT * FROM '.PRF.'tokens where token = :token AND expires > UNIX_TIMESTAMP()';
		return $this->db->select($sql, array(':token' => $this->token));
	}

	/**
	 * Update token in DB
	 * @param $id
	 */
	private function updateToken($id)
	{
		$expiresTime = time() + EXPIRE_TOKEN;
		$sql = 'UPDATE '.PRF.'tokens SET expires = '.$expiresTime.' WHERE id = :id';
		$this->db->update($sql, array(':id' => $id));
		return true;
	}

	/**
	 * Get data user
	 * @param $id
	 * @return array
	 */
	private function getUserData($id)
	{
		$sql = 'SELECT `id`, `username`, `email`, `role`, `active` FROM '.PRF.'users where id = :id';
		return $this->db->select($sql, array(':id' => $id));
	}


	/**
	 * @return bool|string
	 */
	public function getUserRole()
	{
		$userData = $this->getUser();

		if(!empty($userData[0]['role']))
		{
			return $userData[0]['role'];
		}

		return false;
	}


	/**
	 * Send Token
	 */
	public function sendToken($token)
	{
		header('_token: '.$token);
	}

	/**
	 * Create token (34 chars)
	 * @return string. Example: $1$QZXApEeM$qLS2GdyEEplxAZCf3K0it1
	 */
	public function createToken()
	{
		return crypt(uniqid('', true));
	}


	/**
	 * Delete token
	 * @param $id
	 * @return int
	 */
	public function delUserToken($id)
	{
		$sql = 'DELETE FROM '.PRF.'tokens WHERE id = ?';
		return $this->db->delete($sql, array($id));
	}

	/**
	 * Delete all tokens of users whose time has expired
	 */
	public function delOldToken()
	{
		$sql = 'SELECT `id` FROM '.PRF.'tokens where expires < UNIX_TIMESTAMP()';
		$data = $this->db->select($sql, array());

		if(!empty($data))
		{
			foreach ($data as $key => $value) {
				if($key != 0)
				{
					$forDel .= ',';
				}
				$forDel .= $value['id'];
			}

			$sql = 'DELETE FROM '.PRF.'tokens WHERE id IN ('.$forDel.')';
			return $this->db->delete($sql, '');
		}
		return false;
	}
}