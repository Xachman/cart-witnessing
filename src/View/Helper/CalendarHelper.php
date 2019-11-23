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
	public $helpers = array('Html');

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

	public function renderScheduledLocations($data, $id, $condense = false) {
		if(isset($data['scheduled_locations'])) { 
			$count = 0;
			foreach($data['scheduled_locations'] as $schedule) { 
				if($id != $schedule['location_id']) continue;
				?>
				<a href="/scheduled-locations/edit/<?= $schedule['id'] ?>?controller=calendar&action=month" >
					<div class="participant">
						<div class="name"><?= $schedule['participant'] ?></div>
						<?php if(!$condense) { ?>
							<div class="time"><?= $schedule['start_time']->format("h:s A"); ?> - <?= $schedule['end_time']->format("h:s A"); ?></div>
						<?php } ?>
					</div>
				</a>
			<?php
			$count++;
			}
		}
	}

	public function renderLocations($data, $date, $button = true, $condense = false) {
 		if(isset($data['locations'])) {
			foreach($data['locations'] as $location) {
				?>
				<div class="location">
					<div class="title">
						<?=$location->name;?>
						<?=$location->start_time->format("g:ia");?> - <?=$location->end_time->format("g:ia");?>

					</div>
					<?=$this->renderScheduledLocations($data, $location->id, $condense);	?>
                    <div class="buttons">
                        <?php if ($button) { ?>
                            <a class="button tiny"  href="/scheduled-locations/add/<?=$location->id?>/<?=$date->format("Y-m-d")?>?controller=calendar&action=month">
                                Add
                            </a>
                        <a class="button tiny" href="/scheduled-locations/generate/<?=$location->id?>/<?=$date->format("Y-m-d")?>">Generate</a>
                        <?php } ?>
                    </div>
				</div>
				<?php
			}
		}
	}

}

