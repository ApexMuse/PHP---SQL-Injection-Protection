<html>

	<head>
		<link rel="stylesheet" type="text/css" href="styles.css">

		<title>Final Exam Registration</title>			

		<!-- Check to see if passwords are same, notify user -->
		<script type="text/javascript">			
    			function checkPass() {    		
    				var pass1 = document.getElementById('pass1');
    				var pass2 = document.getElementById('pass2');    		
    				var message = document.getElementById('confirmMessage');    		
    		
    				if(pass1.value == pass2.value){        		
        				pass2.style.backgroundColor = "#7CFC00";
        				message.style.color = "#006400";
					message.style.fontWeight = "bold";
        				message.innerHTML = "Passwords Match!"
    				}
				else {        		
        				pass2.style.backgroundColor = "#ff633d";
        				message.style.color = "#8B0000";
					message.style.fontWeight = "bold";
        				message.innerHTML = "Passwords Do Not Match!"
    				}
			} // End of checkPass() function
		</script>
	</head>

	<body>
		<div class="form">
			<h2>Final Exam Registration Form</h2>
		
  			<form id="register" action="verify.php" method="post" name="register">
				<table align="center">
					<tr>
						<td align="right"><label for="username"><strong>Username:</strong></label></td>
						<td><input id="username" type="text" name="username" size="45" placeholder=" 6 - 15 characters incl. letters, digits, & underscore" autofocus pattern="^[0-9a-zA-Z_]{6,15}$" required /></td>
					<tr>
					<tr>
						<td align="right"><label for="email"><strong>Email:</strong></label></td>
						<td><input id="email" type="email" name="email" size="45" placeholder=" yourname@email.com" pattern="^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$" required /></td>
					</tr>
					<tr>
						<td align="right"><label for="pass1"><strong>Password:</strong></label></td>
						<td><input id="pass1" type="password" name="password" size="45" placeholder=" 6 - 15 characters incl. char's on top of keys 1-8" pattern="^[a-zA-Z0-9-_\!\@\#\$\%\^&\*]{6,15}+$" required /></td>
					</tr>
					<tr>
						<td align="right"><label for="pass2"><strong>Confirm Password:</strong></label></td>
						<td><input id="pass2" type="password" name="confirm" size="45" onkeyup="checkPass(); return false;" pattern="^[a-zA-Z0-9-_\!\@\#\$\%\^&\*]{5,16}+$" required /></td>
					</tr>				
				</table>

				<span id="confirmMessage" class="confirmMessage"></span>

				<br /><br />

				<input type="hidden" name="form_submitted" value="1"/>
				<input id="reset" type="reset" value="Reset Fields" />
				&#160;&#160;&#160;&#160;		
  				<input id="submit" type="submit" value="Submit Registration" />
  			</form>		
		</div>
 	</body>
</html>
