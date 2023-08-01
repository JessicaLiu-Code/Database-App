<?php
opcache_reset()
?>

<?php
session_start();
require 'lib/db_config.php';

$_SESSION['Email']='c@conecom.com';

$applianceTypes = [
    ["id" => "TV",           "displayName" => "TV"],
	["id" => "Cooker",       "displayName" => "Cooker"],
	["id" => "Washer",       "displayName" => "Washer"],
	["id" => "Dryer",        "displayName" => "Dryer"],
	["id" => "Refrigerator", "displayName" => "Refrigerator/freezer"]
  ];

if (!isset($_SESSION['Email'])){
	header('Location: index.php');
	exit();
}else{
	$Email = $_SESSION['Email'];
}

	
if(isset($_POST['addDryer']))
{
	if(isset($_SESSION['Id_appliance'])){
	//get it
	$Id_appliance = $_SESSION['Id_appliance'];
	} else {
	//set a default value if not isset
	$Id_appliance = 1;
	}

$Manufacturer_name=$_POST['Manufacturer'];
$Model=$_POST['Model'];
$Heat_source = $_POST['Heat_source'];

$query1 = " INSERT INTO APPLIANCE (Email, Id, Model, Manufacturer_name) VALUES ('$Email', $Id_appliance, '$Model', '$Manufacturer_name');";
$query2 = "INSERT INTO DRYER (Email, Id, Heat_source) VALUES ('$Email', $Id_appliance, '$Heat_source');";
$result1 = mysqli_query($conn,$query1);
$result2 = mysqli_query($conn,$query2);
	
$Id_appliance++;
$_SESSION['Id_appliance'] = $Id_appliance;	

header('Location: appliance_list.php');	
exit(); 
}
   
if(isset($_POST['addWasher']))
{  
	if(isset($_SESSION['Id_appliance'])){
	//get it
	$Id_appliance = $_SESSION['Id_appliance'];
	} else {
	//set a default value if not isset
	$Id_appliance = 1;
	}
$Manufacturer_name=$_POST['Manufacturer'];
$Model=$_POST['Model'];
$Load_type = $_POST['Load_type'];
	
$query1 = " INSERT INTO APPLIANCE (Email, Id, Model, Manufacturer_name) VALUES ('$Email', $Id_appliance, '$Model', '$Manufacturer_name');";
$query2 = "INSERT INTO WASHER (Email, Id, Load_type) VALUES ('$Email', $Id_appliance, '$Load_type');";
$result1 = mysqli_query($conn,$query1);
$result2 = mysqli_query($conn,$query2);

$Id_appliance++;
$_SESSION['Id_appliance'] = $Id_appliance;
header('Location: appliance_list.php');	
exit(); 

}

if(isset($_POST['addRefrigerator']))
{  
	if(isset($_SESSION['Id_appliance'])){
	//get it
	$Id_appliance = $_SESSION['Id_appliance'];
	} else {
	//set a default value if not isset
	$Id_appliance = 1;
	}

$Manufacturer_name=$_POST['Manufacturer'];
$Model=$_POST['Model'];
$RType = $_POST['RType'];

$query1 = " INSERT INTO APPLIANCE (Email, Id, Model, Manufacturer_name) VALUES ('$Email', $Id_appliance, '$Model', '$Manufacturer_name');";
$query2 = "INSERT INTO REFRIGERATOR (Email, Id, RType) VALUES ('$Email', $Id_appliance, '$RType');";
$result1 = mysqli_query($conn,$query1);
$result2 = mysqli_query($conn,$query2);
	
$Id_appliance++;
$_SESSION['Id_appliance'] = $Id_appliance;
header('Location: appliance_list.php');	
exit(); 
}
 

 
if(isset($_POST['addTV']))
{
	if(isset($_SESSION['Id_appliance'])){
	//get it
	$Id_appliance = $_SESSION['Id_appliance'];
	} else {
	//set a default value if not isset
	$Id_appliance = 1;
	}
	if ($_POST['Display_size'] == ""){
	 echo "<script>alert('TV Display_size is missing! Retry');</script>"; 
	} else{

	$Manufacturer_name=$_POST['Manufacturer'];
	$Model=$_POST['Model'];
	$Display_type = $_POST['Display_type'];
	$Max_resolution = $_POST['Max_resolution'];
	$Display_size = $_POST['Display_size'];

	$query1 = " INSERT INTO APPLIANCE (Email, Id, Model, Manufacturer_name) VALUES ('$Email', $Id_appliance, '$Model', '$Manufacturer_name');";
	$query2 = " INSERT INTO TV (Email, Id, Display_type,Max_resolution,Display_size) VALUES('$Email','$Id_appliance', '$Display_type','$Max_resolution','$Display_size');";
	$result1 = mysqli_query($conn,$query1);
	$result2 = mysqli_query($conn,$query2);
		
	$Id_appliance++;
	$_SESSION['Id_appliance'] = $Id_appliance;	
	header('Location: appliance_list.php');	
	exit(); }
}
 
 
if(isset($_POST['addCooker']))
{   if(($_POST['Oven']=="Oven") OR ($_POST['Cooktop']=="Cooktop"))
   {   
	if(isset($_SESSION['Id_appliance'])){
	//get it
	$Id_appliance = $_SESSION['Id_appliance'];
	} else {
	//set a default value if not isset
	$Id_appliance = 1;
	}
	$Manufacturer_name=$_POST['Manufacturer'];
	$Model=$_POST['Model'];
	$query1 = "INSERT INTO APPLIANCE (Email, Id, Model, Manufacturer_name) VALUES ('$Email', $Id_appliance, '$Model', '$Manufacturer_name');";
	$query2 = "INSERT INTO COOKER (Email, Id) VALUES ('$Email', '$Id_appliance');";
	
    $result1 = mysqli_query($conn,$query1);	
	$result2 = mysqli_query($conn,$query2);
	
	if ($_POST['Cooktop']=="Cooktop"){

		$Cooktop_Heat_source = $_POST['Cooktop_Heat_source'];

		$query3 = "INSERT INTO COOKTOP (Email, Id,Heat_source) VALUES ('$Email', $Id_appliance, '$Cooktop_Heat_source');";
		$result3 = mysqli_query($conn,$query3);
				 
   }
 

  if($_POST['Oven']=="Oven") 
   {	
	$OType = $_POST['OType'];
	$Oven_Heat_source = $_POST['Oven_Heat_source'];

	$query3 = "INSERT INTO OVEN (Email, Id,OType) VALUES ('$Email', $Id_appliance,'$OType');";


	$result3 = mysqli_query($conn,$query3);
	
	foreach($Oven_Heat_source as $Oven_Heatsource) {
		$query4 = "INSERT INTO OVEN_HEAT_SOURCE (Email, Id, Heat_source) VALUES ('$Email', $Id_appliance, '$Oven_Heatsource');";
	    $result4 = mysqli_query($conn,$query4);
		}
	
   } 
    $Id_appliance++;
	$_SESSION['Id_appliance'] = $Id_appliance;	
	header('Location: appliance_list.php');	
	exit();	
   }

 else {
	echo "<script>alert('Oven and/or Cooktop Checkbox not selected! Retry ');</script>"; 
    }	
  }
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
    <title>Add Appliance</title>
	
	<form action="appliance_list.php" style="text-align:center">
       <input type="submit" value="Go To Appliance List" class="btn btn-primary"/>
    </form>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
	  var selectedAppliance;

	  function toggleForm(selected) {		  
		  if (selectedAppliance) {
			$("#add"+selectedAppliance).hide();
		  }
		  $("#add"+selected).show();
	  }
	    
	  $(document).ready(function(){
		// Country dependent ajax
		$("#ApplianceType").on("change",function(){
		  var applianceType = $(this).val();

		  toggleForm(applianceType);
		  selectedAppliance = applianceType;
		 $.ajax({
			url :"appliance_manufacturer.php",
			type:"POST",
			data:{ApplianceType:applianceType},
			success:function(data){
			  $("#Manufacturer").html(data);
			}
		  });
		});
	  });
	  
	  
	  $(document).ready(function(){
		  <?php
			foreach($applianceTypes as $key=>$applianceType) {
				?>
				$("#add<?php echo $applianceType['id'] ?>").hide();
				<?php
			}
		  ?> 
	  })   
	</script>	
</head>

<body>
    <div>
        <form name = "addAppliance" action="addAppliance.php" method="post" style="text-align:left; padding-left:33%">

             <div class="col-sm-6" style="text-align:center">
                <h1>Add appliance</h1>
                    <h5>Please provide the details for the appliance</h5>	
                        <hr class="mb-3">
                        <label for="ApplianceType">Appliance type:</label>
                        <select name="ApplianceType" id="ApplianceType" required>
                            <!-- TV, Cooker, Washer, Dryer, Refrigerator/freezer. -->
							<option value="Select Appliance" disabled selected>-- Select --</option>
							<?php
								foreach($applianceTypes as $key=>$applianceType) {
									?>
									<option value="<?php echo $applianceType['id'] ?>" ><?php echo $applianceType['displayName'] ?></option>
									<?php
								}
							 ?>
                        </select></br></br>			
                        <label for="Manufacturer">Manufacturer:</label>
                       	<select name="Manufacturer" id="Manufacturer" style="text-align:center" class="form-control" required>
							<option selected="selected">select Manufacturer</option>
						</select></br>                
                        <label for="Model">Model:</label>                        
						<input class="form-control" type="text" name="Model" placeholder="Model" style="text-align:center"></br></br>

            </div>
        		
			<div name = "addTV" id="addTV" action="addAppliance.php" method="post">
	
						<div class="col-sm-6" style="text-align:center">
							<label for="Display_type">TV Display type:</label>
							<select name="Display_type" id="Display_type" required>
								<!-- tube, DLP, plasma, LCD, or LED. -->
								<option value="LED" >LED</option>
								<option value="tube">tube</option>
								<option value="DLP">DLP</option>
								<option value="LCD">LCD</option>
								<option value="plasma">plasma</option>
							</select></br></br>
                 
							<label for="Display_size">TV Display size (To tenth inches):</label>                        
							<input type="number" max= 10000000 min=0 step=0.1 name="Display_size" class="input-hidden"></br></br>
							
							 
							<label for="Max_resolution">TV Maximum resolution:</label>
							<select name="Max_resolution" id="Max_resolution" required>
								<!-- 480i, 576i, 720p, 1080i, 1080p, 1440p, 2160p (4K), or 4320p (8K). -->
								<option value="480i">480i</option>
								<option value="576i">576i</option>
								<option value="720p">720p</option>
								<option value="1080i">1080i</option>
								<option value="1080p">1080p</option>
								<option value="1440p">1440p</option>
								<option value="2160p (4K)">2160p (4K)</option>
								<option value="4320p (8K)">4320p (8K)</option>
							</select> </br></br>
							<input class="btn btn-primary" type="submit" name="addTV" value="Add" style="float:center;">
				
				</div>
			</div>
		
	
			<div name = "addDryer" id ="addDryer" action="addAppliance.php" method="post">
               <div class="col-sm-6" style="text-align:center">             
								<label for="Heat_source">Dryer Heat Source:</label>
								<select name="Heat_source" id="Heat_source" required>
									<!-- gas, electric, or none -->
									<option value="Gas">Gas</option>
									<option value="Electric">Electric</option>
									<option value="None">None</option>
								</select></br></br>                    
								<input class="btn btn-primary" type="submit" name="addDryer" value="Add" style="float:center;">
				</div>
			</div>
		
				<div name = "addRefrigerator" id= "addRefrigerator" action="addAppliance.php" method="post">
							<div class="col-sm-6" style="text-align:center">
                    
								<label for="RType">Refrigerator/freezer Type:</label>
								<select name="RType" id="RType" required>
									<!-- tube, DLP, plasma, LCD, or LED. -->
									<option value="Bottom freezer refrigerator">Bottom freezer refrigerator</option>
									<option value="French door refrigerator">French door refrigerator</option>
									<option value="side-by-side refrigerator">side-by-side refrigerator</option>
									<option value="top freezer refrigerator">top freezer refrigerator</option>
									<option value="chest freezer">chest freezer</option>
									<option value="upright freezer">upright freezer</option>
								</select></br></br>

								<input class="btn btn-primary" type="submit" name="addRefrigerator" value="Add" style="float:center;">
							</div>
				</div>
		
		
				<div name = "addWasher" id="addWasher" action="addAppliance.php" method="post">

							<div class="col-sm-6" style="text-align:center">				
								
								<label for="Load_type">Washer Load type:</label>
								<select name="Load_type" id="Load_type" required>
									<!--  The loading type: either top or front. -->
									<option value="Top">Top</option>
									<option value="Front">Front</option>
								</select></br></br>
							
								<input class="btn btn-primary" type="submit" name="addWasher" value="Add" style="float:center;">
							</div>

				</div>
        
		
				<div name = "addCooker" id="addCooker" action="addAppliance.php" method="post">
				   <style> 
					   #addCooktop { 
							   width: 50%;
							   float: right;	
						   }						   
					   #addOven { 
							   width: 50%;
							   margin: right;	
						   }
				   </style> 				  		
					<div name = "addCooktop" id ="addCooktop" action="addAppliance.php" method="post">

								<div class="col-sm-6" style="text-align:center">
			               
									<input type="checkbox" id="Cooktop" name="Cooktop" value="Cooktop">
									<label for="Cooktop">Cooktop(Check to select)</label></br></br>
	               
									<label for="Cooktop_Heat_source">Cooktop Heat Source:</label>
									<select name="Cooktop_Heat_source" id="Cooktop_Heat_source" required>
										<!-- gas, electric, radiant electric, induction -->
										<option value="Gas" selected>Gas</option>
										<option value="Electric">Electric</option>
										<option value="Radiant electric">Radiant electric</option>
										<option value="Induction">Induction</option>
									</select></br></br>                   
						
								</div>

					</div>

					<div name = "addOven" id ="addOven" action="addAppliance.php" method="post">

								<div class="col-sm-6" style="text-align:center">
								               
									<input type="checkbox" id="Oven" name="Oven" value="Oven">
									<label for="Oven">Oven(Check to select)</label></br></br>
								                
									<label for="Oven_Heat_source">Oven Heat Source <br> (Hold Ctrl to Select More):</label>
									<select name="Oven_Heat_source" id="Oven_Heat_source" multiple>
										<!-- gas, electric, microwave. -->
										<option value="Gas" selected>Gas</option>
										<option value="Electric">Electric</option>
										<option value="Microwave">Microwave</option> 
									</select></br></br>                   
																	   
									<label for="OType">Oven Type:</label>
									<select name="OType" id="OType" required>
										<!-- gas, electric, or none -->
										<option value="Convection">Convection</option>
										<option value="Conventional">Conventional</option>
									</select></br></br>                   
												

						</div>
					</div>  				  
				<input class="btn btn-primary" type="submit" name="addCooker" value="Add" style="float:center;">		  
		    </div>
        </form>
	</div>			

</body>
</html>