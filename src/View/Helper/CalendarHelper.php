<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CalendarHelper
 *
 * @author xach
 */

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

class CalendarHelper extends Helper {
	private $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
	public $helpers = array('Html', 'Form', 'Time');

	// initialize() hook is available since 3.2. For prior versions you can
	// override the constructor if required.
	public function initialize(array $config) {
		// debug($config);
	}
	public function getDays() {
		return $this->days;
	}
	public function displayCalendar($calendarData) {
		echo $this->Html->script("calendar.js");
		?>
			<div class="calendar">
			<div class="calendar-title"><?=$calendarData['title']?></div>
			<div class="container">
			<?php
			$count = 0;
		foreach($calendarData['dateMap'] as $dateKey => $currentData) {
			if($count > 0 && $count % 7 == 0) { echo "</div><div class=\"container\">"; }
			$dateArray  = explode("_", $dateKey);
			$date = new \DateTime(implode("/", $dateArray));
			?>	
				<div class="day">
				<div class="title"><?=$this->days[$date->format("w")]?> - <?=$date->format("j")?></div>

<?php
 					$this->renderLocations($currentData, $date, true);	
				?>
				</div>

				<?php
				//		var_dump($date);
				//		var_dump($current);

				$count++;
		}
		?>
			</div>
			</div>
			</div><?php
	}

	public function displayFullCalendar() {
		echo $this->Html->script("fullcalendar.js");
		echo $this->Html->css('fullcalendar');
		echo $this->Html->css('fullcalendar-daygrid');
		echo $this->Html->css('fullcalendar-list');
		?>
		<div id="fullCalendar"></div>
		<?php

	}
	public function displaySelfScheduleCalendar($calendarData, $participant) {
		//echo $this->Html->script("calendar.js");
		echo $this->Html->script("fullcalendar.js");
		echo $this->Html->css('fullcalendar');
		echo $this->Html->css('fullcalendar-daygrid');
		?>
			<div class="calendar">
			<div class="calendar-title"><?=$calendarData['title']?></div>
			<div class="container">
			<?php
			$count = 0;
		foreach($calendarData['dateMap'] as $dateKey => $currentData) {
			if($count > 0 && $count % 7 == 0) { echo "</div><div class=\"container\">"; }
			$dateArray  = explode("_", $dateKey);
			$date = new \DateTime(implode("/", $dateArray));
			?>	
				<div class="day">
				<div class="title"><?=$this->days[$date->format("w")]?> - <?=$date->format("j")?></div>

<?php
 					$this->renderLocations($currentData, $date, true, $participant);	
				?>
				</div>

				<?php
				//		var_dump($date);
				//		var_dump($current);

				$count++;
		}
		?>
			</div>
			</div>
			</div><?php
	}

	public function renderScheduledLocations($data, $id, $participant, $date) {
		if(isset($data['scheduled_locations'])) { 
			$count = 0;
			foreach($data['scheduled_locations'] as $schedule) { 
				if($id != $schedule['location_id']) continue;
				?>
						<?php
						if(isset($participant) && $participant->id == $schedule['participant_id']) {?>
						<div class="participant">
							<div class="name"><?= $schedule['participant'] ?></div>
							<?php
							echo $this->Form->postLink('Delete',[
								'controller' => 'ScheduledLocations',
								'action' => 'selfDelete',
								$schedule['id'],
								$date->format("Y-m-d"),
								'?' => [
									'controller' => 'calendar',
									'action' => 'selfSchedule'
								],
							],
							[
								'confirm' => "Delete schedule on ".$date->format('M d')."?",
								'class' => 'button tiny'
							]);?>
						</div>
						<?php }else{?>
					<div class="participant">
						<div class="name">
							<?= $schedule['participant'] ?>
							<?php if(!isset($participant)) {
								echo $this->Form->postLink('Delete',[
									'controller' => 'ScheduledLocations',
									'action' => 'delete',
									$schedule['id'],
									$date->format("Y-m-d"),
									'?' => [
										'controller' => 'calendar',
										'action' => 'month'
									],
								],
								[
									'confirm' => "Delete schedule on ".$date->format('M d')."?",
								]);
							}?>
						</div>
					</div>
						<?php } ?>
			<?php
			$count++;
			}
		}
	}

	public function renderLocations($data, $date, $button = true, $participant = null) {
 		if(isset($data['locations'])) {
			foreach($data['locations'] as $location) {
				?>
				<div class="location">
					<div class="title">
						<?=$location->name;?>
						<?=$location->start_time->format("g:ia");?> - <?=$location->end_time->format("g:ia");?>

					</div>
					<?=$this->renderScheduledLocations($data, $location->id, $participant, $date);	?>
                    <div class="buttons">
						<?php if ($button) { ?>
							<?php if (isset($participant)) { ?>
								<?=$this->Form->postLink('Add',[
									'controller' => 'ScheduledLocations',
									'action' => 'selfAdd',
									'?' => [
										'controller' => 'calendar',
										'action' => 'selfSchedule'
									],
									$location->id,
									$date->format("Y-m-d")
								],
								[
									'confirm' => "Schedule $location->name on ".$date->format('M d')."?",
									'class' => 'button tiny',
									'data' => [
										'location_id' => $location->id,
										'schedule_date' => [
											'year' => $date->format('Y'),
											'month' => $date->format('m'),
											'day' => $date->format('j')
										],
										'start_time' => [ 
											'hour' => $this->Time->format($location->start_time, 'HH'),
											'minute' => $this->Time->format($location->start_time, 'mm'),
										],
										'end_time' => [ 
											'hour' => $this->Time->format($location->end_time, 'HH'),
											'minute' => $this->Time->format($location->end_time, 'mm'),
										],

									]
								]);?>
                       		<?php }else{ ?>
								<a class="button tiny"  href="/scheduled-locations/add/<?=$location->id?>/<?=$date->format("Y-m-d")?>?controller=calendar&action=month">
									Add
								</a>
                       		<?php } ?>
                       <?php } ?>
                    </div>
				</div>
				<?php
			}
		}
	}

}

