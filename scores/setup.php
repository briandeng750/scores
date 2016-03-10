<?php
require_once 'vendor/autoload.php';
use Propel\Common\Config\ConfigurationManager;

$ezs_username = 'administrator';
$ezs_password = 'D3faultP@ss';

$ezs_password = sha1( $ezs_password );

$cfgMgr = new ConfigurationManager();
$dbConn = $cfgMgr->get()['database']['connections']['ezscore'];
$dsn = $dbConn['dsn'];
$dbUser = $dbConn['user'];
$dbPass = $dbConn['password'];

try
{
	$dbh = new PDO($dsn, $dbUser, $dbPass);
	/*** $message = a message saying we have connected ***/

	/*** set the error mode to excptions ***/
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "SELECT count(*) from ezs_users WHERE ezs_username = 'administrator'";
	if ($res = $dbh->query($sql)) {
		if ($res->fetchColumn() == 1) {
			die("Setup already completed.");
		}
	}
	
	/*** prepare the insert ***/
	$stmt = $dbh->prepare("INSERT INTO ezs_users (ezs_username, ezs_password ) VALUES (:ezs_username, :ezs_password )");

	/*** bind the parameters ***/
	$stmt->bindParam(':ezs_username', $ezs_username, PDO::PARAM_STR);
	$stmt->bindParam(':ezs_password', $ezs_password, PDO::PARAM_STR, 40);

	/*** execute the prepared statement ***/
	$stmt->execute();
	

	/*** unset the form token session variable ***/
	unset( $_SESSION['form_token'] );

	/*** if all is done, say thanks ***/
	$message = 'Setup Complete';
}
catch(Exception $e)
{
	/*** check if the username already exists ***/
	if( $e->getCode() == 23000)
	{
		$message = 'Username already exists';
	}
	else
	{
		/*** if we are here, something has gone wrong with the database ***/
		$message = 'We are unable to process your request. Please try again later"';
	}
}
?>
<html>
<body>
<span><?=$message?></span>
</body>
</html>
