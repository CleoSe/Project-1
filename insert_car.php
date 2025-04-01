<?php
require_once("sql_login.php");
$error = FALSE;
$display_form = true;
$date = date("Y-m-d");
ini_set('display_errors', 1);

if(isset($_POST['submit'])){
    try {
        $pdo = new PDO($dsn, $mampUser, $mampPassword, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        $display_form = FALSE;
        die("Fatal Error - Could not connect to the database.</body></html>");
    }

    // Validation checks
    if (!empty($_POST['make'])) {
        $make = $_POST['make'];
    } else {
        echo "<p>Make not input</p>";
        $error = TRUE;
    }

    if (!empty($_POST['model'])) {
        $model = $_POST['model'];
    } else {
        echo "<p>Model not input</p>";
        $error = TRUE;
    }

    if (!empty($_POST['year_man']) && strlen($_POST['year_man']) == 4 && is_numeric($_POST['year_man'])) {
        $year = $_POST['year_man'];
    } else {
        echo "<p>Year not input or invalid</p>";
        $error = TRUE;
    }

    if (!empty($_POST['mileage']) && is_numeric($_POST['mileage'])) {
        $mileage = $_POST['mileage'];
    } else {
        echo "<p>Mileage not input or not a number</p>";
        $error = TRUE;
    }
    if (!empty($_POST['base_price']) && is_numeric($_POST['base_price'])) {
        $base_price = $_POST['base_price'];
    } else {
        echo "<p>Mileage not input or not a number</p>";
        $error = TRUE;
    }

    $condition_map = [
        "fair" => 1,
        "good" => 2,
        "very_good" => 3,
        "excellent" => 4
    ];
    $condition = strtolower($_POST['condition_box']);
    $condition_value = $condition_map[$condition] ?? 1; 

    if (!$error) {
        if (add_car($pdo, $make, $model, $year, $mileage, $condition_value, $base_price, $date)) {
            echo '<h3>Thank you for registering with CarVal!</h3>';
            echo '<a href="index.html">Home Page</a>';
            exit();
        } else {
            echo '<p>You could not be registered due to a system error!</p>';
        }
    }
}

if ($display_form) {
?>

<form action="insert_car.php" method="post">
    <p>
        <label for="make">Make:</label>
        <input type="text" id="make" name="make"/>
    </p>
    <p>
        <label for="model">Model:</label>
        <input type="text" id="model" name="model"/>
    </p>
    <p>
        <label for="year_man">Year Manufactured:</label>
        <input type="text" id="year_man" name="year_man" maxlength="4"/>
    </p>
    <p>
        <label for="mileage">Mileage:</label>
        <input type="text" id="mileage" name="mileage"/>
    </p>
    <p>
	  <label for="base_price">Base Price:</label>
	  <input type="text" id="base_price" name="base_price"/>
	</p>
    <p>
        <label for="condition_box">Condition:</label>
        <select name="condition_box" id="condition_box">
            <option value="fair">Fair</option>
            <option value="good">Good</option>
            <option value="very_good">Very Good</option>
            <option value="excellent">Excellent</option>
        </select>
    </p>
    <button type="submit" id="submit" name="submit">Submit Car</button>
</form>

<?php
}

function add_car($pdo, $make, $model, $year, $mileage, $condition, $base_price, $date) {
    $stmt = $pdo->prepare('INSERT INTO cv_cars_table (make, model, year_manufactured, mileage, fair_value, base_price, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->bindParam(1, $make, PDO::PARAM_STR, 40);
    $stmt->bindParam(2, $model, PDO::PARAM_STR, 80);
    $stmt->bindParam(3, $year, PDO::PARAM_INT);
    $stmt->bindParam(4, $mileage, PDO::PARAM_INT);
    $stmt->bindParam(5, $condition, PDO::PARAM_INT);
    $stmt->bindParam(6, $base_price, PDO::PARAM_INT);
    $stmt->bindParam(7, $date, PDO::PARAM_STR, 10);

    return $stmt->execute();
}
?>
