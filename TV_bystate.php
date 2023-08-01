<!DOCTYPE html>
<?php
if (!isset($_GET['State'])) {
    echo "<script>alert('no State input!')</script>";
    header("Location: TV_report.php");
}
$State_select = $_GET['State'];
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo "TV summary report in $State_select" ?>
    </title>
</head>

<body>
    <?php
    //session_start();
    require 'lib/db_config.php';

    echo "<div class='container-fluid' style='text-align:center;'><b><span style='margin: 3%;'>TV Summary in $State_select</b></span></div>";
    $query = "SELECT T.Display_type,
                T.Max_resolution,
                ROUND(AVG(T.Display_size), 1) AS Avg_size
                FROM ZIPCODE AS Z, HOUSEHOLD AS H, APPLIANCE AS A, TV AS T
                WHERE Z.Postal_code = H.Postal_code AND A.Email = H.Email AND
                T.Email = A.Email AND T.Id = A.Id AND Z.Zip_state = '$State_select'
                GROUP BY T.Display_type, T.Max_resolution
                ORDER BY Avg_size DESC";
    //echo "<script>alert('before query')</script>";
    $result = mysqli_query($conn, $query);
    //include('lib/show_queries.php');

    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

        echo "<div class='container-fluid' style='width:30%;'>";
        echo "<table  id='table1' class='table table-bordered' style='text-align: center;'>";

        echo "<thead><tr>";
        echo '<td style="vertical-align: middle;">Display type</td>
        <td style="vertical-align: middle;">Max resolution</td>
        <td style="vertical-align: middle;">Average<br>Display size in inch</td>
        ';
        echo "</tr></thead>";

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr ><td class='col-sm-1' style='vertical-align: middle;'>" . $row['Display_type'] . "</td><td class='col-sm-2' style='vertical-align: middle;'>" . $row['Max_resolution'] . "</td><td class='col-sm-2' style='vertical-align: middle;'>" . $row['Avg_size'] . "</td></tr>";  //$row['index'] the index here is a field name
        }
        echo "</table></div>";
    } else {
        echo "<script>alert(\"There is no TV in the database!\");</script>";
        header("Location: TV_report.php");
        //array_push($error_msg,  "Query ERROR: Failed to get Infor of Postal Code: $Postal_code...<br>" . __FILE__ ." line:". __LINE__ );
    }
    ?>

</body>