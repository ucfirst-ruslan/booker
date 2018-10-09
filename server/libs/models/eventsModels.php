<?php
/**
 * User 10: ruslan
 */

namespace libs\models;

use libs\sql\DBService;
use libs\helpers\Validator;


class eventsModels
{
	public $db;
	private $startDate;
	private $endDate;
	private $room;

	public function __construct()
	{
		$this->db = new DBService();
	}


	public function getManager($params)
	{
		$this->room = $params[0];
		if($params[1])
		{
			$typeReq = substr_count($params[1], '-') + 1;

			switch ($typeReq) {
				case 1:
					$data = $this->getEvent($params[1]);
					break;
				case 2:
					$data = $this->getMonth($params[1]);
					break;
				case 3:
					$data = $this->getDay($params[1]); // Резерв
					break;
			}
		}
		else
		{
			$data = $this->getCurMonth();
		}

		return $data;
	}

	/**
	 * Get event detail
	 * @param $id
	 * @return array|bool
	 */
	public function getEvent($id)
	{
		$id = Validator::checkNumber($id);
		if ($id)
		{
			$sql = 'SELECT e.id, id_rec, notes, e.id_user as user_ev, 
					u.username as user, us.username as user_from, start_time, 
					end_time, create_time, r.id as id_room, r.name as room_name
					FROM bk_events as e
					LEFT JOIN bk_rooms AS r ON e.id_room = r.id
					LEFT JOIN bk_users AS u ON e.id_user = u.id
					LEFT JOIN bk_users AS us ON e.id_from_user = us.id
					where e.id = :id';
			return $this->db->select($sql, array(':id' => $id));
		}
		return false;
	}


	/**
	 * Get events for the day (резерв)
	 *
	 * @param $id
	 * @return array|bool
	 */
	public function getDay($id)
	{
		$date = explode('-', $id);

		$year = Validator::checkYear($date[0]);
		$month = Validator::checkMonth($date[1]);
		$day = Validator::checkDay($date[2]);

		if($year && $month && $day)
		{
			$this->startDate = mktime(0, 0, 0, $month, $day, $year);
			$this->endDate = mktime(23, 59, 59, $month, $day, $year);

			$sql = 'SELECT e.id, id_rec, notes, e.id_user as user_ev, 
				u.username as user, us.username as user_from, 
				start_time, end_time, create_time, r.name as room_name
				FROM bk_events as e
				LEFT JOIN bk_rooms AS r ON e.id_room = r.id
				LEFT JOIN bk_users AS u ON e.id_user = u.id
				LEFT JOIN bk_users AS us ON e.id_from_user = us.id
 				WHERE `start_time` >= :startDate AND `start_time` <= :endDate' ;
			return $this->db->select($sql, array(':startDate' => $this->startDate,
			                                     ':endDate' => $this->endDate));
		}
		return false;
	}


	/**
	 * Get events for the month
	 * @param $id
	 */
	public function getMonth($id)
	{
		$date = explode('-', $id);

		$year = Validator::checkYear($date[0]);
		$month = Validator::checkMonth($date[1]);

		if($year && $month)
		{
			$this->startDate = mktime(0, 0, 0, $month, 1, $year);

			$month++;
			if ($month == 13) {
				$year++;
				$month = 1;
			}
			$this->endDate = mktime(23, 59, 59, $month, 0, $year);

			return $this->getDataEvents();
		}
		return false;
	}


	/**
	 * Get events for the current month
	 * @return array
	 */
	public function getCurMonth()
	{
		$this->startDate = strtotime(date("Y-m-01"));
		$this->endDate = strtotime(date("Y-m-t" )) + 86399;


		return $this->getDataEvents();
	}


	/**
	 * SQL query for event(s)
	 * @return array
	 */
	public function getDataEvents()
	{ // TODO изменить запрос в зависимости от требуемых данных во фронте
		$sql = 'SELECT e.id, id_rec, notes, e.id_user as user_ev, 
				u.username as user, us.username as user_from, 
				start_time, end_time, create_time, r.name as room_name
				FROM bk_events as e
				LEFT JOIN bk_rooms AS r ON e.id_room = r.id
				LEFT JOIN bk_users AS u ON e.id_user = u.id
				LEFT JOIN bk_users AS us ON e.id_from_user = us.id
 				WHERE `start_time` >= :startDate AND `start_time` <= :endDate AND e.id_room = :room' ;
		return $this->db->select($sql, array(':startDate' => $this->startDate,
		                                     ':endDate' => $this->endDate,
		                                     ':room' => $this->room));
	}




}