<?php
opcache_reset();
session_start();
include 'lib/db_config.php';
?>

<!DOCTYPE html>
<html>

<head>
    <div class="container-fluid" style="text-align:center">
        <hr>
        <h5>Hemcraft Web Browser</h5>
        <label for="file">File progress:</label>
        <progress id="file" max="100" value="50"> 50% </progress>
        <hr>
    </div>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <h2 style="text-align:center">Bathrooms </h2>
    <h3 style="text-align:center">You have added the following bathrooms to your household: </h3>
</head>

<body>

    <div class="container-fluid" style="text-align:left; padding-left:38%">

        <?php

        if (!$conn) {
            echo "connect error: " . mysqli_connect_error();
        }

        $Email = $_SESSION['Email'];
        $query = "SELECT Id FROM BATHROOM WHERE BATHROOM.Email='$Email'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);

        if (isset($_POST['Next'])) {
            if ($resultCheck == 0) {
                echo "<script>alert(\"Must have at least one bathroom per household.\");</script>";
            } else {
                header('Location: addAppliance.php');
            }
        }

        $query = "SELECT Id AS BathroomN, CASE WHEN Id IS NOT NULL THEN 'half' END AS Type, CASE WHEN Id IS NOT NULL THEN '' END AS Is_primary " .
            " FROM HALF_BATH WHERE Email = '$Email' " .
            " UNION SELECT Id AS BathroomN, CASE WHEN Id IS NOT NULL THEN 'full' END AS Type,CASE WHEN Is_primary THEN 'Yes' END AS Is_primary " .
            " FROM FULL_BATH WHERE Email = '$Email'  ORDER BY BathroomN ASC; ";

        $result = mysqli_query($conn, $query);


        echo "<div class='container-fluid'>";
        echo "<table class='table table-bordered'>";
        echo "<style> table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }

    table.center {
      margin: 100px auto; 
    }
    </style>";
        echo "<table border='1'>
        <tr>
        <th style='text-align: center'>Bathroom #</th>
        <th style='text-align: center'>Type</th>
        <th style='text-align: center'>Is_primary</th>
        </tr>";

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td style='text-align: center'>" . $row['BathroomN'] . "</td>";
            echo "<td style='text-align: center'>" . $row['Type'] . "</td>";
            echo "<td style='text-align: center'>" . $row['Is_primary'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        //$conn->close();
        ?>
        </br><a style="float:left" color='blue' href="addBathroom.php">+ Add another bathroom</a></br></br>
        <!-- <input color='blue' class="btn btn-primary" type="submit" value="Next" style="float:right;" onclick="location='addAppliance.php';"> -->
        <form action="bathroom_listing.php" method="post">
            <input class="btn btn-primary" type="submit" name="Next" value="Next">
        </form>
    </div>
</body>

</html>