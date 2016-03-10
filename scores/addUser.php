<?php
require_once 'vendor/autoload.php';
require "checkAuth.php";

/*** set a form token ***/
$form_token = md5( uniqid('auth', true) );

/*** set the session form token ***/
$_SESSION['form_token'] = $form_token;
?>

<html>
<head>
<link rel="stylesheet" href="css/south-street/jquery-ui-1.10.4.custom.min.css" />
<link rel="stylesheet" href="css/multiselect.css"></link>
<link rel="stylesheet" href="css/ezscore.css"></link>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
<title>EZScore Login</title>
</head>

<body>
<h2>Add user</h2>
<form id="addUserForm" action="adduser_submit.php" method="post">
<fieldset>
<p>
<label for="ezs_username">Username</label>
<input type="text" id="ezs_username" name="ezs_username" value="" maxlength="20" />
</p>
<p>
<label for="ezs_password">Password</label>
<input type="password" id="ezs_password" name="ezs_password" value="" maxlength="20" />
</p>
<p>
<label for="ezs_password">Confirm Password</label>
<input type="password" id="ezs_password_confirm" name="ezs_password_confirm" value="" maxlength="20" />
</p>
<p>
<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
<input type="submit" value="Add User" />
</p>
</fieldset>
</form>
<script type="text/javascript">
$(document).ready(function() {
	$("#addUserForm").submit( function () {
		if ($('#ezs_password').val() !== $('#ezs_password_confirm').val()) {
	        alert('Passwords do not match!');
    	    return false;
		}
    });
});
</script>
</body>
</html>