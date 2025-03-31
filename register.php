<html>
  <head>
    <meta charset = "utf-8" />
    <title>CarVal | Register</title>
  </head>
  <body>
    <h1>CarVal</h1>
    <h2>The Car Valuation Tool!</h2>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $display_form = true;
    $first_name_regexp = '/^[A-Z \'.-]{2,20}$/i';
    $last_name_regexp = '/^[A-Z \'.-]{2,40}$/i';
    $email_regexp = '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/';
    $password_regexp = '/^\w{6,20}$/';

    if (isset($_POST['register'])) {
	require_once 'sql_login.php';

	try {
	    $pdo = new PDO($dsn, $mampUser, $mampPassword);
	} catch (PDOException $e) {
	    die("Fatal Error - Could not connect to the database</body></html>" );
	}

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$trimmed = array_map('trim', $_POST);

	if (validate_form($first_name, $last_name, $email, $password)) {
	    $query_email = "SELECT user_id FROM cv_users_table WHERE email='$email'";
	    try {
		$pdo = new PDO($dsn, $mampUser, $mampPassword);
	    } catch (PDOException $e) {
		die("Fatal Error - Could not connect to the database</body></html>");
	    }

	    $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
	    $stmt->execute(['cv_users_table']);
	    $table_exists = $stmt->rowCount() > 0;

	    if (!$table_exists) {
		$query_create_table = file_get_contents('create_cv_users_table.sql');
		$pdo->exec($query_create_table);
	    }

	    $result = $pdo->query($query_email);

	    if (!$result->rowCount()) {
		$hash = password_hash($password, PASSWORD_DEFAULT);

		if (add_user($pdo, $email, $hash, $first_name, $last_name, date("Y-m-d"))) {
		    echo '<h3>Thank you for registering with CarVal!</h3>';
		    echo '<a href="index.html">Home Page</a>';
		    exit();
		} else {
		    echo '<p>You could not be registered due to a system error!</p>';
		}
	    } else {
		echo '<p>That email address has already been registered.</p>';
	    }
	} else {
	    echo '<p>Please re-enter your passwords and try again.</p>';
	}
    }

    if ($display_form) {
    ?>
      <form name="registration_form" action="register.php" method="post" autocomplete="off">
	<p>
	  <label for="first_name">First Name:</label>
	  <input type="text" id="first_name" name="first_name"/>
	</p>
	<p>
	  <label for="last_name">Last Name:</label>
	  <input type="text" id="last_name" name="last_name"/>
	</p>
	<p>
	  <label for="email">Email Address:</label>
	  <input type="text" id="email" name="email"/>
	</p>
	<p>
	  <label for="password">Password:</label>
	  <input type="password" id="password" name="password"/>
	</p>
	<p>
	  <label for="confirm_password">Confirm Password:</label>
	  <input type="password" id="confirm_password" name="confirm_password"/>
	</p>
	<button type="submit" id="register" name="register">Register</button>
      </form>

      <a href="index.html">Home Page</a>
    <?php
    }

      function validate_form($first_name, $last_name, $email, $password) {
	  global $first_name_regexp, $last_name_regexp, $email_regexp, $password_regexp, $trimmed;
	  $first_name_exists = $last_name_exists = $email_exists = $password_exists = false;

	  if (preg_match($first_name_regexp, $trimmed['first_name'])) {
	      $first_name = $trimmed['first_name'];
	  } else {
	      echo '<p>Please enter your first name!</p>';
	  }

	  if (preg_match($last_name_regexp, $trimmed['last_name'])) {
	      $last_name = $trimmed['last_name'];
	  } else {
	      echo '<p class="error">Please enter your last name!</p>';
	  }
	  
	  if (preg_match($email_regexp, $trimmed['email'])) {
	      $email = $trimmed['email'];
	  } else {
	      echo '<p class="error">Please enter a valid email address!</p>';
	  }

	  if (preg_match($password_regexp, $trimmed['password']) ) {
	      if ($trimmed['password'] == $trimmed['confirm_password']) {
		  $password = $trimmed['password'];
	      } else {
		  echo '<p class="error">Your password did not match the confirmed password!</p>';
	      }
	  } else {
	      echo '<p class="error">Please enter a valid password!</p>';
	  }

	  return $first_name && $last_name && $email && $password;
      }

      function add_user($pdo, $email, $hash, $first_name, $last_name, $registration_date) {
	  $stmt = $pdo->prepare('INSERT INTO cv_users_table(first_name, last_name, email, pass, registration_date) VALUES(?,?,?,?,?)');
	  $stmt->bindParam(1, $first_name, PDO::PARAM_STR, 40);
	  $stmt->bindParam(2, $last_name, PDO::PARAM_STR, 80);
	  $stmt->bindParam(3, $email, PDO::PARAM_STR, 80);
	  $stmt->bindParam(4, $hash, PDO::PARAM_STR, 256);
	  $stmt->bindParam(5, $registration_date, PDO::PARAM_STR, 256);

	  return $stmt->execute();
      }
      ?>
  </body>
</html>
