<?php
session_start();
require_once 'sql_login.php';
include('header.html');

if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to view your cars.");
}

$user_id = $_SESSION['user_id'];

try {
    // Establish database connection
    $pdo = new PDO($dsn, $mampUser, $mampPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to join the two tables and get combined data
    $query = "
    SELECT 
        c.car_id, 
        c.make, 
        c.model, 
        c.year_manufactured, 
        c.base_price, 
        u.user_id, 
        u.private_sale_price, 
        u.retail_price, 
        u.certified_price 
    FROM 
        cv_cars_table c
    JOIN 
        cv_users_cars_table u
    ON 
        c.car_id = u.car_id;
    ";

    // Execute query
    $stmt = $pdo->query($query);

    // Fetch all results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any results
    if ($results) {
        echo "<table border='1'>
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Base Price</th>
                    <th>Private Sale Price</th>
                    <th>Retail Price</th>
                    <th>Certified Price</th>
                </tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>{$row['make']}</td>
                    <td>{$row['model']}</td>
                    <td>{$row['year_manufactured']}</td>
                    <td>{$row['base_price']}</td>
                    <td>{$row['private_sale_price']}</td>
                    <td>{$row['retail_price']}</td>
                    <td>{$row['certified_price']}</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No cars found for the specified criteria.</p>";
    }

} catch (PDOException $e) {
    echo "<p class='error'>Database error: " . $e->getMessage() . "</p>";
}


?>
<?php
include('footer.html');
?>