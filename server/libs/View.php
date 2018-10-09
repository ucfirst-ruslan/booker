<?php
/**
 * User 10: ruslan
 */


namespace libs;


class View
{
	public static function sendData($status, $data, $code)
	{
		self::prepareCode($code);
		self::prepareData($status, $data);

		return true;
	}


	private static function prepareCode($code)
	{
		$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

		switch($code)
		{
			case '200':
				header($protocol." 200 OK");
				break;
			case '201':
				header($protocol." 201 Created");
				break;
			case '202':
				header($protocol." 202 Accepted");
				break;
			case '204':
				header($protocol." 204 No Content");
				break;
			case '400':
				header($protocol." 400 Bad Request");
				break;
			case '401':
				header($protocol." 401 Unauthorized");
				break;
			case '403':
				header($protocol." 403 Forbidden");
				break;
			case '404':
				header($protocol." 404 Not Found");
				break;
			case '406':
				header($protocol." 406 Not Acceptable");
				break;
			case '500':
				header($protocol." 500 Internal Server Error");
				break;
			default:
				break;
		}
	}

	private static function prepareData($status, $data)
	{
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
			header("Content-Type: application/json");
			echo json_encode(array($status => $data));
	}


}