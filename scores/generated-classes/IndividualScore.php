<?php

class IndividualScore implements MSConstants {

	public $number;
	public $name;
	public $score;
	public $team;
	public $event;
	public $isOptional;
	
	public function __construct($number,$name,$team,$score,$event,$isOptional) {
		$this->name = $name;
		$this->number = $number;
		$this->score = $score;
		$this->team = $team;
		$this->event = $event;
		$this->isOptional = $isOptional;
	}
}
?>
