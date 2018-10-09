<?php
/**
 * User 10: ruslan
 */

namespace api\auth;

use libs\Rest;
use libs\models\authModels;
use libs\View;


class Auth extends Rest
{
	private  $authModels;

	public function getAuth()
	{
		$this->authModels = new authModels();
	}


	/**
	 * Login|change method
	 *
	 * @param $params
	 * @param $data
	 */
	protected function putAuth($params, $data)
	{
		if($data['email'] && $data['pass'])
		{
			$result = $this->authModels->loginUser($data['email'], $data['pass']);

			if($result)
			{
				View::sendData('success', SUCC_DEL_ROOM, 200);
				return true;
			}
		}
		View::sendData('error', ERR_004, 403);
	}


	protected function deleteAuth($params)
	{
		$this->authModels->logOutUser($params[0]);
		View::sendData('success', ERR_009, 403);
	}


}