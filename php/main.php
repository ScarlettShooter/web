<?php
	session_start();

	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
		header("Location: login.php"); exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Main</title>
</head>
<body>
	<?php
		echo "<b>Hello ".htmlspecialchars($_SESSION["username"]).", nice to meet you!</b>";
	?>
	<a href="logout.php">Do you want to log out?</a>
	
</body>
</html>