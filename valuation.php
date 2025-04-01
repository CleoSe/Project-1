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
      <p><form name="valuation_form" method="valuation.php" method="post">
	<label for="make_box">Make:</label>
	<select name="make_box" id="make_box">
    <option value = "honda">Honda</option>
    <option value = "ford">Ford</option>
    <option value = "toyota">Toyota</option>
    
	</select>
	<label for="model_box">Model:</label>
	<select name="model_box" id="model_box">
    <option value = "civic">Civic</option>
    <option value = "civic">Prelude</option>
    <option value = "expedition">Expedition</option>
    <option value = "f150">F150</option>
    <option value = "gr86">GR86</option>
    <option value = "civic">Civic</option>
	</select>
	<label for="year_box">Year:</label>
	<select name="year_box" id="year_box">
    <option value = "2000">2000</option>
    <option value = "2001">2001</option>
    <option value = "2002">2002</option>
    <option value = "2003">2003</option>
    <option value = "2004">2004</option>
    <option value = "2005">2005</option>
    <option value = "2006">2006</option>
    <option value = "2007">2007</option>
    <option value = "2008">2008</option>
    <option value = "2009">2009</option>
    <option value = "2010">2010</option>
    <option value = "2011">2011</option>
    <option value = "2012">2012</option>
    <option value = "2013">2013</option>
    <option value = "2014">2014</option>
    <option value = "2015">2015</option>
    <option value = "2016">2016</option>
    <option value = "2017">2017</option>
    <option value = "2018">2018</option>
    <option value = "2019">2019</option>
    <option value = "2020">2020</option>
    <option value = "2021">2021</option>
    <option value = "2022">2022</option>
    <option value = "2023">2023</option>
    <option value = "2024">2024</option>
    <option value = "2025">2025</option>
	</select>
	<label for="condition_box">Condition:</label>
	<select name="condition_box" id="condition_box">
	  <option value="fair">Fair</option>
	  <option value="good">Good</option>
	  <option value="very_good">Very Good</option>
	  <option value="excellent">Excellent</option>
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
