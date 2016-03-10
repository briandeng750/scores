<?php

require_once 'vendor/autoload.php';
require_once 'PrintResult.php';
require_once 'serverInfo.php';
// setup Propel
require_once 'generated-conf/config.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Propel\Runtime\Propel;
use Base\MeetCompetitorQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Base\MeetTeamsQuery;
session_start();
if(!isset($_SESSION['user_id']))
{
	die("Bad request");
}
$ref = $_SERVER['HTTP_REFERER'];
$refData = parse_url($ref);
if (!in_array($refData['host'], $allowHosts)) {
	logError('disallowing request from: ' . $refData['host'] );
	die("Bad request from" . $refData['host']);
}
$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') die("Bad request: " . $method);

$defaultLogger = new Logger('defaultLogger');
$defaultLogger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));

$serviceContainer->setLogger('defaultLogger', $defaultLogger);
date_default_timezone_set('America/Los_Angeles');

function logError($msg) {
	file_put_contents('php://stderr', print_r($msg . "\n", TRUE));
}

function getInitParameters() {
	$initParams = [];
	$initParams['TEAMS'] = join(",", getTeams());
	$initParams['HOMETEAM'] = "La Costa Canyon";
	return json_encode($initParams);
}

function addTeam($name) {
	$team = new Team();
	$team->setName($name);
	$team->save();
	return json_encode(getTeams());
}

function deleteTeam($name) {
	$team = Team::getTeam($name);
	$members = $team->getTeamMembers();
	foreach ($members as $member) {
		$team->removeTeamMember($member);
		$team->save();
		$member->delete();
	}
	$team->delete();
	return json_encode(getTeams());
}

function getTeams() {
	$teams = Team::getAllTeams();
	$teamNames = array();
	foreach($teams as $team) {
		array_push($teamNames, $team->getName());
	}
	return $teamNames;
}

function listMeets() {
	return Meet::getAllMeets()->toJson();
}

function getMeet($id) {
	return Meet::getMeet($id)->toJson();
}

function newMeet($desc,$date,$teams,$homeTeam) {
	$meet = new Meet();
	$meet->setDescription($desc);
	$meet->setDate($date);
	$teamAry = explode(",", $teams);
	$meet->save();
	foreach ($teamAry as $team) {
		$meet->addTeam($team);
		$meet->loadTeamMembers($team);
	}
	$meet->save();
	return json_encode($meet);
}
function deleteMeet($id) {
	$meet = Meet::getMeet($id);
	$mcs = $meet->getCompetitors();
	foreach ($mcs as $comp) {
		$cId = $comp->getCompetitor()->getId();
		$c = $comp->getCompetitor();
		$c->deleteResults();
		$comp->delete();
		$c->delete();
	}
	$mts = MeetTeamsQuery::create()->findByMeetId($id);
	foreach ($mts as $mt) {
		$mt->delete();
	}
	$meet->delete();
	return listMeets();
}

function addCompetitor($id, $name, $number, $team, $category) {
	$meet = Meet::getMeet($id);
	$c = new Competitor();
	$c->setName($name);
	$c->setNumber($number);
	$c->setTeam($team);
	$c->setCategory($category);
	$c->clearScores();
	$meet->addCompetitor($c);
	$meet->save();
	return $meet->toJson();
}

function updateCompetitor($id, $name, $number, $team, $category) {
	$meet = Meet::getMeet($id);
	$comp = $meet->updateCompetitor($number, $name, $team, $category);
	$meet = Meet::getMeet($id);
	return $meet->toJson();
}

function deleteCompetitor($id, $number) {
	$meet = Meet::getMeet($id);
	$comp = $meet->getCompetitor($number);
	if (!$comp) throw new Exception("Meet competitor not found: $number");
	$mc = MeetCompetitorQuery::create()->findOneByCompetitorsId($comp->getId());
	if (!$mc) throw new Exception("Meet competitor not found: " . $comp->getId());
	$meet->removeMeetCompetitor($mc);
	$meet->save();
	return $meet->toJson();
}

function updateScore($id, $number, $event, $score) {
	$meet = Meet::getMeet($id);
	$comp = $meet->getCompetitor($number);
	if ($comp) {
		$comp->updateScore($event,$score);
		return $comp->toJSON();
	} else {
		throw new Exception("could not find competitor: ". $number);
	}
}

function individualResults($id) {
	$meet = Meet::getMeet($id);
	return json_encode($meet->getIndividualResults());
}
function teamResults($id, $minOptionalScores) {
	$meet = Meet::getMeet($id);
	return json_encode($meet->getTeamResults($minOptionalScores));
}
function getTeamMembers($name) {
	$team = Team::getTeam($name);
	if (!$team) throw new Exception("Cannot find team: $team");
	$members = $team->getTeamMembers();
	if ($members) return $members->toJson();
	else return "[]";
}
function addTeamMember($teamName, $number, $name, $category) {
	$team = Team::getTeam($teamName);
	if (!$team) throw new Exception("Cannot find team: $teamName");
	$member = new TeamMember();
	$member->setName($name);
	$member->setNumber($number);
	$member->setCategory($category);
	$team->addTeamMember($member);
	$team->save();
	return getTeamMembers($teamName);
}
function updateTeamMember($teamName, $number, $name, $category) {
	$team = Team::getTeam($teamName);
	if (!$team) throw new Exception("Cannot find team: $teamName");
	$c = new Criteria();
	$c->add('Number', $number, Criteria::EQUAL);
	$result = $team->getTeamMembers($c);
	if ($result) {
		$m = $result->getFirst();
		$m->setName($name);
		$m->setCategory($category);
		$m->save();
	}
	return getTeamMembers($teamName);
}
function deleteTeamMember($teamName, $number) {
	$team = Team::getTeam($teamName);
	if (!$team) throw new Exception("Cannot find team: $teamName");
	$c = new Criteria();
	$c->add('Number', $number, Criteria::EQUAL);
	$result = $team->getTeamMembers($c);
	if ($result) {
		$m = $result->getFirst();
		$team->removeTeamMember($m);
		$team->save();
		$m->delete();
	}
	return getTeamMembers($teamName);
}

function processTeamMemberLine($team, $line) {
	$tokens = preg_split('/\s/', $line);
	if (count($tokens)<3) {
		logError("importTeamMembers:: Cannot process line: $line");
		return;
	}
	if (!is_numeric($tokens[0])) {
		logError("importTeamMembers:: Cannot process line: $line -- Invalid number");
		return;
	}
	if (!in_array($tokens[count($tokens)-1], Constants::$ImportCategories)) {
		logError("importTeamMembers:: Cannot process line: $line -- Invalid category");
		return;
	}
	$name = "";
	for ($i=1; $i<count($tokens)-1; $i++) {
		if (strlen($name)>0) $name .= " ";
		$name .= $tokens[$i];
	}
	$member = new TeamMember();
	$member->setName($name);
	$member->setNumber($tokens[0]);
	$member->setCategory($tokens[count($tokens)-1]);
	$team->addTeamMember($member);
	$team->save();
}

function importTeamMembers($teamName, $text) {
	$team = Team::getTeam($teamName);
	if (!$team) throw new Exception("Cannot find team: $teamName");
	foreach (explode("\n", $text) as $line) {
		processTeamMemberLine($team, $line);
	}
	return getTeamMembers($teamName);
}
function printResults($id, $minOptionalScores, $page) {
	$m = Meet::getMeet($id);
	$header = $m->getDescription() . " (" . $m->getDate()->format('M d, Y') . ") - ";
	if ("jvteam" == $page) {
		$header .= "Junior Varsity Team Results";
		return json_encode(new PrintResult('JV', $m->getTeamResults($minOptionalScores), null, $header));
	} elseif ("varsityteam" == $page) {
		$header .= "Varsity Team Results";
		return json_encode ( new PrintResult('VARSITY', $m->getTeamResults($minOptionalScores), null, $header));
	} else {
		switch ($page) {
			case "jvVault" :
				$cat = 'JV';
				$evt = 'VAULT';
				$header .= "Junior Varsity Vault";
				break;
			case "jvBars" :
				$cat = 'JV';
				$evt = 'BARS';
				$header .= "Junior Varsity Bars";
				break;
			case "jvBeam" :
				$cat = 'JV';
				$evt = 'BEAM';
				$header .= "Junior Varsity Beam";
				break;
			case "jvFloor" :
				$cat = 'JV';
				$evt = 'FLOOR';
				$header .= "Junior Varsity Floor";
				break;
			case "jvAA" :
				$cat = 'JV';
				$evt = 'ALLAROUND';
				$header .= "Junior Varsity All-Around";
				break;
			case "vcVault" :
				$cat = 'VC';
				$evt = 'VAULT';
				$header .= "Varsity Compulsory Vault";
				break;
			case "vcBars" :
				$cat = 'VC';
				$evt = 'BARS';
				$header .= "Varsity Compulsory Bars";
				break;
			case "vcBeam" :
				$cat = 'VC';
				$evt = 'BEAM';
				$header .= "Varsity Compulsory Beam";
				break;
			case "vcFloor" :
				$cat = 'VC';
				$evt = 'FLOOR';
				$header .= "Varsity Compulsory Floor";
				break;
			case "vcAA" :
				$cat = 'VC';
				$evt = 'ALLAROUND';
				$header .= "Varsity Compulsory All-Around";
				break;
			case "voVault" :
				$cat = 'VO';
				$evt = 'VAULT';
				$header .= "Varsity Optional Vault";
				break;
			case "voBars" :
				$cat = 'VO';
				$evt = 'BARS';
				$header .= "Varsity Optional Bars";
				break;
			case "voBeam" :
				$cat = 'VO';
				$evt = 'BEAM';
				$header .= "Varsity Optional Beam";
				break;
			case "voFloor" :
				$cat = 'VO';
				$evt = 'FLOOR';
				$header .= "Varsity Optional Floor";
				break;
			case "voAA" :
				$cat = 'VO';
				$evt = 'ALLAROUND';
				$header .= "Varsity Optional All-Around";
				break;
			default:
				throw new Exception("Invalid printResults page! "+$page);
		}
		return json_encode(new PrintResult(null, null, $m->getIndividualResults()->getResults($cat,$evt), $header));
	}
}

$act = $_POST["action"];
try {
	switch ($act) {
		case "getInitParameters":
			echo getInitParameters();
			break;
		case "addTeam": 
			echo addTeam($_POST["teamName"]);
			break;
		case "deleteTeam":
			echo deleteTeam($_POST["teamName"]);
			break;
		case "getTeams":
			logError('called getTeams()');
			echo getTeams();
			break;
		case "list":
			echo listMeets();
			break;
		case "getMeet":
			echo getMeet($_POST["meetID"]);
			break;
		case "newMeet":
			$desc = $_POST["description"];
			$date = $_POST["date"];
			$teams = $_POST["teams"];
			$homeTeam = $_POST["homeTeam"];
			echo newMeet($desc,$date,$teams,$homeTeam);
			break;
		case "deleteMeet":
			echo deleteMeet($_POST["meetID"]);
			break;
		case "addCompetitor":
			echo addCompetitor($_POST["meetID"], $_POST["name"], $_POST["number"], $_POST["team"], $_POST["category"]);
			break;
		case "updateCompetitor":
			echo updateCompetitor($_POST["meetID"], $_POST["name"], $_POST["number"], $_POST["team"], $_POST["category"]);
			break;
		case "deleteCompetitor":
			echo deleteCompetitor($_POST["meetID"], $_POST["number"]);
			break;		
		case "updateScore":
			echo updateScore($_POST["meetID"],$_POST["competitorNumber"],$_POST["event"],$_POST["score"]);
			break;
		case "individualResults":
			echo individualResults($_POST["meetID"]);
			break;
		case "teamResults":
			echo teamResults($_POST["meetID"], $_POST["minOptionalScores"]);
			break;
			default:
			echo "error: invalid action: "+ $act;
			break;
		case "getTeamMembers":
			echo getTeamMembers($_POST["teamName"]);
			break;
		case "addTeamMember":
			echo addTeamMember($_POST["teamName"], $_POST["number"], $_POST["name"], $_POST["category"]);
			break;
		case "updateTeamMember":
			echo updateTeamMember($_POST["teamName"],$_POST["number"],$_POST["name"],$_POST["category"]);
			break;
		case "deleteTeamMember":
			echo deleteTeamMember($_POST["teamName"],$_POST["number"]);
			break;
		case "importTeamMembers":
			echo importTeamMembers($_POST["teamName"],$_POST["text"]);
			break;
		case "printResults":
			echo printResults($_POST["meetID"],$_POST["minOptionalScores"], $_POST["page"]);
			break;
		default:
			throw new Exception("unsupported action: $act");
	}
} catch (Exception $e) {
	logError($e);
	var_dump(http_response_code(500));
	echo $e;
}
