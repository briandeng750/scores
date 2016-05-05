<?php

use Base\Meet as BaseMeet;

/**
 * Skeleton subclass for representing a row from the 'meet' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Meet extends BaseMeet implements MSConstants
{

	public static function getMeet($id) {
		$m = MeetQuery::create()->findPK($id);
		if (!$m) throw new Exception("Meet not found: (" . $id . ")");
		$mcs = $m->getMeetCompetitorsJoinCompetitor();
 		foreach ($mcs as $mc) {
 			$mc->getCompetitor()->getCompetitorResults();
 		}
 		$teams  = array();
 		$meetTeams = MeetTeamsQuery::create()->findByMeetId($m->getId());
 		foreach ($meetTeams as $meetTeam) {
 			array_push($teams, $meetTeam->getTeams());
 		}
 		$m->setVirtualColumn("teams", $teams);
		return $m;
	}
	
	public static function getAllMeets() {
		$meets = MeetQuery::create()->find();
		foreach ($meets as $m) {
			$m->setVirtualColumn("DateString", $m->getDate()->format('M d, Y'));
		}
		return $meets;
	}

	public function getIndividualResults() {
		return new IndividualResults($this->getCompetitors());
	}
	public function getTeamResults($minOptionalScores) {
		return new TeamResults($this, $minOptionalScores);
	}
	public function loadTeamMembers($teamName,$catAry) {
		$team = Team::getTeam($teamName);
		if (!$team) throw new Exception("Cannot find team: $teamName");
		$teamMembers = $team->getTeamMembers();
		foreach ($teamMembers as $m) {
			if (!in_array($m->getCategory(),$catAry)) continue;
			$c = new Competitor();
			$c->setNumber($m->getNumber());
			$c->setCategory($m->getCategory());
			$c->setName($m->getName());
			$c->setTeam($teamName);
			$c->clearScores();
			$this->addCompetitor($c);
		}
	}
	public function addCompetitor($c) {
		//assert(in_array($c->getTeam(), $this->teams), "team is not part of meet"); TODO assertion
		$mc = new MeetCompetitor();
		$mc->setCompetitor($c);
		$this->addMeetCompetitor($mc);
	}
	public function updateCompetitor($number,$name,$team,$category) {
		$mcs = $this->getMeetCompetitorsJoinCompetitor();
		foreach ($mcs as $mc) {
			$comp = $mc->getCompetitor();
			if ($comp->getNumber() == $number) {
				$comp->setName($name);
				$comp->setTeam($team);
				$comp->setCategory($category);
				$mc->setCompetitor($comp);
				$mc->save();
				return;
			}
		}
		throw new Exception("Competitor not found: $number");
	}
	public function deleteCompetitor($number) {
		unset($this->competitors[$number]);
	}
	public function getCompetitor($number) {
		$mcs = $this->getMeetCompetitorsJoinCompetitor();
		foreach ($mcs as $mc) {
			$comp = $mc->getCompetitor();
			if ($comp->getNumber() == $number) return $comp; 
		}
		return null;
	}
	public function getCompetitors() {
		$mcs = $this->getMeetCompetitorsJoinCompetitor();
 		foreach ($mcs as $mc) {
 			$mc->getCompetitor()->getCompetitorResults();
 		}
		return $mcs;
	}
	public function addTeam($team) {
		$mt = new MeetTeams();
		$mt->setMeetId($this->getId());
		$mt->setTeams($team);
		$mt->save();
	}
	
}
