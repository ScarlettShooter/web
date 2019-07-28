<?php
	session_start();

	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
		header("Location: main.php");
	}

	require_once "meta.php";

	if(!empty($_POST)) {
		$err = [];
		$name = htmlentities(mysqli_real_escape_string($link, $_POST["username"]));
		$email = htmlentities(mysqli_real_escape_string($link, $_POST["email"]));
		if(!preg_match("/^[A-Za-z0-9]$/", $name) && strlen($name) < 3 && strlen($name) > 30) {
			$err[] = "Invalid login";
		}
		if(!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/", $email)) {
			$err[] = "Invalid email";
		}
		$queryName = mysqli_query($link, "SELECT login FROM users WHERE login='$name'");

		if(mysqli_num_rows($queryName) > 0) {
			$err[] = "Login does exist";
		}
		$queryEmail = mysqli_query($link, "SELECT login FROM users WHERE login='$email'");

		if(mysqli_num_rows($queryEmail) > 0) {
			$err[] = "E-mail does exist";
		}
		if($_POST["password"] !== $_POST["password_verify"]) {
			$err[] = "Passwords doesn't match";
		}
		if(count($err) === 0) {
			$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
			$query = mysqli_query($link, "INSERT INTO users SET login='$name', email='$email', password='$password'");
			header("Location: login.php");
		}
		foreach ($err as $key) {
			echo "<p class='error'>$key</p>";
		}

		mysqli_close($link);
	}
?>
<form action="register.php" method="post">
	<input type="text" name="username" placeholder="Username" />
	<input type="text" name="email" placeholder="E-mail">
	<input type="password" name="password" placeholder="Enter your password" />
	<input type="password" name="password_verify" placeholder="Enter your password again" />
	<button type="submit">Sign up!</button>
</form>