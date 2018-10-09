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
	public function getUsers($id)
	{
		if($id[0])
		{
			$data = $this->usersModels->getOneUser($id[0]);
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
			$id = $this->usersModels->createUser();
		}

		if (is_numeric($id))
		{
			$data = $this->usersModels->getOneUser($id);
			View::sendData('success', $data, 201);
		}
		else
		{
			View::sendData('error', ERR_011, 400);
		}

		return true;
	}



	public function putUsers($id, $data)
	{
		if(!empty($data) && $id[0])
		{
			$countRow = $this->usersModels->updateUser($id[0], $data);
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

	public function deleteUsers($id)
	{
		if($id[0])
		{
			$data = $this->usersModels->inactiveUser($id[0]);
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