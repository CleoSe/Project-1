    <?php
    include 'header.html';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    require_once 'sql_login.php';

    $make = $model = $year = $condition = 0;

    $display_form = true;

    if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
    }else{
      echo "Warning! You are not logged in, no data will save.";
    }

    if(isset($_POST['valuate'])){
      $make = $_POST['make_box'];
      $model = $_POST['model_box'];
      $year = $_POST['year_box'];
      $condition = $_POST['condition_box'];

      $search_query = "SELECT car_id FROM cv_cars_table WHERE make LIKE '$make' AND model LIKE '$model' AND year_manufactured = $year AND fair_value LIKE $condition;";

      try {
        $pdo = new PDO($dsn, $mampUser, $mampPassword);
          } catch (PDOException $e) {
        die("Fatal Error - Could not connect to the database</body></html>" );
          }

        $result = $pdo->query($search_query);
        $result = $result->fetch(PDO::FETCH_ASSOC);

        $car_id = $result['car_id'];

        echo $car_id;

    }




    if ($display_form) {
    ?>
      <p><form name="valuation_form" action="valuation.php" method="post">
	<label for="make_box">Make:</label>
	<select name="make_box" id="make_box">
    <option value= "Honda">Honda</option>
	</select>
	<label for="model_box">Model:</label>
	<select name="model_box" id="model_box">
    <option value = "Civic">Civic</option>
	</select>
	<label for="year_box">Year:</label>
	<select name="year_box" id="year_box">
    <option value = 2000>2000</option>
	</select>
	<label for="condition_box">Condition:</label>
	<select name="condition_box" id="condition_box">
	  <option value= 1>Fair</option>
	  <option value= 2>Good</option>
	  <option value= 3>Very Good</option>
	  <option value= 4>Excellent</option>
	</select>
  <label>Mileage: </label>
  <input type="text" id="mileage" name="mileage"/>
  <p><button type="submit" id="valuate" name="valuate">Get CarVal Value!</button></p>
      </form></p>
      <a href="index.php">Home Page</a>
    <?php
    } else {
    ?>
      <a href="index.php">Home Page</a>
    <?php
    }
    ?>
  </body>
</html>
