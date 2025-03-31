
    <?php 
	include 'header.html';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $display_form = true;

    if (isset($_POST['login'])) {

	require_once "sql_login.php";
	$trimmed = array_map("trim", $_POST);
	
	if (!empty($_POST['email'])) {
	    $email = $trimmed['email'];
	} else {
	    echo "<p>You forgot to enter your email address!</p>";
	}

	if (!empty($_POST['password'])) {
	    $password = $trimmed['password'];
	} else {
		$password = FALSE;
	    echo "<p>You forgot to enter your password!</p>";
	}

	if ($email && $password) {

	    try {
		$pdo = new PDO($dsn, $mampUser, $mampPassword);
	    } catch (PDOException $e) {
		die("Fatal Error - Could not connect to the database</body></html>" );
	    }

	   
		$query_user = "SELECT user_id, first_name, email, pass FROM cv_users_table WHERE email='$email'";
		$result = $pdo->query($query_user);		
	

	    if ($result) {
		if ($result->rowCount() == 1) {
		    $row = $result->fetch(PDO::FETCH_NUM);
		    if (password_verify($password, $row[3])) {
			$_SESSION['user_id'] = $row[0];
			$_SESSION['name'] = $row[1];
			echo htmlspecialchars("Hi {$row[1]}, you are now logged in as '{$row[2]}'");
			$display_form = false;
		    } else {
			echo "<p>Account not found</p>";
		    }
		}
	    } else {
		echo "<p>Account not found</p>";
	    }
	} else {
	    echo "<p>Please try again</p>";
	}
    }

    if ($display_form) {
    ?>
      <form name="log_in_form" action="log_in.php" method="post" autocomplete="off">
	<p>
	  <label for="email">Email Address:</label>
	  <input type="text" id="email" name="email"/>
	</p>
	<p>
	  <label for="password">Password:</label>
	  <input type="password" id="password" name="password"/>
	</p>
	<button type="submit" id="login" name="login">Log In</button>
      </form>

      <p><a href="index.php">Home Page</a></p>
    <?php
    } else {
    ?>
	  <p><a href="valuation.php">Valuate Car</a></p>
      <p><a href="index.php">Home Page</a></p>
    <?php
    }
    ?>
  </body>
</html>
