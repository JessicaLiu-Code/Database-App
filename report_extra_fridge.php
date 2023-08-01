<?php
    // Force cache reset.
    opcache_reset()
?>

<?php
    include "lib/db_config.php";

    function count_household_with_multiple_fridge() {
        /* This function returns the number of households with more than one fridges.
         * 
         * Inputs: None
         * 
         * Return: Number of households with >1 fridges.
         */
        global $conn;
        $query = "SELECT COUNT(RC.Email) ".
            "FROM ".
            "(SELECT H.Email, COUNT(R.Id) AS FR_Count ".
            "FROM REFRIGERATOR AS R ".
            "JOIN HOUSEHOLD AS H ".
            "ON H.Email = R.Email ".
            "GROUP BY H.Email) AS RC ".
            "WHERE RC.FR_Count > 1;";
        $result = mysqli_query($conn, $query);
        $num_rows = mysqli_num_rows($result);
        
        # Display aggregated table if we get back results.
        if ($num_rows > 0) {
            $row = mysqli_fetch_array($result);
            $num_household = $row["COUNT(RC.Email)"];
            echo("<div class='container-fluid' style='text-align:center;'><b><span style='margin: 3%;'>
                 Number of households with more than one fridge/freezer: $num_household
                 </b></span></div>");
            return $num_household;
        }
        return 0;
    }


    function display_top_ten_states() {
        /* This function returns the states with the most households which have >1 fridges.
         * There are 5 columns: state name, number of households with multiple fridges,
         * percentage of chest, upright, and other types of fridges.
         * 
         * Inputs: None
         * 
         * Return: Number of households with >1 fridges.
         */
        global $conn;
        $query = "WITH ".
            "HOUSEWITHFR(Email, Zip_state, RID, RType) AS (".
            "SELECT H.Email, Z.Zip_state, R.Id, R.RType ".
            "FROM REFRIGERATOR AS R ".
            "JOIN HOUSEHOLD AS H ".
            "ON H.Email = R.Email ".
            "JOIN ZIPCODE AS Z ".
            "On Z.Postal_code = H.Postal_code ".
            ") ".
            "SELECT RCS.State_name, ".
            "COUNT(RCS.User_email) AS FR_Count_Total, ".
            "ROUND(COUNT(RCS.Chest_count) * 100 / ".
            "NULLIF(COUNT(RCS.User_email), 0),2) AS Chest_pct, ".
            "ROUND(COUNT(RCS.Upright_count) * 100 / ".
            "NULLIF(COUNT(RCS.User_email), 0),2) AS Upright_pct, ".
            "ROUND(COUNT(RCS.Misc_count) * 100 / ".
            "NULLIF(COUNT(RCS.User_email), 0),2) AS Misc_pct ".
            "FROM ".
            "(".
            "SELECT User_email, State_name, ".
            "FR_Count, Chest_count, ".
            "Upright_count, Misc_count ".
            "FROM ".
            "((SELECT Email AS User_email, ".
            "COUNT(RID) AS FR_count, ".
            "Zip_state as State_name ".
            "FROM HOUSEWITHFR ".
            "GROUP BY Email, State_name) AS FRTOTAL LEFT JOIN ".
            "(SELECT Email, ".
            "COUNT(RID) AS Chest_count, ".
            "Zip_state ".
            "FROM HOUSEWITHFR ".
            "WHERE RType = 'chest freezer' ".
            "GROUP BY Email, Zip_state) AS FRCHEST ".
            "ON User_email = FRCHEST.Email ".
            "LEFT JOIN ".
            "(SELECT Email, ".
            "COUNT(RID) AS Upright_count, ".
            "Zip_state ".
            "FROM HOUSEWITHFR ".
            "WHERE RType = 'upright freezer' ".
            "GROUP BY Email, Zip_state) AS FRUPRIGHT ".
            "ON User_email = FRUPRIGHT.Email ".
            "LEFT JOIN ".
            "(SELECT Email, ".
            "COUNT(RID) AS Misc_count, ".
            "Zip_state ".
            "FROM HOUSEWITHFR ".
            "WHERE RType != 'upright freezer' AND RType != ".
            "'chest freezer' ".
            "GROUP BY Email, Zip_state) AS FRMISC ".
            "ON User_email = FRMISC.Email) ".
            ") AS RCS ".
            "WHERE RCS.FR_Count > 1 ".
            "GROUP BY RCS.State_name ORDER BY FR_Count_Total DESC LIMIT 10;";
        
        $result = mysqli_query($conn, $query);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            echo("<div class='container-fluid' style='width:80%;'>");
            echo("<table  id='table1' class='table table-bordered' style='text-align: center; vertical-align: middle;'>");
            echo("<thead><tr>");
            echo('<td style="vertical-align: middle;">State</td>
                  <td style="vertical-align: middle;"># of households with <br>multiple fridges</td>
                  <td style="vertical-align: middle;">Chest %</td>
                  <td style="vertical-align: middle;">Upright %</td>
                  <td style="vertical-align: middle;">Other %</td>');
            echo("</tr></thead>");
                
            while ($row = mysqli_fetch_array($result)) {
                echo("<tr>");
                echo("<td class='col-sm-1'>".$row["State_name"]."</td>");
                echo("<td class='col-sm-1'>".round($row["FR_Count_Total"])."</td>");
                echo("<td class='col-sm-1'>".round($row["Chest_pct"])."</td>");
                echo("<td class='col-sm-1'>".round($row["Upright_pct"])."</td>");
                echo("<td class='col-sm-1'>".round($row["Misc_pct"])."</td>");
                echo("</tr>");
            }
            echo("</table>");
            
        }
        else {
            echo("No such household with found in database. Please go back to main menu and add household and/or appliance.");
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
            Extra Fridge/Freezer Report
        </title>
    </head>
    <body>
        <div class="container-fluid" style="text-align:center">
            <h1>Extra Fridge/Freezer Report</h1>
        </div>

        <?php
            $num_households = count_household_with_multiple_fridge();
            echo("<br>");

            if ($num_households > 0) {
                display_top_ten_states();
            }
            else {
                echo("<div class='container-fluid' style='text-align:center;'><span style='margin: 10%;'>
                      There is no household with more than one fridges. Therefore, top state report will not be shown.
                      </span></div>");
            }
        ?>
        <script src="" async defer></script>
    </body>
</html>