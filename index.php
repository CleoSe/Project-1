<?php
      require_once 'sql_login.php';

      include('header.html');

      if (isset($_SESSION['user_id'])) {
        $name = htmlspecialchars($_SESSION['name']);
        echo "<h3><strong>Welcome, $name!</strong></h3>";
      }
      
      ?>
    <ul>
        <li><a href="register.php">Register</a></li>
        <li><a href="log_in.php">Log In</a></li>
        <li><a href="valuation.php">Valuate Car</a></li>
        <li><a href ="logout.php">Logout</a></li>
    </ul>