<?php
/**
 * User 10: ruslan
 * Date: 21.09.18
 * Time: 14:11
 */

namespace libs\helpers;


class Validator
{
	/**
	 * Check token
	 * @param $token
	 * @return bool
	 */
	public static function checkToken($token)
	{
		return preg_match("/^[$0-9A-Za-z\=\.\\\]+$/", $token);
	}

	/**
	 * Check number
	 * @param $num
	 * @return bool
	 */
	public static function checkNumber($num)
	{
		return is_numeric($num);
	}

	/**
	 * Check string
	 * @param $str
	 * @return bool|string
	 */
	public static function checkValueString($str)
	{
		$str = trim($str);
		if(preg_match("/^[a-zA-Z0-9 _-]+$/",$str) && strlen($str) > 5)
		{
			return $str;
		}
		return false;
	}

	/**
	 * Check email
	 * @param $email
	 * @return false|int
	 */
	public static function checkEmail($email)
	{
		return preg_match("/^([a-z0-9_.-]+)@([0-9a-z_.-]+).([a-z]{2,6})$/", $email);
	}


	/**
	 * Check Date
	 * @param $day
	 */
	public static function checkDay($day)
	{
		if($day >0 && $day < 32)
		{
			return $day;
		}
		return false;
	}

	public static function checkMonth($month)
	{
		if($month > 0 && $month < 13)
		{
			return $month;
		}
		return false;
	}

	public static function checkYear($year)
	{
		if($year >2017 && $year < 2038)
		{
			return $year;
		}
		return false;
	}
}