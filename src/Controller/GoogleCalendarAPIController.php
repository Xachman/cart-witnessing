<?php


namespace App\Controller;


class GoogleCalendarAPIController extends AppController {
	private $calendarId = \Cake\Core\Configure::read('Google.calendarId');
	private $format = 'Y-m-d\TH:i:sP';

	public function updateEvents() {
		$client = $this->getClient();
		$service = new \Google_Service_Calendar($client);

		$this->loadModel("ScheduledLocations");
		$this->loadModel("Locations");
		$this->loadModel("Participants");
		$events = array();

		$startDate = new \DateTime(date("Y-m-d", strtotime("first day of next month")));
		$endDate = new \DateTime(date("Y-m-d", strtotime("last day of next month")));

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

	public function deleteAll() {

		$client = $this->getClient();
		$service = new \Google_Service_Calendar($client);

 		$events = $service->events->listEvents($this->calendarId);
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

	/**
	 *  * Returns an authorized API client.
	 *   * @return Google_Client the authorized client object
	 *    */
	private function getClient() {
		$credentialsPath = dirname(dirname(__DIR__))."/creds/calendar.json";
		$secretPath = dirname(dirname(__DIR__))."/creds/client_secret.json";
		$client = new \Google_Client();
		$client->setApplicationName("Public Witnessing");
		$client->setAuthConfig($secretPath);
		$client->setAccessType('offline');
		//	Load previously authorized credentials from a file.
		if (file_exists($credentialsPath)) {
			$accessToken = json_decode(file_get_contents($credentialsPath), true);
		} else {
			printf("File Not found  %s\n", $credentialsPath);
			die;
		}
		var_dump($accessToken);
		$client->setAccessToken($accessToken);

		// Refresh the token if it's expired.
		if ($client->isAccessTokenExpired()) {
			$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			$credsArray = $client->getAccessToken();
			$credsArray["refresh_token"] = $accessToken["refresh_token"];
			file_put_contents($credentialsPath, json_encode($credsArray));
		}
		return $client;
	}
}	
