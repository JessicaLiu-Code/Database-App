<?php
    // Force cache reset.
    opcache_reset()
?>

<?php
    include "lib/db_config.php";

    function show_top_25_manufacturers() {
        /* This function prints the aggregated top 25 manufacturer report.
         * There are two columns in the report: manufacturer name and
         * the number of appliances made by the manufacturer.
         * 
         * Inputs: None
         * 
         * Return: Manufacturer names in an array.
         */
        global $conn;
        $query = "SELECT M.Manufacturer_name, COUNT(A.Id) AS ItemCount ".
                 "FROM MANUFACTURER AS M, APPLIANCE AS A ".
                 "WHERE M.Manufacturer_name = A.Manufacturer_name ".
                 "GROUP BY M.Manufacturer_name ".
                 "ORDER BY ItemCount DESC ".
                 "LIMIT 25;";
        $result = mysqli_query($conn, $query);
        $num_rows = mysqli_num_rows($result);

        $manufacturer_names = array();
        # Display aggregated table if we get back results.
        if ($num_rows > 0) {
            echo("<div class='container-fluid' style='width:60%;'>");
            echo("<table  id='table1' class='table table-bordered' style='text-align: center; vertical-align: middle;'>");
            echo("<thead><tr>");
            echo('<td style="vertical-align: middle;">Manufacturer</td>
                  <td style="vertical-align: middle;"># of Appliances</td>
                  <td style="vertical-align: middle;">Detailed Report</td>');
            echo("</tr></thead>");
                
            while ($row = mysqli_fetch_array($result)) {
                $manufacturer_name = $row["Manufacturer_name"];
                array_push($manufacturer_names, $manufacturer_name);
                echo("<tr>");
                echo("<td class='col-sm-1'>$manufacturer_name</td>");
                echo("<td class='col-sm-1'>".$row["ItemCount"]."</td>");
                echo("<td class='col-sm-1'><a onclick=\"window.open('report_single_manufacturer.php?manufacturer_name=$manufacturer_name')\"class='btn btn-primary'>View</a></td>");
                echo("</tr>");
            }
            echo("</table>");
        }
        else {
            echo("<div class='container-fluid' style='text-align:center;'><span style='margin: 10%;'>
            No manufacturer found in database. Please go back to main menu and add appliance.
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
        Top 25 Manufacturers Report
        </title>
    </head>
    <body>
        <div class="container-fluid" style="text-align:center">
            <h1>Top 25 Manufacturers Report</h1>
        </div>

        <?php
            // Show aggregated report.
            show_top_25_manufacturers();
        ?>
        <br>
        <script src="" async defer></script>
    </body>
</html>