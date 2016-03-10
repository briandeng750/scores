<?php
require_once 'vendor/autoload.php';
use Propel\Common\Config\ConfigurationManager;
require "checkAuth.php";

/*** first check that both the username, password and form token have been sent ***/
if(!isset( $_POST['ezs_username'], $_POST['ezs_password'], $_POST['form_token']))
{
    $message = 'Please enter a valid username and password';
}
/*** check the form token is valid ***/
elseif( $_POST['form_token'] != $_SESSION['form_token'])
{
    $message = 'Invalid form submission';
}
/*** check the username is the correct length ***/
elseif (strlen( $_POST['ezs_username']) > 20 || strlen($_POST['ezs_username']) < 4)
{
    $message = 'Incorrect Length for Username';
}
/*** check the password is the correct length ***/
elseif (strlen( $_POST['ezs_password']) > 20 || strlen($_POST['ezs_password']) < 4)
{
    $message = 'Incorrect Length for Password';
}
/*** check the username has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['ezs_username']) != true)
{
    /*** if there is no match ***/
    $message = "Username must be alpha numeric";
}
/*** check the password has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['ezs_password']) != true)
{
        /*** if there is no match ***/
        $message = "Password must be alpha numeric";
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
        $message = 'New user added';
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
}
?>

<html>
<head>
<title>EZScore Add User Result</title>
</head>
<body>
<p><?php echo $message; ?>
</body>
</html>
