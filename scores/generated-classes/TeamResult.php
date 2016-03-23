<?php

class TeamResult extends Constants implements MSConstants {
	public $team;
	public $teamScores;
	public $includedScores;
	public $score;
	
	public function __construct($team,$event,$teamScores,$minOptionalScores) {
		$this->team = $team;
		$this->teamScores = $teamScores;
		$this->includedScores = array();
		if ($minOptionalScores>=0) {
			$this->computeVarsityScore($event, $minOptionalScores);
		} else {
			$this->computeJVScore($event);
		}
	}
	
	private function computeJVScore($event) {
		$this->score = 0.0;
		if ($this->teamScores==NULL) return;
		$eventScores = $this->collateAndSortEventScores();
		if ($event == 'ALLAROUND') { // All around is treated as the overall team score. Compute differently
			foreach (self::$EventTypes as $e) {
				if ($e == 'ALLAROUND') continue; // Exclude AA for team scores
				$this->computeJVEventScore($eventScores, $e);
			}
		} else { // Individual Event team score
			$this->computeJVEventScore($eventScores, $event);
		}
	}
	private function computeJVEventScore($eventScores, $event) {
		if (array_key_exists($event, $eventScores)) {
			$sortedEventScores = $eventScores[$event]; // TODO: sort scores
			for ($i=0; $i<min(count($sortedEventScores),MSConstants::JV_COUNT); $i++) {
				$iScore = $sortedEventScores[$i];
				if ($iScore!=null) {
					$this->score += $iScore->score;
					array_push($this->includedScores, $iScore);
				}
			}
		}
		return sortedEventScores;
	}
	
	private function computeVarsityScore($event, $minOptionalScores) {
		$this->score = 0.0;
		if ($this->teamScores==NULL) return;
		$eventScores = $this->collateAndSortEventScores();
		if ($event == 'ALLAROUND') { // All around is treated as the overall team score. Compute differently
			foreach (Constants::$EventNames as $e) {
				if ($e == 'ALLAROUND') continue; // Exclude AA for team scores
				$this->computeVarsityEventScore($eventScores, $e, $minOptionalScores);
			}
		} else { // Individual Event team score
			$this->computeVarsityEventScore($eventScores, $event, $minOptionalScores);
		}
	}
	
	private function computeVarsityEventScore($eventScores, $event, $minOptionalScores) {
		if (array_key_exists($event, $eventScores)) {
			$oCount = 0;
			$spliceIndices = array();
			for ($i=0; $i<count($eventScores[$event]) && $oCount<$minOptionalScores; $i++) {
				$iScore = $eventScores[$event][$i];
				if ($iScore->isOptional) {
					array_push($this->includedScores, $iScore);
					$this->score += $iScore->score;
					array_push($spliceIndices,$i);
					++$oCount;
				}
			}
			for ($j=count($spliceIndices)-1; $j>=0; $j--) {
				array_splice($eventScores[$event], $spliceIndices[$j], 1);
			}
			// Add the remaining (VARSITY_COUNT-minOptionalScores) highest scores
			for ($i=0; $i<min(count($eventScores[$event]),(self::VARSITY_COUNT-$minOptionalScores)); $i++) {
				$iScore = $eventScores[$event][$i];
				if ($iScore!=null) {
					$this->score += $iScore->score;
					array_push($this->includedScores, $iScore);
				}
			}
		}
	}
	private function collateAndSortEventScores() {
		$eventScores = array();
		foreach ($this->teamScores as $iScore) {
			if (!array_key_exists($iScore->event, $eventScores)) {
				$eventScores[$iScore->event] = array();
			}
			array_push($eventScores[$iScore->event], $iScore);
		}
		foreach (Constants::$EventNames as $e) {
			if (array_key_exists($e, $eventScores)) {
				usort($eventScores[$e], function($a,$b) {
					$diff = $b->score - $a->score;
					if ($diff < 0) return -1;
					elseif ($diff > 0) return 1;
					else return 0;
				});
			}
		}
		return $eventScores;
	}
	
}
?>