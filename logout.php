<?php

$name = htmlspecialchars($_SESSION['name']);
	$_SESSION = array(); // Destroy the variables.
	//setcookie (session_name(), '', time()-3600); // Destroy the cookie.
	destroy_session_and_data(); // Destroy the session itself and all its data.



//This function can be called when you need to destroy a session (usually when the user clicks a log out button)
function destroy_session_and_data()
{
  $_SESSION = array();
  setcookie(session_name(), '', time() - 2592000, '/');
  session_destroy();
}
?>

<p><a href="index.php">Home Page</a></p>