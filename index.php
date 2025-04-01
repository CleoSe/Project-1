<?php
//require_once 'sql_login.php';
$page_title = 'Home';
include('header.html');

if (isset($_SESSION['user_id'])) {
    $name = htmlspecialchars($_SESSION['name']);
    echo "<h3><strong>Welcome, $name!</strong></h3>";
} else {
    echo "<h3><strong>Welcome! Please register to proceed. If registered, log in now.</strong></h3>";
}

?>

<?php
include('footer.html');
?>