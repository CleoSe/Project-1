<?php
$page_title = 'Valuation';
include 'header.html';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'sql_login.php';

$display_form = true;

//get info from selected boxes
$make = $model = $year = $condition = $mileage = "";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if(isset($_POST['submit'])){
    $make = $_POST['make_box'];
    $model = $_POST['model_box'];
    $year = $_POST['year_box'];
    $condition = $_POST['condition_box'];
    $mileage = $_POST['mileage'];

    $search_query = "SELECT car_id, base_price FROM cv_cars_table WHERE make = '$make' AND model = '$model' AND year_manufactured = $year;";

    try {
    $pdo = new PDO($dsn, $mampUser, $mampPassword);
        } catch (PDOException $e) {
    die("Fatal Error - Could not connect to the database</body></html>" );
        }

    $result = $pdo->query($search_query);
    $result = $result->fetch(PDO::FETCH_ASSOC);

    if(empty($result['car_id'])){
        echo "<p class = 'error'>Vehicle does not exist!</p>";
    }else {
        //logic for getting price information
        $car_id = $result['car_id'];
        $base_price = $result['base_price'];

        if($mileage >= 10000 && $mileage <= 40000){
            $base_price = $base_price - ($base_price * .05);
        }elseif($mileage >= 40001 && $mileage <= 80000){
            $base_price = $base_price - ($base_price * .1);
        }elseif($mileage >= 80001){
            $base_price = $base_price - ($base_price * .15);
        }

        //condition pricing
        if($condition == 2){
            $base_price = $base_price * 1.05;
        }elseif($condition == 3){
            $base_price = $base_price * 1.10;
        }elseif($condition == 4){
            $base_price = $base_price * 1.15;
        }


        $private_price = $base_price * .75;
        $retail_price = $base_price * 1.15;
        $pre_owned = $private_price * 1.10;



        //echo $car_id;
        $display_form = false;

        $car_user = "INSERT INTO cv_users_cars_table (car_id, user_id, private_sale_price, retail_price, certified_price, car_condition) VALUES ($car_id, $user_id, $private_price, $retail_price, $pre_owned, $condition);";
        $pdo->exec($car_user);

    }
    

}


if ($display_form) {
    ?>
    <form name="valuation_form" action="valuation.php" method="post">
        <p>
            <label for="make_box">Make:</label>
            <select name="make_box" id="make_box">
                <option value="choose">Choose</option>
                <option value="ford">Ford</option>
                <option value="chrysler">Chrysler</option>
                <option value="toyota">Toyota</option>
                <option value="chevrolet">Chevrolet</option>
            </select>
        </p>

        <p>
            <label for="model_box">Model:</label>
            <select name="model_box" id="model_box">
                <option value="choose">Choose</option>
                <option>------</option>

                <option value="ford">Ford:</option>
                <option value="focus">Focus</option>
                <option value="escape">Escape</option>
                <option value="explorer">Explorer</option>
                <option value="mustang">Mustang</option>
                <option value="f150">F-150</option>
                <option value="ranger">Ranger</option>
                <option>------</option>

                <option value="chrysler">Chrysler:</option>
                <option value="pacifica">Pacifica</option>
                <option value="pt-cruiser">PT Cruiser</option>
                <option value="voyager">Voyager</option>
                <option value="300">300</option>
                <option value="200">200</option>
                <option>------</option>

                <option value="toyota">Toyota:</option>
                <option value="avalon">Avalon</option>
                <option value="camry">Camry</option>
                <option value="corolla">Corolla</option>
                <option value="prius">Prius</option>
                <option value="yaris">Yaris</option>
                <option>------</option>

                <option value="chevrolet">Chevrolet:</option>
                <option value="blazer">blazer</option>
                <option value="equinox">Equinox</option>
                <option value="tracker">Tracker</option>
                <option value="trailblazer">Trailblazer</option>
                <option value="traverse">Traverse</option>
            </select>
        </p>

        <p>
            <label for="year_box">Year:</label>
            <select name="year_box" id="year_box">
                <option value="choose">Choose</option>
                <option value=2020>2020</option>
                <option value=2021>2021</option>
                <option value=2022>2022</option>
                <option value=2023>2023</option>
                <option value=2024>2024</option>
            </select>
        </p>

        <p>
            <label for="condition_box">Condition:</label>
            <select name="condition_box" id="condition_box">
                <option value="choose">Choose</option>
                <option value=1>Fair</option>
                <option value=2>Good</option>
                <option value=3>Very Good</option>
                <option value=4>Excellent</option>
            </select>
        </p>

        <p>
            <label>Mileage: </label>
            <input type="text" id="mileage" name="mileage" placeholder="Mileage"/>
        </p>

        <p>
            <input type="submit" name="submit" value="Submit">
        </p>
    </form>
    <p><a href="index.php">Return to Home Page</a></p>
    <?php
} else {
    ?>
    <p><a href = "valuation.php">Go Back</a></p>
    <a href="index.php">Return to Home Page</a>
    <?php
}
?>

<?php
include('footer.html');
?>