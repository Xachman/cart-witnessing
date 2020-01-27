<?php
namespace App\Model;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\View\Helper\UrlHelper;
use Cake\View\View;

class Calendar {
    private $Locations;
    private $ParticipantAvailability;
    private $Participants;

    public function __construct() {
        $this->Locations = TableRegistry::get('Locations');
        $this->ParticipantAvailability = TableRegistry::get('ParticipantsAvailability');
        $this->Participants = TableRegistry::get('Participants');
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
        $oddWeek = $date->format("W") % 2;
        $conditions = [
            "day" => $date->format("w"), 
            'hidden' => 0, 
        ];

        if($oddWeek) {
            $conditions['OR'] = [
                ['every_other_week' => 0],
                ['every_other_week' => 1]
            ];
        }else{
            $conditions['every_other_week'] = 0;
        }
		$locations = $this->Locations->find("all", array(
					"conditions" => $conditions
					))->order(['start_time' => 'ASC']);
      //  debug($locations);
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
    
    public function getFullCalendarData($startDateStr = "", $endDateStr = "", $participant) {
        $lastViewDate = new \DateTime();
        $lastViewDate->setTimestamp(\strtotime("+30 days"));
        $endDate = new \DateTime($endDateStr);
        if($lastViewDate->getTimestamp() < $endDate->getTimestamp()) {
            $data = $this->getCalendarData($startDateStr, $lastViewDate->format("Y-m-d"));
        } else {
            $data = $this->getCalendarData($startDateStr, $endDateStr);
        }

        $results = [];
        $urlHelper = new UrlHelper(new View);
        foreach($data as $date => $value ) {
            if(!isset($value['locations']))
                continue;
            foreach($value['locations'] as $location) {
                $result = [
                    "title" => $location->name,
                    "start" => $this->keyDateStrToDateStr($date)."T". $location->start_time->format("H:i:s"),
                    "end" => $this->keyDateStrToDateStr($date)."T". $location->end_time->format("H:i:s")
                ];
                $result['scheduled'] = false;
                $result['location_name'] = $location->name;
                $result['location_id'] = $location->id;
                $result['url'] = $urlHelper->build([
                    "controller" => "ScheduledLocations",
                    "action" => "selfAdd",
                    $location->id,
                    $this->keyDateStrToDateStr($date)
                ]);
                if(!isset($value['scheduled_locations'])) {
                    $results[] = $result;
                    continue;
                }
                foreach($value['scheduled_locations'] as $schedLoc) {
                    if($schedLoc['location_id'] == $location->id) {
                        $result['title'] .= "\n".$schedLoc['participant'];
                        if($participant->id == $schedLoc['participant_id']) {
                            $result['scheduled'] = true;
                            $result['backgroundColor'] = 'green';
                            $result['url'] = $urlHelper->build([
                                "controller" => "ScheduledLocations",
                                "action" => "selfDelete",
                                $schedLoc['id'],
                                $this->keyDateStrToDateStr($date)
                            ]);
                        }
                    }
                }
                $results[] = $result;
            }
        }
        

        return $results;

    }

    private function searchResultForUnique($result) {

    }

    private function keyDateStrToDateStr($keyDateStr) {
        $dateSplit = explode("_", $keyDateStr);
        return $dateSplit[0]."-".$dateSplit[1]."-".$dateSplit[2];
    }
}