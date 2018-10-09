<?php
/**
 * User 10: ruslan
 */

namespace api\events;


use libs\Rest;
use libs\authService;
use libs\View;
use libs\models\eventsModels;
use libs\helpers\Validator;

class Events extends Rest
{
	private $eventsModels;
	private $userRole;

	private $startDate;
	private $endDate;

	public function __construct()
	{
		$auth = new authService();
		$this->userRole = $auth->getUserRole();

		if($this->userRole && AUTH)
		{
			View::sendData('error', ERR_004, 403);
			die();
		}
		$this->eventsModels = new eventsModels();
		parent::__construct();
	}


	/**
	 * Get Event(s)
	 * @param $params
	 * @return bool
	 */
	public function getEvents($params)
	{
		if (Validator::checkNumber($params[0]))
		{
			$data = $this->eventsModels->getManager($params);
		}
		else
		{
			View::sendData('error', ERR_015, 400);
		}

		if ($data)
		{
			View::sendData('success', $data, 200);
		}
		else
		{
			View::sendData('error', ERR_015, 400);
		}
		return true;
	}


	public function postEvents()
	{

	}



	public function putEvents()
	{

	}


	public function deleteEvents()
	{

	}


}