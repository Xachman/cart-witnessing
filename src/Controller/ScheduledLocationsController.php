<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * ScheduledLocations Controller
 *
 * @property \App\Model\Table\ScheduledLocationsTable $ScheduledLocations
 */
class ScheduledLocationsController extends AppController
{
    public function beforeFilter(Event $event)
    {
        // allow only login, forgotpassword
         $this->Auth->allow(['selfAdd', 'selfDelete']);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
	    $this->paginate = [
            'contain' => ['Locations', 'Participants']
        ];
        $scheduledLocations = $this->paginate($this->ScheduledLocations);

		$participants = array();
		$participantsQuery = $this->ScheduledLocations->Participants->find('all');
		foreach($participantsQuery as $participant){
			$participants[$participant->id] = $participant->first_name;
		}
        $this->set(compact('scheduledLocations', 'participants'));
        $this->set('_serialize', ['scheduledLocations']);
    }

    /**
     * View method
     *
     * @param string|null $id Scheduled Location id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $scheduledLocation = $this->ScheduledLocations->get($id, [
            'contain' => ['Locations', 'Participants']
        ]);

        $this->set('scheduledLocation', $scheduledLocation);
        $this->set('_serialize', ['scheduledLocation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($locationId = "", $selectedDate = "", $participantId = false)
	{
		$queryAction = $this->request->getQuery("action");
		$queryController = $this->request->getQuery("controller");
        $scheduledLocation = $this->ScheduledLocations->newEntity();
        if ($this->request->is('post')) {
            $data = (array) $this->request->getData();
            if($participantId) {
                $data['participant_id'] = $participantId;
            }
            $scheduledLocation = $this->ScheduledLocations->patchEntity($scheduledLocation, $data);
            if ($this->ScheduledLocations->save($scheduledLocation)) {
                $this->Flash->success(__('The scheduled location has been saved.'));
				if($queryAction && $queryController) {
					return $this->redirect(["controller" => $queryController, "action" => $queryAction, $selectedDate]);
				}else{
                	return $this->redirect(['action' => 'index']);
				}
            } else {
                $this->Flash->error(__('The scheduled location could not be saved. Please, try again.'));
            }
        }
        $locations = array();
        $days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
        foreach($this->ScheduledLocations->Locations->find('all') as $location) {
            $locations[$location->id] = $location->name .' - '. $days[$location->day];
        }
        $participants = array();
        foreach($this->ScheduledLocations->getAvailableParticipants($locationId, $selectedDate) as $participant) {
            $participants[$participant->id] =  $participant->first_name . ' ' .$participant->last_name;
        }
        if((int) $locationId) {
            $selectedLocation = $this->ScheduledLocations->Locations->get($locationId);
        }
        $this->set(compact('scheduledLocation', 'locations', 'participants','locationId', 'selectedDate', 'selectedLocation'));
        $this->set('_serialize', ['scheduledLocation']);
    }
    public function selfAdd($locationId, $selectedDate) {
        $session = $this->request->getSession();
		if ($this->request->is('post')) {
		    $participantId = $session->read('self_checkout_paricipant_id');
			if (!$participantId) {
                $this->Flash->error('No ID');
                return $this->redirect(['controller' => 'Calendar', 'action' => 'selfSchedule']);
            }
            $this->add($locationId, $selectedDate, $participantId);
        }
        return $this->redirect(['controller' => 'Calendar', 'action' => 'selfSchedule']);

    }
    public function selfDelete($id, $date) {
        $session = $this->request->getSession();
		if ($this->request->is('post')) {
		    $participantId = $session->read('self_checkout_paricipant_id');
			if (!$participantId) {
                $this->Flash->error('No ID');
                return $this->redirect(['controller' => 'Calendar', 'action' => 'selfSchedule']);
            }
            $this->delete($id, $date);
        }
        return $this->redirect(['controller' => 'Calendar', 'action' => 'selfSchedule']);
    }
    /**
     * Edit method
     *
     * @param string|null $id Scheduled Location id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $scheduledLocation = $this->ScheduledLocations->get($id, [
            'contain' => []
        ]);
		$queryAction = $this->request->getQuery("action");
		$queryController = $this->request->getQuery("controller");
        if ($this->request->is(['patch', 'post', 'put'])) {
            $scheduledLocation = $this->ScheduledLocations->patchEntity($scheduledLocation, $this->request->data);
            if ($this->ScheduledLocations->save($scheduledLocation)) {
                $this->Flash->success(__('The scheduled location has been saved.'));
				$date = $scheduledLocation->schedule_date->format("Y-m-d");
				if($queryAction && $queryController && $date) {
					return $this->redirect(["controller" => $queryController, "action" => $queryAction, $date]);
				}else{
                	return $this->redirect(['action' => 'index']);
				}
            } else {
                $this->Flash->error(__('The scheduled location could not be saved. Please, try again.'));
            }
        }
        $locations = array();
        $days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
        foreach($this->ScheduledLocations->Locations->find('all') as $location) {
            $locations[$location->id] = $location->name .' - '. $days[$location->day];
        }
        $participants = array();
        foreach($this->ScheduledLocations->Participants->find('all') as $participant) {
            $participants[$participant->id] =  $participant->first_name . ' ' .$participant->last_name;
        }
        $this->set(compact('scheduledLocation', 'locations', 'participants'));
        $this->set('_serialize', ['scheduledLocation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Scheduled Location id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $date = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $scheduledLocation = $this->ScheduledLocations->get($id);
        if ($this->ScheduledLocations->delete($scheduledLocation)) {
            $this->Flash->success(__('The scheduled location has been deleted.'));
        } else {
            $this->Flash->error(__('The scheduled location could not be deleted. Please, try again.'));
        }

		$queryAction = $this->request->getQuery("action");
		$queryController = $this->request->getQuery("controller");
        if(isset($queryAction) && isset($queryController)) {
            return $this->redirect(["controller" => $queryController, "action" => $queryAction, $date]);
        }        

        return $this->redirect(['action' => 'index']);
	}
	
}
