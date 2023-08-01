<?php
    // Force cache reset.
    opcache_reset()
?>

<?php
    include "lib/db_config.php";

    function show_detailed_report($name) {
        /*
         * Show detailed report for a manufacturer.
         * There are two columns in the report: Appliance type
         * and number of appliances of this type.
         * 
         * Input: Manufacturer name in string.
         * 
         * Return: None
         */
        global $conn;
        $query = "WITH
            MSELECT(Email,Id)
            AS (
            SELECT Email,Id
            FROM APPLIANCE
            WHERE Manufacturer_name  = '$name'
            )
            SELECT Appliance_Type,Count_app
            FROM (
            SELECT 'WASHER' AS Appliance_Type,COUNT(A.Id) AS
            Count_app
            FROM WASHER AS A, MSELECT
            WHERE A.Email=MSELECT.Email AND A.Id=MSELECT.Id
            UNION
            SELECT 'DRYER' AS Appliance_Type,COUNT(A.Id) AS Count_app
            FROM DRYER AS A,MSELECT
            WHERE A.Email=MSELECT.Email AND A.Id=MSELECT.Id UNION
            SELECT 'TV' AS Appliance_Type,COUNT(A.Id) AS Count_app
            FROM TV AS A,MSELECT
            WHERE A.Email=MSELECT.Email AND A.Id=MSELECT.Id UNION
            SELECT 'REFRIGERATOR' AS Appliance_Type,COUNT(A.Id) AS Count_app
            FROM REFRIGERATOR AS A,MSELECT
            WHERE A.Email=MSELECT.Email AND A.Id=MSELECT.Id UNION
            SELECT 'COOKER' AS Appliance_Type,COUNT(A.Id) AS Count_app
            FROM COOKER AS A,MSELECT
            WHERE A.Email=MSELECT.Email AND A.Id=MSELECT.Id ) AS APPUNION
            ORDER BY Appliance_Type ASC;";
        $result = mysqli_query($conn, $query);
        $num_rows = mysqli_num_rows($result);

        if ($num_rows > 0) {
            echo("<div class='container-fluid' style='width:50%;'>");
            echo("<table  id='table1' class='table table-bordered' style='text-align: center; vertical-align: middle;'>");
            echo("<thead><tr>");
            echo('<td style="vertical-align: middle;">Appliance Type</td>
                  <td style="vertical-align: middle;"># of Appliances</td>');
            echo("</tr></thead>");
                
            while ($row = mysqli_fetch_array($result)) {
                echo("<tr>");
                echo("<td class='col-sm-1'>".$row["Appliance_Type"]."</td>");
                echo("<td class='col-sm-1'>".$row["Count_app"]."</td>");
                echo("</tr>");
            }
            echo("</table>");
        }
        else {
            echo("<div class='container-fluid' style='text-align:center;'><span style='margin: 10%;'>
                  There is no appliance of this type. Please go back to main menu and add appliance.
                  </span></div>");
        }
    }
?>


<!DOCTYPE html>
<html>
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
        Detailed Manufacturer Report
        </title>
    </head>
    <body>
        <?php
            if (!isset($_GET["manufacturer_name"])) {
                echo("<script>alert('Manufacturer name is not set!')</script>");
            }
            $manufacturer_name = $_GET["manufacturer_name"];
            echo("<div class='container-fluid' style='text-align:center'>
                  <h1>Detailed Manufacturer Report: $manufacturer_name</h1>
                  </div>");
            show_detailed_report($manufacturer_name);
        ?>
        <script src="" async defer></script>
    </body>
</html>