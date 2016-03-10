<?php

class TeamResults extends Constants {
	public $teamResults;
	public $minOptionalScores;
	public function __construct($m, $minOptionalScores = 2) {
		$this->minOptionalScores = $minOptionalScores;
		$this->teamResults = array();
		
		$allResults = array();
		$ir = $m->getIndividualResults();
		foreach (self::$EventTypes as $e) {
			foreach (self::$Categories as $c) {
				$vScores = $ir->getResults($c, $e);
				if ($vScores == NULL) continue;
				foreach ($vScores as $individualScore) {
					if ($individualScore->score==null) continue;
					$team = $individualScore->team;
					if ($allResults[$team]==null) {
						$allResults[$team] = array();
					}
					if ($allResults[$team][$c] == null) {
						$allResults[$team][$c] = array();
					}
					array_push($allResults[$team][$c], $individualScore);
				}
			}
		}
		foreach ($allResults as $team => $teamScores) {
			$jvScores = $teamScores['JV'];
			if ($jvScores!=null && count($jvScores)>0) {
				if ($this->teamResults['JV']==null) {
					$this->teamResults['JV'] = array();
					foreach (self::$EventTypes as $e) {
						$this->teamResults['JV'][$e] = array();
					}
				}
				foreach (self::$EventTypes as $e) {
					array_push($this->teamResults['JV'][$e], new TeamResult($team, $e, $jvScores, -1));
					usort($this->teamResults['JV'][$e], function($a,$b) {
						$diff = $b->score - $a->score;
						if ($diff < 0) return -1;
						elseif ($diff > 0) return 1;
						else return 0;
					});
				}
			}
			if ($this->teamResults['VARSITY']==null) {
				$this->teamResults['VARSITY'] = array();
				foreach (self::$EventTypes as $e) {
					$this->teamResults['VARSITY'][$e] = array();
				}
			}
			$varsityScores = array();
			$voScores = $teamScores['VO'];
			$vcScores = $teamScores['VC'];
			if ($voScores!=null) $varsityScores = array_merge($varsityScores, $voScores);
			if ($vcScores!=null) $varsityScores = array_merge($varsityScores, $vcScores);
			if (count($varsityScores)==0) continue;
			foreach (self::$EventNames as $e) {
				array_push($this->teamResults['VARSITY'][$e], new TeamResult($team, $e, $varsityScores, $this->minOptionalScores));
				usort($this->teamResults['VARSITY'][$e], function($a,$b) {
					$diff = $b->score - $a->score;
					if ($diff < 0) return -1;
					elseif ($diff > 0) return 1;
					else return 0;
				});
			}
		}
	}
	public function getJVResults($event) {
		$catResult = $this->teamResults['JV'];
		if ($catResult!=null) return $catResult[$event];
		else return null;
	}
	
	public function getVarsityResults($event) {
		$catResult = $this->teamResults['VARSITY'];
		if ($catResult!=null) return $catResult[$event];
		else return null;
	}
	
}

?>