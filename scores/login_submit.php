<?php
require_once 'vendor/autoload.php';
use Propel\Common\Config\ConfigurationManager;

/*** begin our session ***/
session_start();

/*** check if the users is already logged in ***/
if(isset( $_SESSION['user_id'] ))
{
    $message = 'Users is already logged in';
}
/*** check that both the username, password have been submitted ***/
if(!isset( $_POST['ezs_username'], $_POST['ezs_password']))
{
    $message = 'Please enter a valid username and password';
}
else
{
    /*** if we are here the data is valid and we can insert it into database ***/
    $ezs_username = filter_var($_POST['ezs_username'], FILTER_SANITIZE_STRING);
    $ezs_password = filter_var($_POST['ezs_password'], FILTER_SANITIZE_STRING);

    /*** now we can encrypt the password ***/
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

        /*** prepare the select statement ***/
        $stmt = $dbh->prepare("SELECT ezs_user_id, ezs_username, ezs_password FROM ezs_users 
                    WHERE ezs_username = :ezs_username AND ezs_password = :ezs_password");

        /*** bind the parameters ***/
        $stmt->bindParam(':ezs_username', $ezs_username, PDO::PARAM_STR);
        $stmt->bindParam(':ezs_password', $ezs_password, PDO::PARAM_STR, 40);

        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** check for a result ***/
        $user_id = $stmt->fetchColumn();

        /*** if we have no result then fail boat ***/
        if($user_id == false) {
            $message = 'Invalid login credentials';
        }
        /*** if we do have a result, all is well ***/
        else
        {
            /*** set the session user_id variable ***/
            $_SESSION['user_id'] = $user_id;
             /*** tell the user we are logged in ***/
            $message = 'You are now logged in';
        }
    }
    catch(Exception $e)
    {
        $message = 'We are unable to process your request. Please try again later"';
    }
}
if ($message) {
	$_SESSION['login_message']  = $message;
}

header("Location: index.php"); /* Redirect browser */
exit();
?>
