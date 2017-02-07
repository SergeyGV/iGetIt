<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="3">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>
			span {
				background-color:green; 
				display:block; 
				text-decoration:none; 
				padding:20px; 
				color:white; 
				text-align:center;
			}
		</style>
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt (instructor)</h1></header>
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
					<?php 
						$votedYes=tally_votes($_SESSION['currentClass'],0);
						$votedNo=tally_votes($_SESSION['currentClass'],1);
						if($votedYes==-1 || $votedNo==-1){
							$error_msg="*Can't connect, please try again later :\ ";
						}else{
							$total=$votedYes+$votedNo;
							$perYes=$votedYes/$total*100;
							$perNo=$votedNo/$total*100;	
							echo('<span style="background-color:green; width:'.$perYes.'%;" >i Get It</span>');	
							echo('<span style="background-color:red;  width:'.$perNo.'%;"  >i Don\'t Get It</span>');
						}
					?>
					</fieldset>
			</form>
			<form method="post">
				<input type="submit" name="clearVotes" value="Clear Votes"/>
            </form>
		</main>
		<footer>
		</footer>
	</body>
</html>

