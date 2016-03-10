<?php

use Base\Competitor as BaseCompetitor;
use \CompetitorCompetitorresultsQuery as ChildCompetitorCompetitorresultsQuery;

/**
 * Skeleton subclass for representing a row from the 'HTCOMPETITOR' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Competitor extends BaseCompetitor implements MSConstants
{

	public function __construct() {
		parent::__construct();
	}
	
	public function getResults() {
		return $this->results;
	}
	public function getCompetitorResults(Criteria $criteria = null, ConnectionInterface $con = null)
	{
		$this->collCompetitorCompetitorresultss = ChildCompetitorCompetitorresultsQuery::create(null, $criteria)
		->orderByCompetitorresultsKey()
		->findByCompetitorId($this->getId());
		$this->updateResults();
		return $this->collCompetitorCompetitorresultss;
	}
	public function updateScore($event, $score) {
		$results = $this->getCompetitorCompetitorresultss();
		$idx = array_search($event, Constants::$EventNames);
		$results[$idx]->setCompetitorresults($score);
		$this->save();
		$this->updateResults();
	}
	public function deleteResults() {
		$crs = $this->getCompetitorCompetitorresultss();
		foreach ($crs as $cr) {
			$cr->delete();
		}
	}
	public function clearScores() {
		$this->addCompetitorCompetitorresults(new CompetitorCompetitorresults($this->getId(), self::VAULT));
		$this->addCompetitorCompetitorresults(new CompetitorCompetitorresults($this->getId(), self::BARS));
		$this->addCompetitorCompetitorresults(new CompetitorCompetitorresults($this->getId(), self::BEAM));
		$this->addCompetitorCompetitorresults(new CompetitorCompetitorresults($this->getId(), self::FLOOR));
	}
	public function getScore($event) {
		if ($event == self::ALLAROUND) {
			return $this->getAAScore();
		}
		if ($this->collCompetitorCompetitorresultss[$event-1]) {
			return $this->collCompetitorCompetitorresultss[$event-1]->getCompetitorresults();
		} else {
			return 0.0;
		}
	}
	private function getAAScore() {
		$s1 = $this->getScore(self::VAULT);
		$s2 = $this->getScore(self::BARS);
		$s3 = $this->getScore(self::BEAM);
		$s4 = $this->getScore(self::FLOOR);
		if ($s1 && $s2 && $s3 && $s4) {
			return $s1+$s2+$s3+$s4;
		} else {
			return 0.0;
		}
	}
	private function updateResults() {
		$results = [];
		$aa = 0.0;
		$s1 = $this->getScore(self::VAULT);
		$s2 = $this->getScore(self::BARS);
		$s3 = $this->getScore(self::BEAM);
		$s4 = $this->getScore(self::FLOOR);
		$results['VAULT'] = $s1;
		$results['BARS'] = $s2;
		$results['BEAM'] = $s3;
		$results['FLOOR'] = $s4;
		if ($s1 && $s2 && $s3 && $s4) {
			$aa = $s1+$s2+$s3+$s4;
		}
		$results['ALLAROUND'] = $aa;
		$this->setVirtualColumn('competitorResults', $results);
	}
}
