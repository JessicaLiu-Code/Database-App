<?php
opcache_reset();
session_start();
if (!isset($_SESSION["Email"])) {
    header("Location: get_email_address.php");
}
?>

<?php
require 'lib/db_config.php';
if (isset($_POST["postal_code"])) {

    // $servername = "localhost";
    // $username = "gatechUser";
    // $password = "gatech123";
    // $databasename = "cs6400_fa22_team006";
    // $porter = "3307";
    // // Create connection
    // $db = mysqli_connect($servername, $username, $password, $databasename, $porter);


    $Postal_code = $_POST["postal_code"];
    // $_SESSION["Postal_code"] = $Postal_code;

    $query = "SELECT Postal_code, City, Zip_state
    FROM ZIPCODE
    WHERE ZIPCODE.Postal_code='$Postal_code'";
    $result = mysqli_query($conn, $query);



    if (!is_bool($result) && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION["Postal_code"] = $Postal_code;
        $_SESSION["City"] = $row['City'];
        $_SESSION["Zip_state"] = $row['Zip_state'];
        header("Location: show_postal.php");
    } else {
        echo "<script>alert(\"Postal Code:$Postal_code not found in the database!\");</script>";
        //array_push($error_msg,  "Query ERROR: Failed to get Infor of Postal Code: $Postal_code...<br>" . __FILE__ ." line:". __LINE__ );
    }
}
?>

<html lang="en">

<head>
    <div class="container-fluid" style="text-align:center">
        <hr>
        <h5>Hemcraft Web Browser</h5>
        <label for="file">File progress:</label>
        <progress id="file" max="100" value="25"> 25% </progress>
        <hr>
    </div>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter postal code</title>
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



    <div class="container-fluid" style="text-align:center">
        <h1>Enter household info</h1>

    </div>
    <div class="container-fluid" style="text-align:left; padding-left:29%; padding-right: 29%;">
        <form action="postal_code_entry.php" method="post">

            <label for="email">Please enter your five digit postal code:</label>
            <input class="form-control" type="text" , pattern="^[0-9]{1,9}$" name="postal_code" minlength="5"
                maxlength="5" placeholder="00000" required>

            <input class="btn btn-primary" type="submit" name="createpostal_code" value="Submit" style="float:right;">
        </form>
    </div>



</body>

</html>