<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ParticipantAvailability Controller
 *
 * @property \App\Model\Table\ParticipantAvailabilityTable $ParticipantAvailability
 */
class ParticipantAvailabilityController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Participants']
		];
		$urlQuery = $this->request->query("day");

		$participantsQuery = $this->ParticipantAvailability;

		if($urlQuery !=  null) {
			$participantsQuery = $this->ParticipantAvailability->find('all')->where(['day' => $urlQuery]);
		}
       
		$participantAvailability = $this->paginate($participantsQuery);

        $participantsQuery = $this->ParticipantAvailability->Participants->find("all");
        $participants = array();
        foreach($participantsQuery as $participant) {
            $participants[$participant->id] = $participant->first_name;
        }
        $this->set(compact('participantAvailability', 'participants'));
        $this->set('_serialize', ['participantAvailability']);
    }

    /**
     * View method
     *
     * @param string|null $id Participant Availability id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $participantAvailability = $this->ParticipantAvailability->get($id, [
            'contain' => ['Locations', 'Participants']
        ]);

        $this->set('participantAvailability', $participantAvailability);
        $this->set('_serialize', ['participantAvailability']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $participantAvailability = $this->ParticipantAvailability->newEntity();
        if ($this->request->is('post')) {
            $participantAvailability = $this->ParticipantAvailability->patchEntity($participantAvailability, $this->request->data);
            if ($this->ParticipantAvailability->save($participantAvailability)) {
                $this->Flash->success(__('The participant availability has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The participant availability could not be saved. Please, try again.'));
            }
        }
        $days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
        $participants = array();
        $participantsQuery = $this->ParticipantAvailability->Participants->find('all', array(
            "order" => "Participants.first_name"
        ));
        foreach($participantsQuery as $participant) {
            $participants[$participant->id] =  $participant->first_name . ' ' .$participant->last_name;
        }
        $this->set(compact('participantAvailability', 'days', 'participants'));
        $this->set('_serialize', ['participantAvailability']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Participant Availability id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $participantAvailability = $this->ParticipantAvailability->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $participantAvailability = $this->ParticipantAvailability->patchEntity($participantAvailability, $this->request->data);
            if ($this->ParticipantAvailability->save($participantAvailability)) {
                $this->Flash->success(__('The participant availability has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The participant availability could not be saved. Please, try again.'));
            }
        }
        $days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
        $participants = array();
        $participantsQuery = $this->ParticipantAvailability->Participants->find('all', array(
            "order" => "Participants.first_name"
        ));
        foreach($participantsQuery as $participant) {
            $participants[$participant->id] =  $participant->first_name . ' ' .$participant->last_name;
        }
        $this->set(compact('participantAvailability', 'days', 'participants'));
        $this->set('_serialize', ['participantAvailability']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Participant Availability id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $participantAvailability = $this->ParticipantAvailability->get($id);
        if ($this->ParticipantAvailability->delete($participantAvailability)) {
            $this->Flash->success(__('The participant availability has been deleted.'));
        } else {
            $this->Flash->error(__('The participant availability could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
