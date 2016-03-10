<?php

use Base\CompetitorCompetitorresults as BaseCompetitorCompetitorresults;

/**
 * Skeleton subclass for representing a row from the 'competitor_competitorresults' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class CompetitorCompetitorresults extends BaseCompetitorCompetitorresults
{
	public function __construct($compId = -1, $key = "") {
		$this->setCompetitorId($compId);
		$this->setCompetitorresultsKey($key);
		$this->setCompetitorresults(0.0);
	}
}
