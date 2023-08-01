<?php
// Force cache reset.
opcache_reset()
?>
<?php
//session_start();
require 'lib/db_config.php';
?>

<!DOCTYPE html>
<html>

<head>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
      <div class="container-fluid" style="text-align:center">
            <hr>
            <h1><b>Hemcraft Web Browser</b></h1>
            <div>
                  <a href="index.php" class="btn btn-primary">Main Menu</a>
                  <a href="view_reports_menu.php" class="btn btn-primary ml-3">Report Menu</a>
            </div>

            <hr>
      </div>

      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>
            View Bathroom Statistics
      </title>
</head>

<body>
      <?php
      //session_start();
      // require 'lib/db_config.php';

      echo "<div class='container-fluid' style='text-align:center;'><b><span style='margin: 3%;'>Bathroom Statistics for All Households</b></span></div>";


      echo "<div class='container-fluid' style='width:40%;'>";
      echo "<table  class='table table-bordered' style='text-align: left;'>";

      $query = 'SELECT MIN(count_bath) AS MinBathCounts,ROUND(AVG(count_bath),1) AS AvgBathCounts,MAX(count_bath) AS MaxBathCounts FROM (SELECT Email,COUNT(Email) AS count_bath FROM BATHROOM GROUP BY Email) AS BATHAGGR;
    ';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">1. The count of all bathrooms per household: <br> min: <b>' . $row['MinBathCounts'] . ' </b>average: <b>' . $row['AvgBathCounts'] . '</b> max: <b>' . $row['MaxBathCounts'] . '</b></td>';
      echo "</tr></thead>";

      $query = 'SELECT MIN(count_bath) AS MinHBathCounts,ROUND(AVG(count_bath),1) AS AvgHBathCounts,MAX(count_bath) AS MaxHBathCounts FROM (SELECT Email,COUNT(Email) AS count_bath FROM HALF_BATH GROUP BY Email) AS HALFBATHAGGR;';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">2. The count of half bathrooms per household: <br> min: <b>' . $row['MinHBathCounts'] . ' </b>average: <b>' . $row['AvgHBathCounts'] . '</b> max: <b>' . $row['MaxHBathCounts'] . '</b></td>';
      echo "</tr></thead>";

      $query = 'SELECT MIN(count_bath) AS MinFBathCounts,ROUND(AVG(count_bath),1) AS AvgFBathCounts,MAX(count_bath) AS MaxFBathCounts
    FROM (SELECT Email,COUNT(Email) AS count_bath
          FROM FULL_BATH
          GROUP BY Email) AS FULLBATHAGGR;
    ';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">3. The count of full bathrooms per household: <br> min: <b>' . $row['MinFBathCounts'] . ' </b>average: <b>' . $row['AvgFBathCounts'] . '</b> max: <b>' . $row['MaxFBathCounts'] . '</b></td>';
      echo "</tr></thead>";

      $query = 'SELECT MIN(count_commode) AS MinCommodCounts,ROUND(AVG(count_commode),1) AS AvgCommodCounts,MAX(count_commode) AS MaxCommodCounts
    FROM (SELECT Email,SUM(No_commode) AS count_commode
          FROM BATHROOM
          GROUP BY Email) AS BATHAGGR;
    ';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">4. The count of commodes per household: <br> min: <b>' . $row['MinCommodCounts'] . ' </b>average: <b>' . $row['AvgCommodCounts'] . '</b> max: <b>' . $row['MaxCommodCounts'] . '</b></td>';
      echo "</tr></thead>";

      $query = 'SELECT MIN(count_sink) AS MinSinkCounts,ROUND(AVG(count_sink),1) AS AvgSinkCounts,MAX(count_sink) AS MaxSinkCounts
    FROM (SELECT Email,SUM(No_sink) AS count_sink
          FROM BATHROOM
          GROUP BY Email) AS BATHAGGR;
    ';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">5. The count of sinks per household: <br> min: <b>' . $row['MinSinkCounts'] . ' </b>average: <b>' . $row['AvgSinkCounts'] . '</b> max: <b>' . $row['MaxSinkCounts'] . '</b></td>';
      echo "</tr></thead>";

      $query = 'SELECT MIN(count_bidet) AS MinBidetCounts,ROUND(AVG(count_bidet),1) AS AvgBidetCounts,MAX(count_bidet) AS MaxBidetCounts
    FROM (SELECT Email,SUM(No_bidet) AS count_bidet
          FROM BATHROOM
          GROUP BY Email) AS BATHAGGR;
    ';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">6. The count of bidets per household: <br> min: <b>' . $row['MinBidetCounts'] . ' </b>average: <b>' . $row['AvgBidetCounts'] . '</b> max: <b>' . $row['MaxBidetCounts'] . '</b></td>';
      echo "</tr></thead>";

      $query = 'SELECT MIN(count_bathtub) AS MinBathtubCounts,ROUND(AVG(count_bathtub),1) AS AvgBathtubCounts,MAX(count_bathtub) AS MaxBathtubCounts
    FROM (SELECT Email,SUM(No_bathtub) AS count_bathtub
          FROM FULL_BATH
          GROUP BY Email) AS FBATHAGGR;
    ';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">7. The count of bathtubs per household: <br> min: <b>' . $row['MinBathtubCounts'] . ' </b>average: <b>' . $row['AvgBathtubCounts'] . '</b> max: <b>' . $row['MaxBathtubCounts'] . '</b></td>';
      echo "</tr></thead>";

      $query = 'SELECT MIN(count_shower) AS MinShowerCounts,ROUND(AVG(count_shower),1) AS AvgShowerCounts,MAX(count_shower) AS MaxShowerCounts
    FROM (SELECT Email,SUM(No_shower) AS count_shower
          FROM FULL_BATH
          GROUP BY Email) AS FBATHAGGR;
    ';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">8. The count of showers per household: <br> min: <b>' . $row['MinShowerCounts'] . ' </b>average: <b>' . $row['AvgShowerCounts'] . '</b> max: <b>' . $row['MaxShowerCounts'] . '</b></td>';
      echo "</tr></thead>";

      $query = 'SELECT MIN(count_tub) AS MinTubCounts,ROUND(AVG(count_tub),1) AS AvgTubCounts,MAX(count_tub) AS MaxTubCounts
    FROM (SELECT Email,SUM(No_tub) AS count_tub
          FROM FULL_BATH
          GROUP BY Email) AS FBATHAGGR;
    ';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">9. The count of tub/showers per household: <br> min: <b>' . $row['MinTubCounts'] . ' </b>average: <b>' . $row['AvgTubCounts'] . '</b> max: <b>' . $row['MaxTubCounts'] . '</b></td>';
      echo "</tr></thead>";

      $query = 'SELECT ZIPCODE.Zip_state AS State_Name,SUM(No_bidet) AS Total_bidet
    FROM BATHROOM,HOUSEHOLD,ZIPCODE
    WHERE BATHROOM.Email=HOUSEHOLD.Email AND HOUSEHOLD.Postal_code=ZIPCODE.Postal_code
    GROUP BY ZIPCODE.Zip_state
    ORDER BY Total_bidet DESC LIMIT 1;
    ';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">10. <b>' . $row['State_Name'] . ' </b> has the most bidets among all states. <br> The total number is <b>' . $row['Total_bidet'] . '</b>.</td>';
      echo "</tr></thead>";

      $query = 'SELECT HOUSEHOLD.Postal_code,SUM(No_bidet) AS Total_bidet
    FROM BATHROOM,HOUSEHOLD
    WHERE BATHROOM.Email=HOUSEHOLD.Email
    GROUP BY HOUSEHOLD.Postal_code
    ORDER BY Total_bidet DESC LIMIT 1;
    ';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">11. Postal code <b>' . $row['Postal_code'] . ' </b> has the most bidets. <br> The total number is <b>' . $row['Total_bidet'] . '</b>.</td>';
      echo "</tr></thead>";

      $query = 'SELECT COUNT(FULL_BATH.Email)AS Count_House_Single_Primary
    FROM FULL_BATH,(
        SELECT Email,COUNT(Email) AS Count_bath
        FROM BATHROOM
        GROUP BY BATHROOM.Email) AS BATHAGGR
    WHERE BATHAGGR.Count_bath=1 AND FULL_BATH.Is_primary AND FULL_BATH.Email=BATHAGGR.Email;';
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_array($result);
      echo "<thead><tr >";
      echo '<td  style="vertical-align: middle;">12. There are (is)  <b>' . $row['Count_House_Single_Primary'] . ' </b> of households (household) with only a single, primary bathroom, and no other bathrooms.</td>';
      echo "</tr></thead>";

      echo"</table></div>";



      ?>
</body>

</html>