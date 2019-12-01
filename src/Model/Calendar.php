<?php
namespace App\Model;
use Cake\ORM\TableRegistry;


class Calendar {
    private $Locations;
    private $ParticipantAvailability;
    private $Participants;

    public function __construct() {
        $this->Locations = TableRegistry::get('Locations');
        $this->ParticipantAvailability = TableRegistry::get('ParticipantsAvailability');
        $this->Participants = TableRegistry::get('Participants');
    }

    public function mapParticipantsMonth($startDateStr, $endDateStr) {
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
    }

    public function getCalendarData($startDateStr = "", $endDateStr = "" ) {

        $this->ScheduledLocations = TableRegistry::get('ScheduledLocations');
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

	private function getDayData($date, $scheduledLocations) {

		$locations = $this->Locations->find("all", array(
					"conditions" => array("day" => $date->format("w"))
					))->order(['start_time' => 'ASC']);

		$return = array();
		foreach($scheduledLocations as $schedLoc) {
			if($date->format("Y/m/d") == $schedLoc->schedule_date->format("Y/m/d")) {
				$participant = $this->Participants->get($schedLoc->participant_id);
				$return["scheduled_locations"][] = array(
						"participant" 	=> $participant->first_name." ".$participant->last_name,
						"start_time" 	 => $schedLoc->start_time,
						"end_time"      => $schedLoc->end_time,
						"id"        	=> $schedLoc->id,
						"location_id"  => $schedLoc->location_id,
						'participant_id' => $participant->id
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