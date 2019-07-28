<?php 
	session_start();

	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
		header("Location: main.php");
	}

	require_once "meta.php";

	if(!empty($_POST)) {
		$err = [];

		$name = htmlentities(mysqli_real_escape_string($link, $_POST["username"]));
		$queryName = mysqli_query($link, "SELECT login FROM users WHERE login='$name'");
		$queryPass = mysqli_query($link, "SELECT password FROM users WHERE login='$name'");

		if(mysqli_num_rows($queryName) > 0) {
			if(password_verify($_POST["password"], (string) $queryPass)) {
				session_start();
				$_SESSION["loggedin"] = true;
				$_SESSION["username"] = $queryName["login"];
				header("Location: main.php");
			} else $err[] = "Invalid password!";
		} else $err[] = "Invalid login!";

		foreach ($err as $key) {
			echo "<p class='error'>$key</p>";
		}
	}

	mysqli_close($link);
?>
<form action="login.php" method="post">
	<input type="text" name="username" placeholder="Username" required="required" /><br/>
	<input type="password" name="password" placeholder="Password" required="required" /><br/>
	<input type="submit" value="Sign in!" /><br/>
	<a href="register.php">Sign up</a>
</form>