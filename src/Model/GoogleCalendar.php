<?php

namespace App\Model;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class GoogleCalendar {
	private $format = 'Y-m-d\TH:i:sP';

    public function __construct() {
        $this->Locations = TableRegistry::get('Locations');
        $this->Participants = TableRegistry::get('Participants');
        $this->ScheduledLocations = TableRegistry::get('ScheduledLocations');
        $this->calendarId = Configure::read('calendarId');
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
	//	var_dump($accessToken);
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

	public function addScheduledEvent($id) {
		$client = $this->getClient();
		$service = new \Google_Service_Calendar($client);
		

		$scheduledLocation = $this->ScheduledLocations->get($id);

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

		$gscEvent = new \Google_Service_Calendar_Event($eventDetails);
		$event = $service->events->insert($this->calendarId, $gscEvent);
		return $event->id;
	}

	public function deleteScheduledEvent($id) {
		$client = $this->getClient();
		$service = new \Google_Service_Calendar($client);
		

		$scheduledLocation = $this->ScheduledLocations->get($id);

		$service->events->delete($this->calendarId, $scheduledLocation->google_calendar_id);
	}

}