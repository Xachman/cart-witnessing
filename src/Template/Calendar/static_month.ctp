<?php echo $this->Html->script("calendar.js"); ?>
<div class="calendar">
	<div class="calendar-title">Public Witnessing <?=$calendarData['title']?></div>
	<div class="container">
	<?php
	$count = 0;
	$days = $this->Calendar->getDays();
	$startDate = new  \DateTime(implode("/",explode("_",key($calendarData['dateMap']))));
	$startDay = $startDate->format("w");
	?>
		<div class="header">
		<?php
		for($i = 0; $i < 7; $i++) {
		?>
			<div class="header-day"><?=$days[($i+$startDay)%7] ?></div>
		<?php
		}
		?>
		</div>
		<?php
		foreach($calendarData['dateMap'] as $dateKey => $currentData) {
			if($count > 0 && $count % 7 == 0) { echo "</div><div class=\"container\">"; }
			$dateArray  = explode("_", $dateKey);
			$date = new \DateTime(implode("/", $dateArray));
		?>	
			  <div class="day">
				<div class="title"><?=$date->format("j")?></div>
				<div class="content">

					<?php
						$this->Calendar->renderLocations($currentData, $date, false, true);	
					?>
				</div>
			  </div>

		<?php
			//		var_dump($date);
			//		var_dump($current);

			$count++;
		}
		?>
		</div>
	</div>
</div>
<?php
