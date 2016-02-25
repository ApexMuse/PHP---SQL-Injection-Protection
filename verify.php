<?php

	// Validate Passwords
	function validatePassword($tempPassword, $tempConfirm) {
		global $errorCount;		
		if ($tempPassword != $tempConfirm) {
			echo "<p>Your password and confirmation password do not match.</p>";
			++$errorCount;
			$returnPassword = "";
		}
		else {
			$returnPassword = $tempPassword;
		}
		return $returnPassword;
	} // End of validatePassword() function


	// Create variables for DB login
	$dsn = 'mysql:dbname=Email_Activation;host=127.0.0.1';
	$user = 'root';
	$password = 'student';

	// Create PDO object, use exception if there is a connection error
	try {
		$pdo = new PDO($dsn, $user, $password);
	} 
	catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

	
	if ($_POST['form_submitted'] == '1') {

		## User is registering; validate, secure, and insert data until we can activate it

		// Create a random activation key
		$activationKey =  mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand();

		// Use mysql_real_escape_string() to process inputs
		$username = mysql_real_escape_string(trim($_POST['username']));
		$email = mysql_real_escape_string(trim($_POST['email']));

		// Validate passwords, process with mysql_real_escape_string(), and then encrypt it using MD5
		$password = md5(mysql_real_escape_string(validatePassword($_POST['password'], $_POST['confirm'])));	
		
		// If there are validation errors, tell the user to re-enter data
		if ($errorCount > 0) {
			echo "Please use the \"Back\" button to re-enter the data.<br />";
		}
		else {
			## Check to make sure the username and email do not already exist in the DB

			// Use prepare() to prepare your SQL statement
			$checksql = "SELECT * FROM users WHERE username = :username OR email = :email";
			$checkDB = $pdo->prepare($checksql);
			$checkDB->bindParam(":username", $username);
			$checkDB->bindParam(":email", $email);
			$checkDB->execute();
			$count = $checkDB->rowCount();

			if ($count > 0) {
				echo "A user already exists with that username/email.<br />";
				echo "<p>Please use the \"Back\" button to re-enter the data.</p>";
			}
			else {
				## Insert user info into the DB 
				
				$sql	= "INSERT INTO users (username, password, email, activationkey, status) 
			
			  	   	   VALUES 
		
			  	   	   (:username, :password, :email, '$activationKey', 'verify')";
			
				// Use prepare() to prepare your SQL statement
				$sth = $pdo->prepare($sql);
				$sth->bindParam(":username", $username);
				$sth->bindParam(":password", $password);
				$sth->bindParam(":email", $email);
				$sth->execute();					

				## Send activation Email
				$to = $email;
				$subject = "Final Exam Registration";
				$message = "Welcome to our website! You, or someone using your email address, has completed \nregistration for the final exam. You can complete registration by clicking the following \nlink: http://localhost/verify.php?$activationKey \n\nIf this is an error, ignore this email and you will be removed from our mailing list. \n\nRegards, \n\nThe Final Exam Team";

				$headers = 'From: noreply@FinalExam.com' . "\n" .
    						 'Reply-To: noreply@FinalExam.com' . "\n" .
    						 'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);

				echo "An email has been sent to <strong>$_POST[email]</strong> with an activation key.<br /><br />Please click on the link in your email to complete registration.";

			} // End of else statement
		} // End of else statement
 	} // End of if statement
	else{

		## User isn't registering; verify code and change activation code to null, status to activated on success

		$queryString = mysql_real_escape_string($_SERVER['QUERY_STRING']);

		// Use prepare() to prepare your SQL statement
		$query = "SELECT * FROM users WHERE activationkey = :key";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(":key", $queryString);		
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);		

    		if (!empty($result)){

       		echo "Congratulations!<br /><br /><strong>" . $result["username"] . "</strong> is now the proud new owner of a Final Exam account.";

			// Use prepare() to prepare your SQL statement
       		$sql="UPDATE users SET activationkey = '', status='activated' WHERE (id = $result[id])";   
			$sth = $pdo->prepare($sql);
			$sth->execute();			    			

    		} 
		else {
			echo "This account has already been activated.";
		}

  	} // End of else statement
?>
