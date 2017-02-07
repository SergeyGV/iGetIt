<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>
			td a {
				background-color:green; 
				display:block; 
				width:200px; 
				text-decoration:none; 
				padding:20px; 
				color:white; 
				text-align:center;
			}
		</style>
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt (student)</h1></header>
		<nav>
			<form method="post">
  				<input type="submit" name="classList" value="Class List"/>
				<input type="submit" name="profile" value="Profile"/>
                <input type="submit" name="logout" value="Logout"/>
            </form>
		</nav>
		<main>
			<h1>Class</h1>
			<form method="post">
				<fieldset>
					<legend><?php echo($_SESSION['currentClass']); ?></legend>
					<table style="width:100%;">
						<tr>
							<td><input type="submit" name="igetit" style="background-color:green;width:200px;height:80px;" value="i Get It"/></td>
							<td><input type="submit" name="idontgetit" style="background-color:red;width:200px;height:80px;" value="i Don't It"/></td>
						</tr>
					</table>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

