<?php
require 'lib/db_config.php';
?>

<!DOCTYPE html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
        Average TV display size by state
    </title>
</head>

<body>
    <?php
    //session_start();

    //    if (!$conn) {
    //        echo ("Connection error.");
    //    } else {
    //        echo ("Connection to DB is established.");
    //    }

    echo "<div class='container-fluid' style='text-align:center;'><b><span style='margin: 3%;'>Average TV display size by state</b></span></div>";
    $query = 'SELECT Z.Zip_State AS State,Avg_size FROM ZIPCODE AS Z
              LEFT JOIN 
              (SELECT ZZ.Zip_State, ROUND(AVG(Display_size), 1) AS Avg_size
               FROM HOUSEHOLD AS H, APPLIANCE AS A, TV AS T, ZIPCODE AS ZZ
               WHERE ZZ.Postal_code = H.Postal_code AND A.Email = H.Email AND
                     T.Email = A.Email AND T.Id = A.Id
               GROUP BY ZZ.Zip_State
               ORDER BY ZZ.Zip_State ASC) AS TV_STATE
               ON Z.Zip_State = TV_STATE.Zip_State
               GROUP BY Z.Zip_State
               ORDER BY Z.Zip_State ASC;';
    //echo "<script>alert('before query')</script>";
    $result = mysqli_query($conn, $query);
    //include('lib/show_queries.php');

    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

        echo "<div class='container-fluid' style='width:40%;'>";
        echo "<table  id='table1' class='table table-bordered' style='text-align: center;'>";

        echo "<thead><tr>";
        echo '<td style="vertical-align: middle;">STATE</td>
        <td style="vertical-align: middle;">Average<br>Display size in inch</td>
        <td style="vertical-align: middle;">Details</td>';
        echo "</tr></thead>";

        while ($row = mysqli_fetch_array($result)) {
            if ($row['Avg_size'] == null) {
                echo "<tr ><td class='col-sm-1' style='vertical-align: middle;'>" . $row['State'] . "</td><td class='col-sm-2' style='vertical-align: middle;'>NA</td><td class='col-sm-2' style='vertical-align: middle;'>NA</td></tr>";
            } else {
                echo "<tr ><td class='col-sm-1' style='vertical-align: middle;'>" . $row['State'] . "</td><td class='col-sm-2' style='vertical-align: middle;'>" . $row['Avg_size'] . "</td><td class='col-sm-2' style='vertical-align: middle;'>" . "<a onclick=\"window.open('TV_bystate.php?State=" . $row['State'] . "')\" class='btn btn-primary'>Details by state</a>" . "</td></tr>";
                //<a onclick="window.open(''TV_bystate.php?State=" . $row['State']."') class='btn btn-primary'>Details by state</a>
            }
        }
        echo "</table></div>";
    } else {
        echo "<div class='container-fluid' style='text-align: center;'>There is no TV in the database!</div>";

        //array_push($error_msg,  "Query ERROR: Failed to get Infor of Postal Code: $Postal_code...<br>" . __FILE__ ." line:". __LINE__ );
    }
    ?>


</body>
