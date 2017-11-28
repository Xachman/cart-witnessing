<?php
namespace App\Model;
use Cake\ORM\TableRegistry;


class Calendar {
    private $Locations;
    private $ParticipantAvailability;
    private $Participants;

    public function __construct() {
        $this->Locations = TableRegistry::get('LocationsTable');
        $this->ParticipantAvailability = TableRegistry::get('ParticipantsAvailabilityTable');
        $this->Participants = TableRegistry::get('ParticipantsTable');
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
}