<!DOCTYPE html>
<?php
session_start();
require 'lib/db_config.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    function validatezip(form) {
        zip = form.Postal_code.value
        if (zip == "") {
            alert("Input Postal code!")
            return false
        } else if (!/^\d{5}$/.test(zip)) {
            alert("Input valide 5 digit Postal code!")
            return false
        }
        return true
    }
</script>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <div class="container-fluid" style="text-align:center">
        <hr>
        <h1><span><b>Hemcraft Web Browser</b></span></h1>
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
        Household averages by radius
    </title>

</head>

<?php


$showRadiusResult = False;
//If clicked submit
if (isset($_POST['submit'])) {
    //check zip
    $Zip = $_POST['Postal_code']; //get_post($conn, 'Postal_code');
    $Radius = $_POST['Radius'];
    $query = "SELECT Latitude AS P_Lat, Longitude AS P_Lng 
            FROM ZIPCODE 
            WHERE ZIPCODE.Postal_code = '$Zip'";
    $result = mysqli_query($conn, $query);
    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

        $query_house = "SELECT HOUSEHOLD.Email
                                FROM HOUSEHOLD,(SELECT Postal_code,POWER(SIN(RADIANS(Lat2-Lat1)/2),2)+COS(RADIANS(Lat1))*COS(RADIANS(Lat2))*POWER(SIN(RADIANS(Lon2-Lon1)/2),2) AS Geo_A
                                                FROM (SELECT S.Postal_code AS Postal_code,
                                                            S.Latitude AS Lat2,
                                                            S.Longitude AS Lon2,
                                                            T.Latitude AS Lat1,
                                                            T.Longitude AS Lon1
                                                    FROM ZIPCODE AS S,ZIPCODE AS T
                                                    WHERE T.Postal_code='$Zip'
                                                    ) AS ZIPJOIN
                                                ) AS ZIP_RECALC
                                WHERE FLOOR(3958.75*2*ATAN2(sqrt(Geo_A),sqrt(1-Geo_A))) <= $Radius and ZIP_RECALC.Postal_code=HOUSEHOLD.Postal_code";
        $result_house = mysqli_query($conn, $query_house);
        $nhouses = (mysqli_num_rows($result_house));
        if (!is_bool($result_house) && (mysqli_num_rows($result_house) > 0)) {
            $showRadiusResult = True;
        } else {
            echo "<script>alert('No house information found!\"PostalCode:$Zip and Radius:$Radius\"');</script>";
        }
    } else {

        echo "<script>alert(\"Postal Code:'$Zip' not found in the database!\");</script>";
    }
}
echo <<<_END
    <div class="container-fluid" style="text-align:left; padding-left:38%">
    <b>Household averages by radius</b><br>  
    <form action="radius_search.php" style="text-align:left" method="post" onsubmit="return validatezip(this)"><pre>
    Please enter a five digit postal code:
    <input type="text" name="Postal_code" id="Postal_code"><br>
    Please select Radius:
    <select id="Radius" name="Radius">
                <option value="0">0</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="250">250</option>
            </select><br>
    <input type="submit" name='submit' value="Submit">
    </pre></form> 
    </div>
    _END;


//0, 5, 10, 25, 50, 100, and 250
if (isset($_POST["submit"])) {
    echo <<<_END
      
    <script type="text/javascript">
        $(document).ready(()=>{
            $("#Postal_code").val('$Zip');
            $("#Radius").val('$Radius');
        });     
    </script>
    _END;
}

//Show query results below:
if ($showRadiusResult) {

    $query = file_get_contents("queryRadius.sql");

    $Radius = $_POST['Radius'];
    $Zip = $_POST['Postal_code'];
    $query = str_replace(
        '$Zip',
        $Zip,
        $query
    );
    $query = str_replace(
        '$Radius',
        $Radius,
        $query
    );


    $result = mysqli_query($conn, $query);
    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

        echo "<div class='container-fluid'>";
        echo "<hr>";
        //$nhouses = (mysqli_num_rows($result_house));
        echo "<p style='text-align:center'>Summary Query Results From <b>$nhouses</b> Houses Within Selected Area</p>";
        echo "<table class='table table-bordered'>";
        echo "<style>td {
            text-align: center;
            vertical-align: middle;
          }</style>";
        echo "<tr><td>" . 'Postal code' .
            "</td><td>" . 'Radius' .
            "</td><td>" . 'Avg<br>Bathroom Counts' .
            "</td><td>" . 'Avg<br>Bedroom' .
            "</td><td>" . 'Avg<br>Occupants' .
            "</td><td>" . 'Avg<br>Commodes Ratio' .
            "</td><td>" . 'Avg<br>AppCounts' .
            "</td><td>" . 'Most<br>Common HeatSource' .
            "</td></tr>";
        $row = mysqli_fetch_array($result);
        echo "<tr><td>" . $row['Postal_code'] .
            "</td><td>" . $row['Search_radius'] .
            "</td><td>" . $row['AvgBathCounts'] .
            "</td><td>" . $row['AvgBedroom'] .
            "</td><td>" . $row['AvgOccupants'] .
            "</td><td>" . $row['AvgCommodesRatio'] .
            "</td><td>" . $row['AvgAppCounts'] .
            "</td><td>" . $row['MostCommonHeatSource'] .
            "</td></tr>";  //$row['index'] the index here is a field name        
        echo "</table></div>";
    } else {
        echo "<script>alert('There is no results found in the database!');</script>";
        //array_push($error_msg,  "Query ERROR: Failed to get Infor of Postal Code: $Postal_code...<br>" . __FILE__ ." line:". __LINE__ );
    }
}



?>