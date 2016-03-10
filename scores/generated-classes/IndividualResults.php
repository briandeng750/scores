<?php
class IndividualResults extends Constants implements MSConstants {
	public $results;
	public function __construct($mcs) {
		$this->results = array();
		foreach ($mcs as $mc) {
			$this->addResult($mc);
		}
		$this->sortResults();
	}
	public function addResult($mc) {
		$c = $mc->getCompetitor();
		$c->getCompetitorResults();
		$cat = $c->getCategory();
		if (!array_key_exists($cat, $this->results)) {
			$this->results[$cat] = new CategoryResult();
		}
		$s = $c->getScore(self::VAULT);
		if ($s!= NULL && $s>0.0) {
			$this->results[$cat]->addResult(self::VAULT, $c);
		}
		$s = $c->getScore(self::BARS);
		if ($s!= NULL && $s>0.0) {
			$this->results[$cat]->addResult(self::BARS, $c);
		}
		$s = $c->getScore(self::BEAM);
		if ($s!= NULL && $s>0.0) {
			$this->results[$cat]->addResult(self::BEAM, $c);
		}
		$s = $c->getScore(self::FLOOR);
		if ($s!= NULL && $s>0.0) {
			$this->results[$cat]->addResult(self::FLOOR, $c);
		}
		$s = $c->getScore(self::ALLAROUND);
		if ($s!= NULL && $s>0.0) {
			$this->results[$cat]->addResult(self::ALLAROUND, $c);
		}		
	}
	private function sortResults() {
		foreach (self::$Categories as $cat) {
			if ($this->results[$cat]) $this->results[$cat]->sortResults();
		}
	}
	public function getResults($category, $event) {
		if (array_key_exists($category, $this->results)) {
			$cr = $this->results[$category];
			return $cr->getIndividualScores($event);
		}
		return NULL;
	}
}

?>
