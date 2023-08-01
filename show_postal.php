<?php
opcache_reset();
session_start();
if (!isset($_SESSION["Email"])) {
    header("Location: get_email_address.php");
}
?>

<?php
require 'lib/db_config.php';
if (isset($_POST['Yes'])) {
    header("Location: phone_number_entry.php");
}
if (isset($_POST['No'])) {

    header("Location: postal_code_entry.php");
}
?>




<!DOCTYPE html>
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
    <title>Enter Phone Number</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
    .center {
        text-align: center;

    }
    </style>
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
    <div class="center">
        <?php
        echo "You entered the following postal code:<br />";
        echo $_SESSION["Postal_code"] . "<br />";
        echo $_SESSION["City"] . ', ' . $_SESSION["Zip_state"] . "<br />";
        echo "<br />";
        echo "Is this correct?<br />";
        ?>

    </div>
    <div class="container-fluid">



        <form action="show_postal.php" method="post" style="text-align:left; padding-left:10%; padding-right:10%;">



            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><input class="btn btn-primary" type="submit" name="Yes" value="Yes" style="float:left;"
                                </th>
                        <th><input class="btn btn-primary" type="submit" name="No" value="No" style="float:right;"></th>

                    </tr>
                </thead>
            </table>


        </form>
    </div>





</body>

</html>