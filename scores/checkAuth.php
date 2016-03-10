<?php
use Propel\Common\Config\ConfigurationManager;

/*** begin the session ***/
session_start();

if(!isset($_SESSION['user_id']))
{
	header("Location: login.php"); /* Redirect browser */
	exit();
}
else
{
	try
	{
		$cfgMgr = new ConfigurationManager();
		$dbConn = $cfgMgr->get()['database']['connections']['ezscore'];
		$dsn = $dbConn['dsn'];
		$dbUser = $dbConn['user'];
		$dbPass = $dbConn['password'];

		/*** select the users name from the database ***/
		$dbh = new PDO($dsn, $dbUser, $dbPass);
		/*** $message = a message saying we have connected ***/

		/*** set the error mode to excptions ***/
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		/*** prepare the insert ***/
		$stmt = $dbh->prepare("SELECT ezs_username FROM ezs_users
        WHERE ezs_user_id = :ezs_user_id");

		/*** bind the parameters ***/
		$stmt->bindParam(':ezs_user_id', $_SESSION['user_id'], PDO::PARAM_INT);

		/*** execute the prepared statement ***/
		$stmt->execute();

		/*** check for a result ***/
		$ezs_username = $stmt->fetchColumn();

		/*** if we have no something is wrong ***/
		if($ezs_username == false)
		{
			$message = 'Access Error';
			$_SESSION['login_message']  = $message;
			header("Location: login.php"); /* Redirect browser */
			exit();
		}
		else
		{
			$message = 'Welcome '.$ezs_username;
		}
	}
	catch (Exception $e)
	{
		/*** if we are here, something is wrong in the database ***/
		$message = 'We are unable to process your request. Please try again later"';
		$_SESSION['login_message']  = $message;
		header("Location: login.php"); /* Redirect browser */
		exit();
	}
}
?>
