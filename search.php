<?php

	session_start();

	$productName = mysql_real_escape_string($_POST['productName']);

	if(!empty($productName)){
		
		$pdo = new PDO('mysql:host=localhost;dbname=db1','root','student');
		$sql = "SELECT * FROM product WHERE productName LIKE ('%".$productName."%')";
		$stmt = $pdo->prepare($sql);
    		$stmt->execute();
		$rows = $stmt->fetchAll();	

		if(!empty($rows)){
			echo "<table border='1'><tr><th>Product Name</th><th>Price</th></tr>";
			foreach($rows as $row){
?>

				<tr>
					<td> <?php echo $row['productName']; ?> </td>
					<td> <?php echo '$'.$row['price']; ?> </td>
				</tr>


<?php
			} // End of foreach()
			echo "</table>";
			$pdo = null;
			
		} // End of if statement
		else{
			$_SESSION['message'] = 'No '.$productName.' products found.';
			header('Location: http://localhost/searchForm.php');
		}
	} // End of if statement
	else{
		$_SESSION['message'] = 'Please enter a product name.';
		header('Location: http://localhost/searchForm.php');
	}

?>
