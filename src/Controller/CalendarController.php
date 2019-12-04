<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
/* @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Calendar;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\Validation\Validation;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class CalendarController extends AppController
{
	private $Calendar;

	public function initialize() {
		parent::initialize();
		$this->Calendar = new Calendar();		
	}
	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index()
	{
		$this->month();	
		$this->render("month");
	}


	public function week($dateString = "")
	{
		$date = new \DateTime($dateString);
		var_dump($date);
		$dateMap = $this->Calendar->getCalendarData($date->format("Y/m/1"), $date->format("Y/m/t"));
		$this->set(compact('dateMap'));

	}
    public function beforeFilter(Event $event)
    {
        // allow only login, forgotpassword
         $this->Auth->allow(['selfSchedule', 'fullCalendarData']);
    }
	public function month($dateString = "") {
		$date = new \DateTime($dateString);
		$date->setDate($date->format("Y"), $date->format("m"), 1);
		$title = $date->format("F - Y");
		$calendarData = array();
		$startDate = new \DateTime(date("Y/m/d", strtotime("-".$date->format("w")." days", strtotime($date->format("Y/m/1")))));
		$date->setDate($date->format("Y"), $date->format("m"), $date->format("t"));
		$endDate = new \DateTime(date("Y/m/d", strtotime("+".(6-$date->format("w"))." days", strtotime($date->format("Y/m/d")))));
		$dateMap = $this->Calendar->getCalendarData($startDate->format("Y/m/d"), $endDate->format("Y/m/d"));

		$calendarData['title'] = $title;
		$calendarData['nextMonth'] = new \DateTime($dateString);
		$calendarData['nextMonth'] = $calendarData['nextMonth']->modify('next month')->format("Y-m-d");
		$calendarData['lastMonth'] = new \DateTime($dateString);
		$calendarData['lastMonth'] = $calendarData['lastMonth']->modify('last month')->format("Y-m-d");
		$calendarData['currentMonth'] = new \DateTime($dateString);
		$calendarData['currentMonth'] = $calendarData['currentMonth']->format("Y-m-d");
		$calendarData['dateMap'] = $dateMap;
		$this->set(compact('calendarData'));

	} 

	public function staticViews($view = "month", $dateString = "") {
		$this->viewBuilder()->layout("print");
		switch($view) {
			default:
				$this->month($dateString);
				$this->render("static-month");
		}
	}

	public function selfSchedule($dateString = "") {
		$this->loadModel('Participants');
		$qId = $this->request->getQuery('id');
		$session = $this->request->getSession();
		if ($this->request->is('post')) {
			$email = $this->request->getData('email');
			if (Validation::email($email)) {
				$participant = $this->Participants->find()->where(["email" => $email])->first();
				if(!$participant) {
					$this->Flash->error('Email not found');
					return;
				}else{
					$emailer = new Email('default');
					$emailer->setFrom(['carts@gtiwebdev.com' => 'Carts App'])
						->setTo($email)
						->setEmailFormat('html')
						->setSubject('Your link to publiccarts.xyz')
						->send('This link will allow access to publiccart.xyz<br><a href="'.Router::fullBaseUrl().'/calendar/self-schedule/?id='.$participant->uuid.'">Link to publiccart.xyz</a>');
					$this->Flash->success('Email sent! Click the link to get in!');
					return;
				}
			}
		}
		if($qId) {
			$participant = $this->Participants->find()->where(["uuid" => $qId])->first();
			if(!$participant) {
				$this->Flash->error('Bad url');
				return;
			}
			$session->write('self_checkout_paricipant_id', $participant->id);
		}
		if($session->read('self_checkout_paricipant_id')) {
			$participant = $this->Participants->get($session->read('self_checkout_paricipant_id'));
		}
		$this->set(compact('participant'));
	}

	public function fullCalendarData($startDate, $endDate) {
		$participant = $this->validateParticipant();
		$this->set([
			'data' => $this->Calendar->getFullCalendarData($startDate, $endDate, $participant),
			'_serialize' => 'data',
		]);
		return $this->RequestHandler->renderAs($this, "json");
	}
	private function validateParticipant() {

		$this->loadModel('Participants');
		$session = $this->request->getSession();
		if($session->read('self_checkout_paricipant_id')) {
			$participant = $this->Participants->get($session->read('self_checkout_paricipant_id'));
		}
		if(!isset($participant)) {
			$this->Flash->error('Please enter email');
            return $this->redirect(['action' => 'selfSchedule']);
		}	
		return $participant;
	}
	private function getLocationsByDate($dateString) {
		$locations = $this->Locations->find("all");
		$targetDate = new \DateTime($dateString);
		$return = array();
		foreach($locations as $location) {
			if($targetDate->format("Y/m/d") == $location["start_time"]->format("Y/m/d")) {
				$return[] = $location;
			}
		}
		return $return;
	}




}
