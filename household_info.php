<?php
opcache_reset();
session_start();
if (!isset($_SESSION["Email"])) {
    header("Location: get_email_address.php");
}
?>
<?php
require 'lib/db_config.php';

if (isset($_POST["square_footage"])) {

    //echo "<script>alert('aaaaa')</script>";
    $square_footage = $_POST["square_footage"];


    $HType = $_POST["home_type"];
    $Square_footage = $_POST["square_footage"];
    $No_occupants = $_POST["occupants"];
    $No_bedroom = $_POST["bedrooms"];
    $Email = $_SESSION["Email"];
    $Postal_code = $_SESSION["Postal_code"];
    //DELETE if Email exists!
    $query = "DELETE FROM HOUSEHOLD WHERE Email = '$Email'";
    $result = mysqli_query($conn, $query);
    //echo "<script>alert('After Delete if exists')</script>";

    $query = "INSERT INTO HOUSEHOLD (Email, HType, Square_footage, No_occupants, No_bedroom, Postal_code)
    VALUES ('$Email', '$HType', $Square_footage, $No_occupants, $No_bedroom, '$Postal_code')";
    //$_SESSION["Phone_type"]
    $result = mysqli_query($conn, $query);
    //echo "<script>alert('Insert household')</script>";
    if ($result  == False) {
        echo "<script>alert('insert household fail')</script>";
        header("Location:household_info.php");
    }
    #$_POST["has_phone"]=="Yes"
    if (isset($_SESSION["has_phone"])) {
        if ($_SESSION["has_phone"] == "Yes") {
            $query = "SELECT * FROM PHONE WHERE Email='$Email'";
            $result = mysqli_query($conn, $query);
            if (!is_bool($result) && (mysqli_fetch_array($result)['total'] > 0)) {
                //Found phone number in the dataset
                echo "<script>alert('The household $Email already got one phone number!');</script>";
                header("Location:phone_number_entry.php");
            } else {
                $phoneType = $_SESSION["Phone_type"];
                $areaCode = $_SESSION["Area_code"];
                $phoneNumber = $_SESSION["Pnumber"];
                //echo "<script>alert('Before Insert phone')</script>";
                //echo "<script>alert('$phoneType $areaCode $phoneNumber')</script>";
                $query = "INSERT INTO PHONE (Phone_type, Area_code, PNumber,Email) VALUES ('$phoneType', '$areaCode', '$phoneNumber','$Email')";
                //echo "<script>alert('$query')</script>";
                $result = mysqli_query($conn, $query);
                //echo "<script>alert($query)</script>";
                if ($result  == False) {
                    echo "<script>alert('insert phone number fail')</script>";
                    header("Location:phone_number_entry.php");
                }
            }
        }
    }


    header("Location:addBathroom.php");
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
    <title>Enter household info</title>
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
    <div class="container-fluid" style="text-align:left; padding-left:29%; padding-right:20%;">
        <p>Please enter the following details for your household:</p>

    </div>
    <div class="container-fluid" style="text-align:left; padding-left:29%; padding-right:29%;">
        <form action="household_info.php" method="post">

            <table>


                <tr>
                    <td>Home type:</td>
                    <td><select id="hometype" name="home_type">
                            <option value="house">House</option>
                            <option value="apartment">Apartment</option>
                            <option value="townhome">Townhome</option>
                            <option value="condominium">Condominium</option>
                            <option value="mobile home">Mobile Home</option>
                        </select>
                    </td>


                </tr>
                <tr>
                    <td>Square footage:</td>
                    <td><input type="number" name="square_footage" min="1" minlength="1" value="2200" required></td>

                </tr>
                <tr>
                    <td>Occupants:</td>
                    <td><input type="number" class="count" name="occupants" min="0" minlength="1" value="1" size=1
                            required>
                    </td>
                </tr>
                <tr>
                    <td>Bedrooms:</td>
                    <td><input type="number" class="count" name="bedrooms" min="0" "  minlength=" 1" value="1" size=1
                            required>
                    </td>
                </tr>
            </table>


            <input class="btn btn-primary" type="submit" name="Next" value="Next" style="float:left;">


    </div>



</body>

</html>