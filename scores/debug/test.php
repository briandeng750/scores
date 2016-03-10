<?php

spl_autoload_register(function ($class_name) {
	include 'model/' . $class_name . '.php';
});

$comp = new Competitor(VO, "Alex Deng", "111", "La Costa Canyon");
$comp->updateScore(MSConstants::VAULT, 9.2);
$comp->updateScore(MSConstants::BARS, 9.3);
$comp->updateScore(MSConstants::BEAM, 9.6);
$comp->updateScore(MSConstants::FLOOR, 9.8);
echo json_encode($comp);

$test = array('abc'=>1, 'def'=>2);
echo '<br/>';
echo 'Testing: ' . $test['abc'];
echo '<br/>';
echo 'Testing: ' . $test['def'];
echo '<br/>';
echo 'Testing: ' . ($test['xyz']!=null);

?>