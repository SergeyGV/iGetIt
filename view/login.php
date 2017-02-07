<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt</h1></header>
		<!--
		<nav>
			<ul>
			<li> <a href="">Class</a>
			<li> <a href="">Profile</a>
			<li> <a href="">Logout</a>
			</ul>
		</nav>
		-->
		<main>
			<h1>Login</h1>
			<form method="post">
				<fieldset>
					<legend>Login</legend>
					<p> <label for="user">User</label><input type="text" name="user" value=<?php echo($_SESSION['loadusertologin']);?>></input> </p>
					<p> <label for="password">Password</label><input type="password" name="password"></input> </p>
					<input type="submit" value="Login" name="login"/>
					<input  type="submit" value ="SignUp" name="SignUp"/>
					<input  type="submit" value ="Forgot Password" name="forgot"/>
				</fieldset>
			</form>	
		</main>
		<footer>
		</footer>
	</body>
</html>

