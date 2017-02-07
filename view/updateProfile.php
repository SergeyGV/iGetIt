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
			<h1>Update Profile</h1>
			<form method="post">
				<fieldset>
					<legend>Edit Profile</legend>
					<p> <label for="password">Password</label><input type="password" name="password"></input> </p>
					<p> <label for="firstName">First Name</label><input type="text" name="firstName" value=<?php echo($_SESSION['loadprofilefirst'])?>></input> </p>
					<p> <label for="lastName">Last Name</label><input type="text" name="lastName" value=<?php echo($_SESSION['loadprofilelast'])?>></input> </p>
					<p> <label for="email">email</label><input type="text" name="email" value=<?php echo($_SESSION['loadprofileemail'])?>></input> </p>
					<p> <label for="sec_q">security question</label><input type="text" name="sec_q" value=<?php echo($_SESSION['loadprofilesecq'])?>></input> </p>
					<p> <label for="sec_a">security answer</label><input type="text" name="sec_a"></input> </p>
					<input type="submit" name="create" value="Submit"/>
					<input type="submit" name="classList" value="Class List"/>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

