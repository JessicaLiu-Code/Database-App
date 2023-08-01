<?php

session_start();
require 'lib/db_config.php';

if(isset($_POST['ApplianceType'])){
		if ($_POST['ApplianceType'] == "Refrigerator/freezer"){
		$ApplianceType ="Refrigerator";
	    } else{
	    $ApplianceType = $_POST['ApplianceType'];	
	    }
	
	$_SESSION['ApplianceType'] = $ApplianceType;

	$query = mysqli_query($conn,"SELECT Manufacturer_name FROM MANUFACTURERATYPE WHERE AType='$ApplianceType' order by Manufacturer_name");
	?>
	<select name="Manufacturer" class="form-control">
	   <option value="">select Manufacturer</option>
	   <?php
	   while ($row = mysqli_fetch_array($query)){
		   ?>
		   <option value = "<?php echo $row['Manufacturer_name']?>" ><?php echo $row['Manufacturer_name']?></option>
           <?php
	   }
?>
</select>
<?php
}
?>