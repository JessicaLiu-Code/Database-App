<?php
opcache_reset();
session_start();
?>

<?php
require 'lib/db_config.php';
if (isset($_POST['email'])) {

    // $servername = "localhost";
    // $username = "gatechUser";
    // $password = "gatech123";
    // $databasename = "cs6400_fa22_team006";
    // $porter = "3307";
    // Create connection
    // $db = mysqli_connect($servername, $username, $password, $databasename, $porter);

    $Email = $_POST["email"];
    $query = "SELECT COUNT(Email) AS total
        FROM HOUSEHOLD
        WHERE HOUSEHOLD.Email='$Email'";

    //echo "before";
    $result = mysqli_query($conn, $query);
    #mysql_result($result, 0);
    $data = mysqli_fetch_assoc($result);
    //echo $data['total'];
    if ($data['total'] >= 1) {

        echo "<script>alert('The email:\"$Email\" exist!');</script>";
    } else {
        //session
        $_SESSION["Email"] = $Email;
        //goto next form/page
        header("Location: postal_code_entry.php");
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
        <progress id="file" max="100" value="0"> 0% </progress>
        <hr>
    </div>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Email Address</title>
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



    <div style="text-align:center;  padding-left:15%; padding-right: 15%;">
        <h1>Enter household info</h1>

    </div>
    <div style="text-align:left; padding-left:29%; padding-right:29%;">
        <form action="get_email_address.php" method="post">

            <label for="email">Please enter your email address:</label>

            <input class="form-control" type="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,9}$"
                name="email" placeholder="Example@example.com" size="50" required />

            <input class="btn btn-primary" type="submit" name="createEmail" value="Submit" style="float:right;">
        </form>
    </div>


</body>

</html>