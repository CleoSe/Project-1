    <?php
    include 'header.html';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $display_form = true;

    //get info from selected boxes





    if ($display_form) {
    ?>
      <form name="valuation_form" method="valuation.php" method="post">
	<label for="make_box">Make:</label>
	<select name="make_box" id="make_box">
	</select>
	<label for="model_box">Model:</label>
	<select name="model_box" id="model_box">
	</select>
	<label for="year_box">Year:</label>
	<select name="year_box" id="year_box">
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
      </form>
      <a href="index.php">Home Page</a>
    <?php
    } else {
    ?>
      <a href="index.html">Home Page</a>
    <?php
    }
    ?>
  </body>
</html>
