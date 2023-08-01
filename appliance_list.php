<?php
opcache_reset();
session_start();
require 'lib/db_config.php';
$Email = $_SESSION['Email'];	
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <div class="container-fluid" style="text-align:center">
        <hr>
        <h5>Hemcraft Web Browser</h5>
        <label for="file">File progress:</label>
        <progress id="file" max="100" value="75"> 75% </progress>
        <hr>
    </div>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	
	<h2 style="text-align:center">Appliances </h2>
	<h3 style="text-align:center">You have added the following Appliances to your household: </h3></br>
	</div>
</head>
<body>

<div class="container-fluid" style="text-align:left; padding-left:38%">

<?php

    $query1 = "SELECT Id FROM APPLIANCE WHERE APPLIANCE.Email='$Email'";
    $result1 = mysqli_query($conn, $query1);
    $resultCheck = mysqli_num_rows($result1);

    if (isset($_POST['Submit'])) {

        if ($resultCheck == 0) {
            echo "<script>alert(\"Must have at least one appliance per household.\");</script>";
        } else {
            header('Location: submit_page.php');
        }
    }

   $query2 = " SELECT Id, Type, Manufacturer_name AS Manufacturer, Model FROM " .
			 " (((SELECT Email, Id, CASE WHEN Id IS NOT NULL THEN 'REFRIGERATOR/FREEZER' END AS Type " .
			 " FROM REFRIGERATOR WHERE Email='$Email' ) " .
			 " UNION " .
			 " (SELECT Email, Id, CASE WHEN Id IS NOT NULL THEN 'WASHER' END AS Type FROM WASHER WHERE Email='$Email') " .
			 " UNION " .
			 " (SELECT Email, Id, CASE WHEN Id IS NOT NULL THEN 'DRYER' END AS Type FROM DRYER WHERE Email='$Email') " .
			 " UNION " .
			 " (SELECT Email, Id, CASE WHEN Id IS NOT NULL THEN 'TV' END AS Type FROM TV WHERE Email='$Email') " .
			 " UNION " .
			 " (SELECT Email, Id, CASE WHEN Id IS NOT NULL THEN 'COOKER' END AS Type FROM COOKER WHERE Email='$Email')) AS UNION_TABLE " .
			 " NATURAL JOIN APPLIANCE ) ORDER BY Id ASC; ";


$result2 = mysqli_query($conn,$query2);

if (!is_bool($result2) && (mysqli_num_rows($result2) > 0)) {
	echo "<table class='table table-bordered'>";
	echo "<style> table, th, td {
		  border: 1px solid black;
		  border-collapse: collapse;
		}

		table.center {
		  margin: 25px auto; 
		}
		</style>";

echo "<table border='1'>
<tr>
<th style='text-align: center'>Id</th>
<th style='text-align: center'>Type</th>
<th style='text-align: center'>Manufacturer</th>
<th style='text-align: center'>Model</th>
</tr>";

while($row = mysqli_fetch_array($result2))
{
echo "<tr>";
echo "<td style='text-align: center'>" . $row['Id'] . "</td>";
echo "<td style='text-align: center'>" . $row['Type'] . "</td>";
echo "<td style='text-align: center'>" . $row['Manufacturer'] . "</td>";
echo "<td style='text-align: center'>" . $row['Model'] . "</td>";
echo "</tr>";
}
echo "</table>";
echo "</div>";
}
?>
<div class="container-fluid" style="text-align:center">
<a style="text-align:right" color = 'blue' href="addAppliance.php">+ Add another appliance</a></br></br>
<form action="appliance_list.php" method="post" class="container-fluid" style="text-align:center">
   <input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
</form>
</div>

</div>
</div>
</body>
</html>











                                  