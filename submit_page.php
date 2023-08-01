<!DOCTYPE html>
<html lang="en">

<?php
opcache_reset();
require 'lib/db_config.php';
?>

<head>
    <div class="container-fluid" style="text-align:center">
        <hr>
        <h5>Hemcraft Web Browser</h5>
        <label for="file">File progress:</label>
        <progress id="file" max="100" value="100"> 100% </progress>
        <hr>
    </div>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>



    <div class="container-fluid">
	    <h3 style="text-align:center">Submission Complete!</h3></br>
        <h5 style="text-align:center">Thank you for providing your information to Hemcraft!</h5></br>
   </div>
   <div style="text-align:left; padding-left:43%">
        <a style="text-align:center" color = 'blue' href="index.php">Return to main menu</a>
    </div>

<?php
session_start();
unset($_SESSION['Id_appliance']);
unset($_SESSION['Id_bathroom']);
unset($_SESSION['Email']);
?>

</body>

</html>