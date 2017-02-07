<?php

	session_save_path("sess");
	session_start();
	
	// get all needed functions
	require_once "model/model.php";
	
	$view="";
	$error_msg="";
	$feedback="";
	
	// setup the session for the first time
	if( ! isset($_SESSION['state']) ){
		$_SESSION['state']="login";
	}

	$temp="";

	switch($_SESSION['state']){
		
		case "login":

			$_SESSION['username']="";
			$_SESSION['recovery']="0";
			 $_SESSION['loadprofilename']="";
                                $_SESSION['loadprofilefirst']="";
                                $_SESSION['loadprofilelast']="";
                                $_SESSION['loadprofileemail']="";
                                $_SESSION['loadprofilesecq']="";
	
			// load the login page
			$view="login.php";

			// forgot password
			if(isset($_REQUEST['forgot'])){
				$_SESSION['state']="forgot";
				$view="forgot.php";
				$_SESSION['loadclassnameforinsta']="";
				break;
			}

			// load sign-up page
			if(isset($_REQUEST['SignUp'])){
				$_SESSION['state']="profile";
				$view="profile.php";
				$_SESSION['loadclassnameforinsta']="";	
				break;
			}

			// make sure login is pressed
			if(!isset($_REQUEST['login'])){
				break;
			}

			// validate and set errors
			if(empty($_REQUEST['user']) || empty($_REQUEST['password'])){
				$_SESSION['loadusertologin']=$_REQUEST['user'];
				$error_msg="*Please fill-in all of the above fields.";
				break;
			}

			// check username and password
			$temp = check_input($_REQUEST['user'], $_REQUEST['password']);
			
			// load instructor_createclass
			if($temp==-1){
				$error_msg="*Incorrect username or password!";
				break;
			}
			
			// load instructor_createclass
			if($temp==0){
				$_SESSION['state']="instructor_createclass";
				$view="instructor_createclass.php";
				$_SESSION['usertype']=0;
				$_SESSION['loadusertologin']="";
			}
			
			// load student_joinclass
			if($temp==1){
				$_SESSION['state']="student_joinclass";
				$view="student_joinclass.php";
				$_SESSION['usertype']=1;
				$_SESSION['loadusertologin']="";
			}

			$_SESSION['username']=$_REQUEST['user'];

			break;
			
		case "instructor_createclass":
			
			// load instructor_createclass
			$view="instructor_createclass.php";
			
			if(isset($_REQUEST['createSubmit'])){
				$temp=add_course($_REQUEST['class'],$_REQUEST['code']);

				// save the class name
				$_SESSION['loadclassnameforinsta']=$_REQUEST['class'];

				// can't connect
				if($temp==-3){
					$error_msg="*Can't connect, please try again later :\ ";
				}

				// empty fields error
				if($temp==-2){
					$error_msg="*Please fill-in both the course name and the course code.";
				}

				// course already exists
				if($temp==-1){
					$error_msg="*The course already exists :S ";
				}

				// the class got added
				if($temp==0){
					$feedback="Class successfully added :D ";
					$_SESSION['loadclassnameforinsta']="";
				}

				break;
			}
			
			if(isset($_REQUEST['joinSubmit'])){
				$temp=validate_course_code($_REQUEST['joinClass'],$_REQUEST['code']);

				// can't connect
				if($temp==-2){
					$error_msg="*Can't connect, please try again later :\ ";
					break;
				}

				// incorrect course code
				if($temp==-1){
					$error_msg="*Incorrect course code entered :/ ";
					break;
				}

				$_SESSION['state']="instructor_currentclass";
				$view="instructor_currentclass.php";
				$_SESSION['currentClass']=$_REQUEST['joinClass'];
				$_SESSION['loadclassnameforinsta']="";

				break;
			}

			// go to profile page
            if(isset($_REQUEST['profile'])){
				$_SESSION['state']="updateProfile";
				$view="updateProfile.php";
				$_SESSION['loadclassnameforinsta']="";
				break;
			}
			
			// logout
			if(isset($_REQUEST['logout'])){
				$_SESSION['state']="login";
				$view="login.php";
				$_SESSION['username']="";
				$_SESSION['loadclassnameforinsta']="";
				break;
			}

			break;
		
		case "student_joinclass":
			
			// load student_joinclass
			$view="student_joinclass.php";

			if(isset($_REQUEST['joinSubmit'])){
				$temp=validate_course_code($_REQUEST['joinClass'],$_REQUEST['code']);

				// can't connect
				if($temp==-2){
					$error_msg="*Can't connect, please try again later :\ ";
					break;
				}

				// incorrect course code
				if($temp==-1){
					$error_msg="*Incorrect course code entered :/ ";
					break;
				}

                $_SESSION['state']="student_currentclass";
                $view="student_currentclass.php";
                $_SESSION['currentClass']=$_REQUEST['joinClass'];

        		break;
            }

            // go to profile page
            if(isset($_REQUEST['profile'])){
				$_SESSION['state']="updateProfile";
				$view="updateProfile.php";	
				break;
			}

			// logout
			if(isset($_REQUEST['logout'])){
                $_SESSION['state']="login";
                $view="login.php";
                $_SESSION['username']="";
                break;
            }
		
			break;
			
		case "instructor_currentclass":
			
			// load instructor_currentclass
			$view="instructor_currentclass.php";

			// clear the list of students
			if(isset($_REQUEST['clearVotes'])){
				if(clear_votes($_SESSION['currentClass'])==-1){
					$error_msg="*Can't connect, please try again later :\ ";
					break;
				}
			}

			// go to profile page
            if(isset($_REQUEST['profile'])){
				$_SESSION['state']="updateProfile";
				$view="updateProfile.php";	
				break;
			}

			// go to class list
			if(isset($_REQUEST['classList'])){
                $_SESSION['state']="instructor_createclass";
				$view="instructor_createclass.php";
                break;
            }

            // logout
			if(isset($_REQUEST['logout'])){
                $_SESSION['state']="login";
                $view="login.php";
                $_SESSION['username']="";
                break;
            }

			break;

		case "student_currentclass":
			
			// load student_currentclass
			$view="student_currentclass.php";

			// go to profile page
            if(isset($_REQUEST['profile'])){
				$_SESSION['state']="updateProfile";
				$view="updateProfile.php";	
				break;
			}
			
			// go to class list
			if(isset($_REQUEST['classList'])){
                $_SESSION['state']="student_joinclass";
				$view="student_joinclass.php";
                break;
            }

            // logout
			if(isset($_REQUEST['logout'])){
                $_SESSION['state']="login";
                $view="login.php";
                $_SESSION['username']="";
                break;
            }
				
			// vote i get it
			if(isset($_REQUEST['igetit'])){
				$temp=submit_vote($_SESSION['currentClass'],$_SESSION['username'],0);
			}
		
			// vote i dont get it
			if(isset($_REQUEST['idontgetit'])){
				$temp=submit_vote($_SESSION['currentClass'],$_SESSION['username'],1);
			}

			// cannot connect
			if($temp==-2){
				$error_msg="*Can't connect, please try again later :\ ";
			}

			// already voted
			if($temp==-1){
				$error_msg="*You already voted, wait for the instructor's cue to vote again.";	
			}

			// thank you for the vote bruh
			if($temp==0){
				$feedback="Thank you for the vote, now wait for the instructor's cue to vote again :) ";
			}

			break;
			
		case "profile":
			
			// load student_currentclass
			$view="profile.php";

			// login in profile
			if(isset($_REQUEST['login'])){
                $_SESSION['state']="login";
                $view="login.php";
                $_SESSION['username']="";

                $_SESSION['loadprofilename']="";
				$_SESSION['loadprofilefirst']="";
				$_SESSION['loadprofilelast']="";
				$_SESSION['loadprofileemail']="";
				$_SESSION['loadprofilesecq']="";
                break;
            }

            // make sure create was pressed
			if(!isset($_REQUEST['create']))
				break; 
			
			$_SESSION['loadprofilename']=$_REQUEST['user'];
			$_SESSION['loadprofilefirst']=$_REQUEST['firstName'];
			$_SESSION['loadprofilelast']=$_REQUEST['lastName'];
			$_SESSION['loadprofileemail']=$_REQUEST['email'];
			$_SESSION['loadprofilesecq']=$_REQUEST['sec_q'];
			
			// validate and set errors
			if(empty($_REQUEST['user']) || empty($_REQUEST['password']) || empty($_REQUEST['firstName']) || empty($_REQUEST['lastName']) || empty($_REQUEST['email']) || !isset($_REQUEST['type']) || empty($_REQUEST['sec_q']) || empty($_REQUEST['sec_a'])){
				$error_msg="*Please fill-in all of the above fields.";
				break;
			}

			// try to create a profile
			$temp=add_profile($_REQUEST['user'],$_REQUEST['password'],$_REQUEST['firstName'],$_REQUEST['lastName'],$_REQUEST['email'],$_REQUEST['type'],$_REQUEST['sec_q'],$_REQUEST['sec_a']);
			
			// cannot connect
			if($temp==-2){
				$error_msg="*Can't connect, please try again later :\ ";
				break;
			}

			// username already exists
			if($temp==-1){
				$error_msg="*Username already exists.";
				break;
			}

			$_SESSION['username']=$_REQUEST['user'];
			$temp=$_REQUEST['type'];
			
			// load instructor_createclass
            if($temp=="instructor"){
                $_SESSION['state']="instructor_createclass";
                $view="instructor_createclass.php";
                $_SESSION['usertype']=0;
            }

            // load student_joinclass
            if($temp=="student"){
                $_SESSION['state']="student_joinclass";
                $view="student_joinclass.php";
                $_SESSION['usertype']=1;
            }

		 $_SESSION['loadprofilename']="";
                                $_SESSION['loadprofilefirst']="";
                                $_SESSION['loadprofilelast']="";
                                $_SESSION['loadprofileemail']="";
                                $_SESSION['loadprofilesecq']="";
			break;

		case "updateProfile":
			
			// load update profile page
			$view="updateProfile.php";

			// go back to class list
			if(isset($_REQUEST['classList'])){
				if($_SESSION['usertype']==1){
                	$_SESSION['state']="student_joinclass";
					$view="student_joinclass.php";
				}
				if($_SESSION['usertype']==0){
                	$_SESSION['state']="instructor_createclass";
					$view="instructor_createclass.php";
				}
				$_SESSION['loadprofilefirst']="";
				$_SESSION['loadprofilelast']="";
				$_SESSION['loadprofileemail']="";
				$_SESSION['loadprofilesecq']="";
                break;
            }

            // make sure create was pressed
			if(!isset($_REQUEST['create']))
				break;        

			$_SESSION['loadprofilefirst']=$_REQUEST['firstName'];
			$_SESSION['loadprofilelast']=$_REQUEST['lastName'];
			$_SESSION['loadprofileemail']=$_REQUEST['email'];
			$_SESSION['loadprofilesecq']=$_REQUEST['sec_q'];
			
			// validate and set errors
			if(empty($_REQUEST['password']) || empty($_REQUEST['firstName']) || empty($_REQUEST['lastName']) || empty($_REQUEST['email']) || empty($_REQUEST['sec_q']) || empty($_REQUEST['sec_a'])){
				$error_msg="*Please fill-in all of the above fields.";
				break;
			}

            // try to update the profile
			$temp=update_profile($_SESSION['username'],$_REQUEST['password'],$_REQUEST['firstName'],$_REQUEST['lastName'],$_REQUEST['email'],$_REQUEST['sec_q'],$_REQUEST['sec_a']);

			// cannot connect
			if($temp==-2){
				$error_msg="*Can't connect, please try again later :\ ";
				break;
			}

			// load instructor_createclass
			if($_SESSION['usertype']==1){
            	$_SESSION['state']="student_joinclass";
				$view="student_joinclass.php";
			}

			// load student_joinclass
			if($_SESSION['usertype']==0){
            	$_SESSION['state']="instructor_createclass";
				$view="instructor_createclass.php";
			}

			 $_SESSION['loadprofilename']="";
                                $_SESSION['loadprofilefirst']="";
                                $_SESSION['loadprofilelast']="";
                                $_SESSION['loadprofileemail']="";
                                $_SESSION['loadprofilesecq']="";
				
			break;

		case "forgot":
			
			// load forgot password page
			$view="forgot.php";

			// go back to login page
			if(isset($_REQUEST['login'])){
				$view="login.php";
				$_SESSION['state']="login";
				$_SESSION['username']="";
				$_SESSION['recovery']="0";
				break;
			}

			if(isset($_REQUEST['userchecker'])){
				// need some info here
				if(empty($_REQUEST['user'])){
					$error_msg="*Please fill-in the username field.";
					break;
				}

				// check the username
				$temp=security_check($_REQUEST['user'],0);

				// cannot connect
				if($temp==-2){
					$error_msg="*Can't connect, please try again later :\ ";
					break;
				}

				// username does not exist
				if($temp==-1){
					$error_msg="*Username does not exist.";
					break;
				}

				$_SESSION['username']=$_REQUEST['user'];
				$_SESSION['recovery']="1";

				break;
			}

			if(isset($_REQUEST['passwordchecker'])){
				// need some info here
				if(empty($_REQUEST['password'])){
					$error_msg="*Please fill-in your answer to the security question.";
					break;
				}
				
				// check the username
				$temp=security_check($_SESSION['username'],1);

				// cannot connect
				if($temp==-2){
					$error_msg="*Can't connect, please try again later :\ ";
					break;
				}

				// check password
				if($_REQUEST['password']==$temp){
					$feedback="Your password is: ".security_check($_SESSION['username'],2);
				}else{
					$error_msg="*Your answer is wrong, please try again :\ ";
				}

				break;			
			}

			break;

}
	
	require_once "view/$view";
	echo('<h4 style="color:red";>'.$error_msg.'</h4>');
	echo('<h4 style="color:green";>'.$feedback.'</h4>');
?>
