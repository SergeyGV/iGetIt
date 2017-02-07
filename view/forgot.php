<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt</h1></header>

		<main>
			<h1>Forgot Password</h1>
			<fieldset>
				<form method="post">
					<legend>Login</legend>
					<?php 
						if($_SESSION['recovery']=="0"){
							echo('<p> <label for="user">Username</label><input type="text" name="user"></input> </p>');
							echo('<input type="submit" name="login" value="Back to Login"/>');
							echo('<input  type="submit" name="userchecker" value ="Check Username"/>');
						}

						if($_SESSION['recovery']=="1"){
							echo('<p> <label for="user">Username</label><label for="user">: '.$_SESSION['username'].'</label></p>');
							echo('<p> <label for="user">Security Question</label><label for="user">: '.security_check($_SESSION['username'],0).'</label></p>');
							echo('<p> <label for="password">Securuty Answer</label><input type="password" name="password"></input> </p>');
							echo('<input type="submit" name="login" value="Back to Login"/>');
							echo('<input  type="submit" name="passwordchecker" value ="Check Answer" />');
						}
					?>
					
				</form>
			</fieldset>
		</main>

	</body>
</html>