<?php
/**
 * User 10: ruslan
 */

namespace api\users;

use libs\Rest;
use libs\models\usersModels;
use libs\View;
use libs\authService;

class Users extends Rest
{
	private $usersModels;
	private $userRole;

	public function __construct()
	{
		$auth = new authService();
		$this->userRole = $auth->getUserRole();

		if($this->userRole !== 'admin' && AUTH)
		{
			View::sendData('error', ERR_005, 403);
			die();
		}

		$this->usersModels = new usersModels();
		parent::__construct();
	}


	/*
	 * Get User|s data
	 */
	public function getUsers($params)
	{
		if($params[0])
		{
			$data = $this->usersModels->getOneUser($params[0]);
		}
		else
		{
			$data = $this->usersModels->getAllUsers();
		}

		if(!empty($data))
		{
			View::sendData('success', $data, 200);
		}
		else
		{
			View::sendData('error', ERR_010, 400);
		}
		return true;
	}


	/**
	 * Create user account
	 *
	 * @return bool
	 */
	public function postUsers()
	{

		if($_POST['name'] && $_POST['email'] && $_POST['pass'])
		{
			$params = $this->usersModels->createUser();
		}

		if (is_numeric($params))
		{
			$data = $this->usersModels->getOneUser($params);
			View::sendData('success', $data, 201);
		}
		else
		{
			View::sendData('error', ERR_011, 400);
		}

		return true;
	}



	public function putUsers($params, $data)
	{
		if(!empty($data) && $params[0])
		{
			$countRow = $this->usersModels->updateUser($params[0], $data);
		}

		if(0 < $countRow)
		{
			$data = $this->usersModels->getAllUsers();
			View::sendData('success', $data, 200);
		}
		else
		{
			View::sendData('error', ERR_012, 400);
		}
		return true;
	}

	public function deleteUsers($params)
	{
		if($params[0])
		{
			$data = $this->usersModels->inactiveUser($params[0]);
		}

		if($data === 'null')
		{
			View::sendData('error', ERR_014, 400);
		}
		else if($data)
		{
			View::sendData('message', SUCC_DEL_USER, 200);
		}
		else
		{
			View::sendData('error', ERR_013, 400);
		}
		return true;
	}
}