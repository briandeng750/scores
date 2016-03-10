<?php
session_start();
$loginMsg = $_SESSION['login_message'];
if ($loginMsg == null) $loginMsg = '';
?>
<html>
<head>
<title>EZScore Login</title>
</head>

<body>
<h2>Login Here</h2>
<form action="login_submit.php" method="post">
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
<input type="submit" value="Login" />
</p>
</fieldset>
</form>
<div><span><?=$loginMsg?></span></div>
</body>
</html>