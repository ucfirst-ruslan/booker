<?php
/**
 * User 10: ruslan
 */

namespace api\rooms;


use libs\Rest;
use libs\models\roomsModels;
use libs\View;
use libs\authService;


class Rooms extends Rest
{
	private $roomsModels;
	private $userRole;


	public function __construct()
	{
		$this->roomsModels = new roomsModels();

		$auth = new authService();
		$this->userRole = $auth->getUserRole();

		if(!$this->userRole && AUTH)
		{
			View::sendData('error', ERR_004, 403);
			die();
		}
		parent::__construct();
	}


	/**
	 * Get all|one room(s)
	 *
	 * @param mixed | $params
	 */
	public function getRooms($params)
	{
		if($params[0])
		{
			$data = $this->roomsModels->getOneRoom($params[0]);
		}
		else
		{
			$data = $this->roomsModels->getAllRooms();
		}

		if(!empty($data))
		{
			View::sendData('success', $data, 200);
		}
		else
		{
			View::sendData('error', ERR_003, 400);
		}
		return true;
	}

	/**
	 * Create room
	 */
	public function postRooms()
	{
		if ($this->userRole === 'admin')
		{
			if($_POST['name'])
			{
				$params = $this->roomsModels->createRoom();
			}

			if (is_numeric($params))
			{
				$data = $this->roomsModels->getOneRoom($params);
				View::sendData('success', $data, 201);
			}
			else
			{
				View::sendData('error', ERR_006, 400);
			}
		}
		else
		{
			View::sendData('error', ERR_005, 403);
		}
		return true;
	}

	/**
	 * @param $params
	 * @param $data
	 * @return bool
	 */
	public function putRooms($params, $data)
	{
		if ($this->userRole === 'admin')
		{
			if($data['name'] && $params[0])
			{
				$countRow = $this->roomsModels->updateRoom($params[0], $data['name']);
			}

			if(0 < $countRow)
			{
				$data = $this->roomsModels->getAllRooms();
				View::sendData('success', $data, 200);
			}
			else
			{
				View::sendData('error', ERR_007, 400);
			}
		}
		else
		{
			View::sendData('error', ERR_005, 403);
		}
		return true;
	}

	/**
	 * @param bool $params
	 * @return bool
	 */
	public function deleteRooms($params)
	{
		if ($this->userRole === 'admin')
		{
			if($params[0])
			{
				$data = $this->roomsModels->deleteRoom($params[0]);
			}

			if($data)
			{
				View::sendData('message', SUCC_DEL_ROOM, 200);
			}
			else
			{
				View::sendData('error', ERR_008, 400);
			}
		}
		else
		{
			View::sendData('error', ERR_005, 403);
		}
		return true;
	}



}