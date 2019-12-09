<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
/**
 * Emails Controller
 *
 * @property \App\Model\Table\EmailsTable $Emails
 */
class EmailsController extends AppController {

    private $shortcodes = array();
    public function __construct(\Cake\Network\Request $request = null, \Cake\Network\Response $response = null, $name = null, $eventManager = null, $components = null) {
        parent::__construct($request, $response, $name, $eventManager, $components);

        $this->addShortcode("title", array($this, "getParticipantTitle"));
        $this->addShortcode("name", array($this, "getParticipantName"));
        $this->addShortcode("schedule", array($this, "getSchedule"));
        $this->addShortcode("month", array($this, "getMonth"));
        $this->addShortcode("participant_schedule", array($this, "participantSchedule"));
        $this->addShortcode("name", array($this, "getFullName"));

        $this->loadModel('Participants');
        $this->loadModel('ScheduledLocations');
        $this->loadModel('Locations');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $emails = $this->paginate($this->Emails);

        $this->set(compact('emails'));
        $this->set('_serialize', ['emails']);
    }

    /**
     * View method
     *
     * @param string|null $id Email id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $email = $this->Emails->get($id, [
            'contain' => ['EmailAttachments']
        ]);

        $this->set('email', $email);
        $this->set('_serialize', ['email']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $email = $this->Emails->newEntity();
        if ($this->request->is('post')) {
            $email = $this->Emails->patchEntity($email, $this->request->data);
            if ($this->Emails->save($email)) {
                $this->Flash->success(__('The email has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The email could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('email'));
        $this->set('_serialize', ['email']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Email id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $email = $this->Emails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $email = $this->Emails->patchEntity($email, $this->request->data);
            if ($this->Emails->save($email)) {
                $this->Flash->success(__('The email has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The email could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('email'));
        $this->set('_serialize', ['email']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Email id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $email = $this->Emails->get($id);
        if ($this->Emails->delete($email)) {
            $this->Flash->success(__('The email has been deleted.'));
        } else {
            $this->Flash->error(__('The email could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * SendMail method
     *
     * @param string|null $id Email id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function sendMail($id = null, $send = false) {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $email = $this->Emails->get($id);
            $participants = $this->Participants->find('all')->where(['deleted' => 0, 'email IS NOT NULL', 'email IS NOT' => '']);
           // debug($participants);
           // die;
            $data = $this->request->getData();
            $mail = $this->getEmail()
            ->setSubject($this->parseShortcodes($email->subject,$data));
            while($participants->valid()) {
                $participant = $participants->current();
                $mail->addTo($participant->email, $participant->full_name);
                $participants->next();
            }
            if (!$mail->send($this->parseShortcodes($email->message, $data))) {
                $this->Flash->error('Message could not be sent.');
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                $this->Flash->success('Message sent!');
            }
            return $this->redirect(['action' => 'view', $id]);
        }
    }


    private function parseShortcodes($message, $data = null) {
        preg_match_all('{{(.*?)}}', $message, $matches);
        foreach ($matches[0] as $match) {
            $cleanedMatch = str_replace("}", "", str_replace("{{", "", $match));
            $message = str_replace("{{" . $cleanedMatch . "}}", $this->invokeFunction(trim($cleanedMatch), $data), $message);
        }
        return $message;
    }

    private function addShortcode($key, $functionName) {
        $this->shortcodes[$key] = $functionName;
    }

    private function getFullName($participant) {
        return $participant->first_name . " " . $participant->last_name;
    }

    private function getParticipantTitle($participant) {
        return $participant->title;
    }

    private function getSchedule() {
        $this->loadModel('Locations');
        $locations = $this->Locations->find("all", array(
            "order" => array("Locations.day" => "asc")
        ));
        $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        ob_start();
        foreach ($locations as $location) {
            ?>
            <h3><?= $location->name ?></h3>
            <table>
                <tr>
                    <td>
                        Day
                    </td>
                    <td>
                        Time
                    </td>
                </tr>
                <tr>
                    <td><?= $days[$location->day] ?></td>
                    <?php if ((strtotime($location->end_time) - strtotime($location->start_time)) > 10800) { ?>
                        <td><?php echo date("h:i A", strtotime($location->start_time)) . " - " . date("h:i A", strtotime($location->start_time) + ((strtotime($location->end_time) - strtotime($location->start_time)) / 2)) . " Or " . date("h:i A", strtotime($location->end_time) - ((strtotime($location->end_time) - strtotime($location->start_time)) / 2)) . " - " . date("h:i A", strtotime($location->end_time)) ?></td>
                    <?php } else { ?>
                        <td><?php echo date("h:i A", strtotime($location->start_time)) . " - " . date("h:i A", strtotime($location->end_time)) ?></td>
                    <?php } ?>
                </tr>
            </table>
            <?php
        }
        return ob_get_clean();
    }

    private function invokeFunction($key, $value) {
        if (array_key_exists(trim($key), $this->shortcodes)) {
            $keyFunc = $this->shortcodes[$key];
            return $keyFunc($value);
        }
    }

    private function getEmail() {
        $email = new Email('default');
        return $email->setEmailFormat('html')
            ->setFrom('carts@gtiwebdev.com', 'Cart Witnessing')
            ->setReplyTo('carts@gtiwebdev.com', 'Cart Witnessing');
    }

    public function getMonth($data) {
        return date("F", mktime(null, null, null, $data['date']['month']));
    }

    public function getParticipantName($data) {
        $participant  = $this->Participants->get($data['participant']);
        return $participant->full_name;
    }

    public function participantSchedule() {
        $participant  = $this->Participants->get($data['participant']);

        $scheduledLocations = $this->ScheduledLocations->find('all')->where([
            'participant_id' => $participant->id,
            'schedule_date BETWEEN ? AND ?' => array(date("Y-m-d"))
        ]);
        // get scheduled locations for date


        return;
    }

}
