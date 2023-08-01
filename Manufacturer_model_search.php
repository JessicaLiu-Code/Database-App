<?php
opcache_reset();
session_start();
require 'lib/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
        Manufacturer model search
    </title>

</head>

<body>

    <div class="container-fluid" style="text-align:left; padding-left:38%">
	<div id="search-content-result-container">
    <h3 style="text-align:auto"><b>Manufacturer model search</b></h3>  
    <h4 ><form action="Manufacturer_model_search.php" style="text-align:left" method="post"></h4>
	
	<label for="Search_content"> Please enter a string:</label>  
    <input type="text" name="Search_content" id="Search_content"></br></br>
 
	<input class="btn btn-primary" type="submit" name="Submit" value="Submit" style="center"></br></br>
    </form> 

<?php
if (isset($_POST['Submit'])) {

   $Search_content = $_POST['Search_content']; 
   
   if (preg_match('/^\s+$/',$Search_content)) {
      
	 $Search_content_b = "/ /i";
	    $query = "SELECT Manufacturer_name, Model ".
			"FROM APPLIANCE ".
			"WHERE TRIM(Manufacturer_name) LIKE '% %' OR ".
			"TRIM(Model) LIKE '% %' ".
			"ORDER BY Manufacturer_name ASC, model ASC;";
						
    $result = mysqli_query($conn,$query);
	
    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {
	    echo "<div class='container-fluid'>";
        echo "<h4 style='text-align:left'> Summary of Manufacturer/Model Containing Space In Between</h4>";
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
		<th style='text-align: center'>Manufacturer</th>
		<th style='text-align: center'>Model</th>
		</tr>";

		while($row = mysqli_fetch_array($result))
		{
		echo "<tr>";
		
		if(preg_match($Search_content_b,$row['Manufacturer_name']))
   		   echo "<td style='background-color: #90ee90;text-align: center'>".$row['Manufacturer_name']."</td>";
          else echo "<td style='text-align: center'>" . $row['Manufacturer_name'] . "</td>";
		
		if(preg_match($Search_content_b,$row['Model'])){ 
   		   echo "<td style='background-color: #90ee90;text-align: center'>".$row['Model']."</td>";} else
		   echo "<td style='text-align: center'>" . $row['Model'] . "</td>";

		echo "</tr>";
		}
		echo "</table>";
		echo "</div>";
	 
   }
   } 
   else if (empty( $Search_content)) {
      echo "<script>alert('Please input a string!');</script>"; 

   }
   else {
   $Search_content_b = "/$Search_content/i";
   $query = "SELECT Manufacturer_name, Model ".
			"FROM APPLIANCE ".
			"WHERE TRIM(Manufacturer_name) LIKE LOWER('%$Search_content%') OR ".
			"TRIM(Model) LIKE LOWER('%$Search_content%') ".
			"ORDER BY Manufacturer_name ASC, model ASC;";
						
    $result = mysqli_query($conn,$query);
	
    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {
	    echo "<div class='container-fluid'>";
        echo "<h4 style='text-align:left'> Summary of Manufacturer/Model Containing \"$Search_content\"</h4>";
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
		<th style='text-align: center'>Manufacturer</th>
		<th style='text-align: center'>Model</th>
		</tr>";

		while($row = mysqli_fetch_array($result))
		{
		echo "<tr>";
		
		if(preg_match($Search_content_b,$row['Manufacturer_name']))
   		   echo "<td style='background-color: #90ee90;text-align: center'>".$row['Manufacturer_name']."</td>";
          else echo "<td style='text-align: center'>" . $row['Manufacturer_name'] . "</td>";
		
		if($row['Model'] == NULL){
			echo "<td> </td>";
		}
		else if(preg_match($Search_content_b,$row['Model'])){ 
   		   echo "<td style='background-color: #90ee90;text-align: center'>".$row['Model']."</td>";} 
		else
		   echo "<td style='text-align: center'>" . $row['Model'] . "</td>";

		echo "</tr>";
		}
		echo "</table>";
		echo "</div>";
   }
   else {
   	    echo "<div class='container-fluid'>";
        echo "<h4 style='text-align:left'> No Result is Found</h4>";
		echo "</div>";
   }
   }
}
?>
</div>
</body>
</html>