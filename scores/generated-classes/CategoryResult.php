<?php

class CategoryResult {
	public $results;
	public function __construct() {
		$this->results = array();
	}
	public function addResult($event, $c) {
		$eventName = Constants::$EventNames[$event-1];
		if (!array_key_exists($eventName, $this->results)) {
			$this->results[$eventName] = array();
		}
		array_push($this->results[$eventName], new IndividualScore($c->getNumber(), $c->getName(), $c->getTeam(), $c->getScore($event), $eventName, $c->getCategory() == VO));
	}
	public function getIndividualScores($event) {
		return $this->results[$event];
	}
	public function sortResults() {
		$events = array_keys($this->results);
		foreach ($events as $event) {
			usort($this->results[$event], function($a,$b) {
				$diff = $b->score - $a->score;
				if ($diff < 0) return -1;
				elseif ($diff > 0) return 1;
				else return 0;
			});
		}
	}
}
