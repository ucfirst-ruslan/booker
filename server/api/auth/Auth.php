<?php
/**
 * User 10: ruslan
 * Date: 20.09.18
 * Time: 15:12
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
	 * @param $id
	 * @param $data
	 */
	protected function putAuth($id, $data)
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


	protected function deleteAuth($id)
	{
		$this->authModels->logOutUser($id[0]);
		View::sendData('success', ERR_009, 403);
	}


}