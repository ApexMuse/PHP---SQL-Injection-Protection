<?php
	session_start();
	if($_SESSION['message'] != null){
		echo $_SESSION['message']."<br /><br />";
		unset($_SESSION['message']);
	}
?>

<form action="http://localhost/search.php" method="POST">
	
	Product Name: <input name="productName" type="text" /><br /><br />
	<input type="submit" value="Search" />

</form>

