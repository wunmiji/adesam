<?php

namespace App\Libraries;

use App\Libraries\HttpLibrary;


/**
 * 
 */
class DateLibrary
{

	//'Y-m-d\\TH:i:s.vp'

	public function getDateTime()
	{
		try {
			$httpLibrary = new HttpLibrary();

			$url = 'http://worldtimeapi.org/api/ip';

			$body = $httpLibrary->retrieve($url);
			return json_decode($body->getContents());
		} catch (\Throwable $exception) {
			\Sentry\captureException($exception);
		}
	}

	public function getUtc(): string
	{
		$utc = new \DateTime('now', new \DateTimeZone('UTC'));
		return $utc->format('Y-m-d\\TH:i:s.vp');
	}

	public static function getZoneDateTime()
	{
		// date_default_timezone_get() is set in BaseController
		$utc = new \DateTime('now', new \DateTimeZone(date_default_timezone_get()));
		return $utc->format('Y-m-d\\TH:i:s.vp');
	}

	public static function getCurrentDate()
	{
		// date_default_timezone_get() is set in BaseController
		$utc = new \DateTime('now');
		return $utc->format('Y-m-d');
	}

	public static function getDateYjd($date)
	{
		$dateCreate = date_create($date);
		return date_format($dateCreate, "Y-n-d");
	}

	public static function getCurrentDateYjd()
	{
		// date_default_timezone_get() is set in BaseController
		$utc = new \DateTime('now');
		return $utc->format('Y-n-d');
	}

	public static function getFormat($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('l, d F Y H:i A');
		}
	}

	public static function formatTimestamp($timestamp)
	{
		if (!is_null($timestamp)) {
			$dateTime = new \DateTime();
			$dateTime->setTimestamp($timestamp);
			return $dateTime->format('l, d F Y H:i A');
		}
	}

	public static function formatTime($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('H:i A');
		}

	}

	public static function toTimestamp($utc)
	{
		if (!is_null($utc)) {
			return strtotime($utc);
		}
	}

	public static function getDate($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('l, d F Y');
		}

	}

	public static function getMysqlDate($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('Y-m-d');
		}

	}

	public static function getMysqlTime($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('H:i:s');
		}

	}

	public static function setDate(int $year, int $month, int $day)
	{
		$date = new \DateTime();
		$date->setDate($year, $month, $day);
		return $date->format('Y-m-d');
	}

	public static function getYear($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('Y');
		}

	}

	public static function getMonthNumber($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('n');
		}
	}

	public static function getDayNumber($utc)
	{
		if (!is_null($utc)) {
			$dateTime = new \DateTime($utc);
			return $dateTime->format('d');
		}
	}

	public static function getCurrentYear()
	{
		return date("Y");

	}

	public static function getCurrentMonthNumber()
	{
		return date("n");

	}

	public static function getCurrentDayNumber()
	{
		return date("d");

	}

}