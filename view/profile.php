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
			<h1>New Profile</h1>
			<form method="post">
				<fieldset>
					<legend>Edit Profile</legend>
					<p> <label for="user">User</label>    <input type="text" name="user" value=<?php echo($_SESSION['loadprofilename']);?>></input> </p>
					<p> <label for="password">Password</label><input type="password" name="password"></input> </p>
					<p> <label for="firstName">First Name</label><input type="text" name="firstName" value=<?php echo($_SESSION['loadprofilefirst']);?>></input> </p>
					<p> <label for="lastName">Last Name</label><input type="text" name="lastName" value=<?php echo($_SESSION['loadprofilelast']);?>></input> </p>
					<p> <label for="email">email</label><input type="text" name="email" value=<?php echo($_SESSION['loadprofileemail']);?>></input> </p>
					<p> <label for="sec_q">security question</label><input type="text" name="sec_q" value=<?php echo($_SESSION['loadprofilesecq'])?>></input> </p>
					<p> <label for="sec_a">security answer</label><input type="text" name="sec_a"></input> </p>
					<p> <label for="type">type</label>
						<input type="radio" name="type" value="instructor">instructor</input> 
						<input type="radio" name="type" value ="student">student</input> 
					</p>
					<input type="submit" name="create" value="Submit"/>
					<input type="submit" name="login" value="Back to Login"/>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

