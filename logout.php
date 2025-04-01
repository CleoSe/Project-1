<?php

$page_title = 'Logout';
require_once("header.html");

if (isset($_SESSION['user_id'])) {
    $name = htmlspecialchars($_SESSION['name']);
    $_SESSION = array(); // Destroy the variables.
    //setcookie (session_name(), '', time()-3600); // Destroy the cookie.
    destroy_session_and_data(); // Destroy the session itself and all its data.
    echo "<h3>Successfully logged out.</h3>";
} else {
    echo "<h3>There was an error logging you out.</h3>";
}


//This function can be called when you need to destroy a session (usually when the user clicks a log out button)
function destroy_session_and_data()
{
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
}

?>

    <p><a href="index.php">Return to Home Page</a></p>

<?php
include('footer.html');
?>