<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
/* @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Calendar;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class CalendarController extends AppController
{
	private $Calendar;

	public function initialize() {
		$this->Calendar = new Calendar();		
	}
	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index()
	{
		$this->month();	
		$this->render("month");
	}


	public function week($dateString = "")
	{
		$date = new \DateTime($dateString);
		var_dump($date);
		$dateMap = $this->getCalendarData($date->format("Y/m/1"), $date->format("Y/m/t"));
		$this->set(compact('dateMap'));

	}

	public function month($dateString = "") {
		$date = new \DateTime($dateString);
		$date->setDate($date->format("Y"), $date->format("m"), 1);
		$title = $date->format("F - Y");
		$calendarData = array();
		$startDate = new \DateTime(date("Y/m/d", strtotime("-".$date->format("w")." days", strtotime($date->format("Y/m/1")))));
		$date->setDate($date->format("Y"), $date->format("m"), $date->format("t"));
		$endDate = new \DateTime(date("Y/m/d", strtotime("+".(6-$date->format("w"))." days", strtotime($date->format("Y/m/d")))));
		$dateMap = $this->getCalendarData($startDate->format("Y/m/d"), $endDate->format("Y/m/d"));

		$calendarData['title'] = $title;
		$calendarData['dateMap'] = $dateMap;
		$this->set(compact('calendarData'));

	} 

	public function staticViews($view = "month", $dateString = "") {
		$this->viewBuilder()->layout("print");
		switch($view) {
			default:
				$this->month($dateString);
				$this->render("static-month");
		}
	}

	public function generate($dateString = "") {
		$date = new \DateTime($dateString);
		$date->setDate($date->format("Y"), $date->format("m"), 1);
		$title = $date->format("F - Y");
		$calendarData = array();
		$startDate = new \DateTime(date("Y/m/d", strtotime("-".$date->format("w")." days", strtotime($date->format("Y/m/1")))));
		$date->setDate($date->format("Y"), $date->format("m"), $date->format("t"));
		$endDate = new \DateTime(date("Y/m/d", strtotime("+".(6-$date->format("w"))." days", strtotime($date->format("Y/m/d")))));
		$dateMap = $this->generateCalendarData($startDate->format("Y/m/d"), $endDate->format("Y/m/d"));

		$calendarData['title'] = $title;
		$calendarData['dateMap'] = $dateMap;
		$this->set(compact('calendarData'));
	}

	private function getCalendarData($startDateStr = "", $endDateStr = "" ) {

		$this->loadModel("ScheduledLocations");

		$startDate = new \DateTime($startDateStr);
		$endDate = new \DateTime($endDateStr);
		$incDate = new \DateTime($startDate->format("Y/m/d"));

		$scheduledLocations = $this->ScheduledLocations->getRange( $startDate, $endDate);
		$scheduledLocationsCount = 	$this->ScheduledLocations->getParticipantsInRange($startDate, $endDate);	//var_dump($scheduledLocationsCount);
		$dateMap = array();
		while($incDate->getTimestamp() <= $endDate->getTimestamp()) {

			$dateMap[$incDate->format("Y_m_d")] = $this->getDayData($incDate, $scheduledLocations);
			$incDate->setDate($incDate->format("Y"), $incDate->format("m"), $incDate->format("d") +1);
		}

		return $dateMap;
	}
	private function generateCalendarData($startDateStr = "", $endDateStr = "" ) {
		$count = 0;
		$data = [];
		$this->Calendar->itterateLocations($startDateStr, $endDateStr, function($date, $locations) use (&$count) {
			$count++;
			foreach($locations as $location) {
				$data = $this->compileScheduledLocations($location);
			}
		});	
	}

	private function getTimes($location) {
		$totalTime =  $location->end_time->format('U') - $location->start_time->format('U');
		$times = [];
		if($totalTime > 10800) {
			$times = [
				[
					'start_time' => new \DateTime('@'.$location->start_time->format('U')), 
					'end_time' => new \DateTime('@'.($location->start_time->format('U') + ($totalTime / 2)))
				],
				[
					'start_time' => new \DateTime('@'.($location->end_time->format('U') - $totalTime / 2)), 
					'end_time' => new \DateTime('@'.$location->end_time->format('U') ) 
				],
			];
			return $times;
		}

		return [
			[
				'start_time' => new \DateTime('@'.$location->start_time->format('U')),
				'end_time' => new \DateTime('@'.$location->end_time->format('U'))
			]
		];
	}

	private function getAvailibleParticipants($day) {
		$participantAvail = $this->loadModel('ParticipantAvailability');
		$participants = $this->loadModel('Participants');
		$pAQuery = $participantAvail->find('all', [
			'conditions' => [
				'day' => $day,
			]
		])->select('ParticipantAvailability.participant_id');
		$ids = [];

		foreach($pAQuery as $pa) {
			$ids[] = $pa->participant_id;
		}
		$participantsQuery = $participants->find('all')
		->where(['id IN' => $ids]);

		return $participantsQuery;
	}

	private compileScheduledLocations($location) {
		$times = $this->getTimes($location);
		$scheduledLocations = [];
		$participants = $this->getAvailibleParticipants($location->day);
		foreach($times) {
			$optionalParticipant = [];
			foreach($participants as $participant) {
				if($times->start_time->format('U') >= $participant->)	
			}
		}
	}

	private getParticipants
	private function getLocationsByDate($dateString) {
		$locations = $this->Locations->find("all");
		$targetDate = new \DateTime($dateString);
		$return = array();
		foreach($locations as $location) {
			if($targetDate->format("Y/m/d") == $location["start_time"]->format("Y/m/d")) {
				$return[] = $location;
			}
		}
		return $return;
	}

	private function getDayData($date, $scheduledLocations) {

		$this->loadModel("Participants");
		$this->loadModel("Locations");
		$locations = $this->Locations->find("all", array(
					"conditions" => array("day" => $date->format("w"))
					));

		$return = array();
		foreach($scheduledLocations as $schedLoc) {
			if($date->format("Y/m/d") == $schedLoc->schedule_date->format("Y/m/d")) {
				$participant = $this->Participants->get($schedLoc->participant_id);
				$return["scheduled_locations"][] = array(
						"participant" 	=> $participant->first_name." ".$participant->last_name,
						"start_time" 	 => $schedLoc->start_time,
						"end_time"      => $schedLoc->end_time,
						"id"        	=> $schedLoc->id,
						"location_id"  => $schedLoc->location_id
						//	"locations" 	=> $this->getLocationsByDate($schedLoc->start_date)
						);

			}
		}
		foreach($locations as $location) {
			$return["locations"][] = $location; 
		}

		return $return;

	}




}
