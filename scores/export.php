<?php
require_once 'vendor/autoload.php';
require_once 'serverInfo.php';
// setup Propel
require_once 'generated-conf/config.php';

use Propel\Runtime\Propel;

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

function logError($msg) {
	file_put_contents('php://stderr', print_r($msg . "\n", TRUE));
}

function writeEvent($output, $ir, $cat, $evt, $event, $toPlace) {
	$res = $ir->getResults($cat, $evt);
	$place = 1;
	$lastScore = 0;
	for ($i=0; $i<count($res) && $place<$toPlace; $i++) {
		$is = $res[$i];
		if ($lastScore != 0 && $lastScore !=  $is->score) {
			$place = $i+1;
		}
		$lastScore = $is->score;
		fputcsv($output, array($place,$event,$is->name,$is->score));
	}
}

$meetId = $_GET['meetId'];
$toPlace = $_GET['toPlace'];
$meet = Meet::getMeet($meetId);
$ir = $meet->getIndividualResults();


header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=results.csv');


// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
fputcsv($output, array('Place', 'Event', 'Competitor', 'Score'));
writeEvent($output, $ir,'JV','VAULT','JV Vault',$toPlace);
writeEvent($output, $ir,'JV','BARS','JV Bars',$toPlace);
writeEvent($output, $ir,'JV','BEAM','JV Beam',$toPlace);
writeEvent($output, $ir,'JV','FLOOR','JV Floor',$toPlace);
writeEvent($output, $ir,'JV','ALLAROUND','JV AA',$toPlace);
writeEvent($output, $ir,'VC','VAULT','VC Vault',$toPlace);
writeEvent($output, $ir,'VC','BARS','VC Bars',$toPlace);
writeEvent($output, $ir,'VC','BEAM','VC Beam',$toPlace);
writeEvent($output, $ir,'VC','FLOOR','VC Floor',$toPlace);
writeEvent($output, $ir,'VC','ALLAROUND','VC AA',$toPlace);
writeEvent($output, $ir,'VO','VAULT','VO Vault',$toPlace);
writeEvent($output, $ir,'VO','BARS','VO Bars',$toPlace);
writeEvent($output, $ir,'VO','BEAM','VO Beam',$toPlace);
writeEvent($output, $ir,'VO','FLOOR','VO Floor',$toPlace);
writeEvent($output, $ir,'VO','ALLAROUND','VO AA',$toPlace);

