<?php

namespace App\Controller;

use App\Controller\AppController;

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
        $email = $this->Emails->get($id);
        if ($send) {
            $this->loadModel('Participants');
            $mail = new \PHPMailer();
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->email;                 // SMTP username
            $mail->Password = $this->password;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 26;                                    // TCP port to connect to

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $email->subject;
            $mail->Body = $this->parseShortcodes($email->message, $participant);
            $mail->AltBody = $email->message;
            if (!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
        }
        return $this->redirect(['action' => 'view', $id]);
    }

    /**
     * testSendMail method
     *
     * @param string|null $id Email id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function testSendMail($id = null, $send = false) {
        $email = $this->Emails->get($id);
        $this->loadModel('Participants');
        $participant = $this->Participants->get(49);
        if ($send) {
            $mail = new \PHPMailer();
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->email;                 // SMTP username
            $mail->Password = $this->password;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 26;                                    // TCP port to connect to

            $mail->setFrom('carts@gtiwebdev.com', 'Public Witnessing');
            //$mail->addAddress($participant->email, $participant->first_name . " " . $participant->last_name);     // Add a recipient
            $mail->addReplyTo('carts@gtiwebdev.com', 'Cart Witnessing');

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $email->subject;
            $mail->Body = $this->parseShortcodes($email->message, $participant);
            $mail->AltBody = $email->message;
            if (!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
        }
        return $this->redirect(['action' => 'view', $id]);
    }

    /**
     * SendAllMail method
     *
     * @param string|null $id Email id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function sendAllMail($id = null, $send = false) {
        $email = $this->Emails->get($id);


        if ($send) {
            $this->loadModel('Participants');
            $participants = $this->Participants->find("all", array(
                'conditions' => array('Participants.email !=' => '', 'Participants.email IS NOT NULL')
            ));
            $mail = new \PHPMailer();
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->email;                 // SMTP username
            $mail->Password = $this->password;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 26;                                    // TCP port to connect to

            $mail->setFrom($this->email, $this->senderName);
            foreach ($participants as $participant) {
                $mail->addAddress($participant->email);     // Add a recipient
            }
            $mail->addReplyTo($this->email, $this->senderName);

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $email->subject;
            $mail->Body = $this->parseShortcodes($email->message);
            $mail->AltBody = $email->message;
        }
        return $this->redirect(['action' => 'view', $id]);
    }

    private function parseShortcodes($message, $participant = null) {
        preg_match_all('{{(.*?)}}', $message, $matches);
        foreach ($matches[0] as $match) {
            $cleanedMatch = str_replace("}", "", str_replace("{{", "", $match));
            $message = str_replace("{{" . $cleanedMatch . "}}", $this->envokeFunction($cleanedMatch, $participant), $message);
        }
        return $message;
    }

    private function addShortcode($key, $functionName) {
        $this->shortcodes[$key] = $functionName;
    }

    private function getParticipantName($participant) {
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

    private function envokeFunction($key, $value) {
        if (array_key_exists($key, $this->shortcodes)) {
            $keyFunc = $this->shortcodes[$key];
            return $keyFunc($value);
        }
    }

}
