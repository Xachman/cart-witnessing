<?php


namespace App\Controller;

use App\Model\GoogleCalendar;

class GoogleCalendarAPIController extends AppController {
	private $format = 'Y-m-d\TH:i:sP';
	private $GoogleCalendar;


	public function initialize() {
		parent::initialize();
		$this->GoogleCalendar = new GoogleCalendar;		
	}

	public function updateEvents($month = false, $year = false) {
		if(!$year) {
			$year = date("Y");
		}
		if(!$month) {
			echo "Please enter a month 1 - 12";
			die;
		}

		$client = $this->getClient();
		$service = new \Google_Service_Calendar($client);

		$this->loadModel("ScheduledLocations");
		$this->loadModel("Locations");
		$this->loadModel("Participants");
		$events = array();

		$createString = $month."-".$year."-1";
		$startDate = \DateTime::createFromFormat("m-Y-d", $createString);
		$endDate = \DateTime::createFromFormat("m-Y-d", $createString);


		$startDate->modify("first day of this month");
		$endDate->modify("last day of this month");

		var_dump($startDate->format("Y-m-d"));
		var_dump($endDate->format("Y-m-d"));
		
		//$startDate = new \DateTime(date("Y-m-d", strtotime("last day of this month")));
		//$endDate = new \DateTime(date("Y-m-d", strtotime("last day of this month")));
		$scheduledLocations = $this->ScheduledLocations->find('all', array(
					'conditions' => array('ScheduledLocations.schedule_date >= ' => $startDate->format("Y/m/d"),
						'ScheduledLocations.schedule_date <= ' => $endDate->format("Y/m/d")
						),
					));
		foreach($scheduledLocations as $scheduledLocation) {
			$participant = $this->Participants->get($scheduledLocation->participant_id);
			$location = $this->Locations->get($scheduledLocation->location_id);
			$startTime = new \DateTime($scheduledLocation->schedule_date->format("Y-m-d")." ".$scheduledLocation->start_time->format("H:i:s"),  new \DateTimeZone('America/New_York'));
			
			$endTime = new \DateTime($scheduledLocation->schedule_date->format("Y-m-d")." ".$scheduledLocation->end_time->format("H:i:s"),  new \DateTimeZone('America/New_York'));
			$eventDetails = array(
				"summary" => $participant->first_name." ".$participant->last_name,
				"location" => $location->name,
				"description" => "",
				"start" => array(
					"dateTime" => $startTime->format($this->format),
					"timeZone" => "America/New_York",
				),
				"end" => array(
					"dateTime" => $endTime->format($this->format),
					"timeZone" => "America/New_York",
				),
			);
			$events[] = $eventDetails;
		}
		echo "<pre>";
		var_dump($events);
		echo "</pre>";
		foreach($events as $eventData) {
			$gscEvent = new \Google_Service_Calendar_Event($eventData);
			$event = $service->events->insert($this->calendarId, $gscEvent);
			printf('Event created: %s\n', $event->htmlLink);
    	}
		die;	
	}

	public function deleteEvents($month = false, $year = false) {
		if(!$year) {
			$year = date("Y");
		}
		if(!$month) {
			echo "Please enter a month 1 - 12";
			die;
		}
		$client = $this->getClient();
		$service = new \Google_Service_Calendar($client);

		$startTime = \DateTime::createFromFormat("m-Y", $month."-".$year);
		$endTime = \DateTime::createFromFormat("m-Y", $month."-".$year);

		$startTime->modify("first day of this month");
		$endTime->modify("first day of next month");
		
		$options = [
			"timeMax" => $endTime->format($this->format),
			"timeMin" => $startTime->format($this->format)
		];
 		$events = $service->events->listEvents($this->calendarId, $options);
		echo "<pre>";
		var_dump($events->getItems());
		echo "</pre>";
			// var_dump($event->getSummary());
			// $service->events->delete($this->calendarId, $event->getId());
			while(true) {
			  foreach ($events->getItems() as $event) {
				echo $event->getSummary();
				echo "<br>";
				$service->events->delete($this->calendarId, $event->getId());
			  }
			  $pageToken = $events->getNextPageToken();
				var_dump($pageToken);
			  if ($pageToken) {
				$optParams = array('pageToken' => $pageToken);
				$events = $service->events->listEvents($this->calendarId, $optParams);
			  } else {
				break;
			  }
			}
		die;
	}

	public function addScheduledEvent($id) {
		$this->GoogleCalendar->addScheduledEvent($id);
		die;
	}

	private function getClient() {
		return $this->GoogleCalendar->getClient();
	}
}	
