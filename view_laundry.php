<!DOCTYPE html>
<?php
require 'lib/db_config.php';
?>

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
        View Laundry Center Report
    </title>
</head>

<body>
    <?php
    //session_start();


    echo "<div class='container-fluid' style='text-align:center;'><b><span style='margin: 3%;'>The most common washer type and dryer heat source by state</b></span></div>";
    $query = 'Select DISTINCT ZIPCODE.Zip_state AS STATE, TOP_WASHER_LOADTYPE,TOP_DRYER_HEATSOURCE 
        FROM    
        ZIPCODE left join 
                 (SELECT Zip_state, Load_type as TOP_WASHER_LOADTYPE
                 FROM
                 (SELECT Z.Zip_state, W.Load_type, COUNT(*) OVER (PARTITION BY Zip_state ORDER BY COUNT(*) DESC,Load_type ASC) AS                     washer_count
                  FROM HOUSEHOLD AS H, ZIPCODE AS Z, WASHER AS W
                  WHERE H.Email = W.Email AND H.Postal_code = Z.Postal_code
                  GROUP BY Z.Zip_state, W.Load_type) AS Washer_C
                 WHERE washer_count =1) AS Washer_top
                 on Washer_top.Zip_state = ZIPCODE.Zip_state 
                 
                left join 
                
                (SELECT Zip_state, Heat_source as TOP_DRYER_HEATSOURCE
                 FROM
                 (SELECT Z.Zip_state, D.Heat_source, COUNT(*) OVER (PARTITION BY Zip_state ORDER BY COUNT(*)                         DESC,D.Heat_source ASC) AS Dryer_count
                  FROM HOUSEHOLD AS H, ZIPCODE AS Z, DRYER AS D
                  WHERE H.Email = D.Email AND H.Postal_code =Z.Postal_code
                  GROUP BY Z.Zip_state, D.Heat_source ) AS DRYER_COUNT
                 WHERE Dryer_count =1) As Dryer_top
                on Dryer_top.Zip_state = ZIPCODE.Zip_state
        ORDER BY STATE ASC';

    $result = mysqli_query($conn, $query);
    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {
        echo "<div class='container-fluid' style='width:30%;'>";
        echo "<table  class='table table-bordered' style='text-align: center;'>";

        echo "<thead><tr >";
        echo '<td  style="vertical-align: middle;">STATE</td>
        <td >TOP<br>WASHER LOADTYPE</td>
        <td >TOP<br>DRYER HEATSOURCE</td>';
        echo "</tr></thead>";

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr ><td class='col-sm-1'>" . $row['STATE'] . "</td><td class='col-sm-2'>" . $row['TOP_WASHER_LOADTYPE'] . "</td><td class='col-sm-2'>" . $row['TOP_DRYER_HEATSOURCE'] . "</td></tr>";  //$row['index'] the index here is a field name
        }
        echo "</table></div>";
    } else {
        echo "<script>alert(\"There is no Washer and Dryer in the database!\");</script>";
        header("Location: reports_menu.php");
        //array_push($error_msg,  "Query ERROR: Failed to get Infor of Postal Code: $Postal_code...<br>" . __FILE__ ." line:". __LINE__ );
    }

    echo "<div class='container-fluid' style='text-align:center'><hr><b>household count per state, with a washing machine and no dryer<hr></b>";
    $query = '
	      SELECT DISTINCT ZIP.Zip_state AS STATE, HOUSEHOLD_COUNT_WITH_ONLY_WASHER 
		  from ZIPCODE AS ZIP 
		  left join
	      (SELECT Z.Zip_state AS STATE, COUNT(EMAIL) AS HOUSEHOLD_COUNT_WITH_ONLY_WASHER
          FROM ZIPCODE AS Z
          left JOIN
          (SELECT H.Email AS EMAIL,H.Postal_code AS ZIP,
            CASE WHEN COUNT(D.Heat_source)>0 THEN
            COUNT(D.Heat_source) ELSE 0 END AS DRYER_COUNT,
            CASE WHEN COUNT(W.Load_type) >0 THEN
            COUNT(W.Load_type) ELSE 0 END AS WASHER_COUNT
            FROM HOUSEHOLD AS H LEFT JOIN WASHER AS W ON
            H.Email = W.Email
            LEFT JOIN DRYER AS D ON H.Email = D.Email
            GROUP BY H.Email,H.postal_code
            ) AS WASHER_DRYER_COUNT
            ON Z.Postal_code = WASHER_DRYER_COUNT.ZIP
            WHERE WASHER_DRYER_COUNT.DRYER_COUNT = 0 AND
            WASHER_DRYER_COUNT .WASHER_COUNT>0
            GROUP BY Z.Zip_state
            ORDER BY HOUSEHOLD_COUNT_WITH_ONLY_WASHER DESC) as top_zip
			
			on ZIP.Zip_state=top_zip.STATE 
			ORDER BY HOUSEHOLD_COUNT_WITH_ONLY_WASHER DESC, STATE ASC';

    $result = mysqli_query($conn, $query);
    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {
        echo "<div class='container-fluid' style='width:30%;'> <table  class='table table-bordered' style='text-align: center;'>";
        echo "<thead><tr>";
        echo '<td>STATE</td>
        <td>Household Count<br>With Only Washer No Dryer</td>';
        echo "</tr></thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr><td class='col-sm-1'>" . $row['STATE'] . "</td><td class='col-sm-3'>" . $row['HOUSEHOLD_COUNT_WITH_ONLY_WASHER'] . "</td></tr>";  //$row['index'] the index here is a field name
        }
        echo "</table>";
    } else {
        echo "There is no households with Washer but no Dryer in the database!</br>";

        //array_push($error_msg,  "Query ERROR: Failed to get Infor of Postal Code: $Postal_code...<br>" . __FILE__ ." line:". __LINE__ );
    }

    ?>
</body>