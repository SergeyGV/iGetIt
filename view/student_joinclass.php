<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt (student)</h1></header>
		<nav>
			<form method="post">
  				<!--<input type="submit" name="classList" value="Class List"/>-->
				<input type="submit" name="profile" value="Profile"/>
                <input type="submit" name="logout" value="Logout"/>
            </form>
		</nav>
		<main>
			<h1>Class</h1>
			<form method="post">
				<fieldset>
					<legend>Current Classes</legend>
					<select name="joinClass">
						 <?php if(get_courses()==-1)$error_msg="*Couldn't load the course list :( "; ?>
					</select>
   					<p> <label for="code">code</label><input type="text" name="code"></input> </p>
                    <p> <input type="submit" name="joinSubmit" value="Enter Course"/>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

