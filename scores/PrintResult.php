<?php
class PrintResult {

	public $header;
	public $scores;
	public $teamResults;

	public function __construct($cat=null, $results=null, $scores = null, $header) {
		$this->scores = $scores;
		$this->header = $header;
		if ($results != null) {
			$this->teamResults = array();
			if ($cat == 'JV') {
				foreach (Constants::$EventNames as $event) {
					$this->teamResults[$event] = $results->getJVResults($event);
				}
			} elseif ($cat == 'VARSITY') {
				foreach (Constants::$EventNames as $event) {
					$this->teamResults[$event] = $results->getVarsityResults($event);
				}
			}
		} else {
			$this->teamResults = null;
		}
	}
}
