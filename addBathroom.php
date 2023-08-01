<?php
opcache_reset();
session_start();
include 'lib/db_config.php';
?>

<?php

if (!isset($_SESSION['Email'])) {
    echo "<script>alert('Household email is not found! Please re-login. ');</script>";
} else {
    $Email = $_SESSION['Email'];
}


$query = "SELECT Is_primary FROM FULL_BATH WHERE FULL_BATH.Email='$Email' AND Is_primary=TRUE;";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);


if (isset($_POST['fNext'])) {
    if (isset($_SESSION['Id_bathroom'])) {
        //get id
        $Id_bathroom = $_SESSION['Id_bathroom'];
    } else {
        //set a default value if not isset
        $Id_bathroom = 1;
    }

    if ($_POST['fbathtubs'] + $_POST['fshowers'] + $_POST['ftubshowers'] == 0) {
        echo "<script>alert(\"Must have at least one of the following: Bathtub, Shower, or Tubshower!\");</script>";
    } else {
        $No_sink = $_POST['fsinks'];
        $No_commode = $_POST['fcommodes'];
        $No_bidet = $_POST['fbidets'];
        $No_bathtub = $_POST['fbathtubs'];
        $No_shower = $_POST['fshowers'];
        $No_tub = $_POST['ftubshowers'];
        if ($_POST['fisPrimary'] == 'isPrimary') {
            $Is_primary = 1;
        } else {
            $Is_primary = 0;
        }

        $query1 = "INSERT INTO BATHROOM (Email, Id, No_sink, No_commode, No_bidet) VALUES ('$Email', $Id_bathroom, $No_sink, $No_commode, $No_bidet); ";
        $query2 = "INSERT INTO FULL_BATH (Email, Id, Is_primary, No_bathtub, No_shower, No_tub) VALUES ('$Email', $Id_bathroom, $Is_primary, $No_bathtub, $No_shower, $No_tub);";
        mysqli_query($conn, $query1);
        mysqli_query($conn, $query2);

        $Id_bathroom++;
        $_SESSION['Id_bathroom'] = $Id_bathroom;

        header('Location: bathroom_listing.php');
        // exit();
    }
}

if (isset($_POST['hNext'])) {
    if (isset($_SESSION['Id_bathroom'])) {
        //get id
        $Id_bathroom = $_SESSION['Id_bathroom'];
    } else {
        //set a default value if not isset
        $Id_bathroom = 1;
    }



    if ($_POST['hsinks'] + $_POST['hcommodes'] + $_POST['hbidets'] == 0) {
        echo "<script>alert(\"Must have at least one of the following: Sink, Bidet or Commode!\");</script>";
    } else {
        $No_sink = $_POST['hsinks'];
        $No_commode = $_POST['hcommodes'];
        $No_bidet = $_POST['hbidets'];
        $HName = $_POST['hname'];

        $query1 = "INSERT INTO BATHROOM (Email, Id, No_sink, No_commode, No_bidet) VALUES ('$Email', $Id_bathroom, $No_sink, $No_commode, $No_bidet); ";
        $query2 = "INSERT INTO HALF_BATH (Email, Id, HName) VALUES ('$Email', $Id_bathroom, '$HName'); ";
        mysqli_query($conn, $query1);
        mysqli_query($conn, $query2);

        $Id_bathroom++;
        $_SESSION['Id_bathroom'] = $Id_bathroom;

        header('Location: bathroom_listing.php');
        // exit();
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
        <progress id="file" max="100" value="50"> 50% </progress>
        <hr>
    </div>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bathroom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial;
        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            margin: 0 auto;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
            margin: 0 auto;
            align-self: center;
        }
    </style>
</head>

<body>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>


    <div class="container-fluid" style="text-align:center">
        <h1>Add bathroom</h1>
        <h5>Please provide the details regarding the bathroom.</h5>
        <h5>Choose Half or Full Bathroom:</h5>
    </div>

    <div class="container-fluid" style="text-align:center">
        <form action="bathroom_listing.php">
            <input type="submit" value="Go To Bathroom List" class="btn btn-primary" />
        </form>


        <div class="tab" style='width:50%'>
            <button class="tablinks" onclick="openBath(event, 'Half')">Half</button>
            <button class="tablinks" onclick="openBath(event, 'Full')" id="defaultOpen">Full</button>
        </div>

        <div name="addHalfBath" id="Half" action="addBathroom.php" method="POST" class="tabcontent" style="width:50%">
            <form action="addBathroom.php" method="post">
                <table>
                    <tr>
                        <td>Sinks:</td>
                        <td><input type="number" class="count" name="hsinks" min="0" value="0" size=1>
                        </td>
                    </tr>
                    <tr>
                        <td>Commodes:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><input type="number" class="count" name="hcommodes" min="0" value="0" size=1>
                        </td>
                    </tr>
                    <tr>
                        <td>Bidets:</td>
                        <td><input type="number" class="count" name="hbidets" min="0" value="0" size=1>
                        </td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="hname"></td>
                    </tr>
                    <!-- <tr>    
                    <td><input class="btn btn-primary" type="submit" name="hNext" value="Next" style="float:right;"></td>
                </tr> -->
                </table>
                <td><input class="btn btn-primary" type="submit" name="hNext" value="Next"></td>
            </form>
        </div>


        <div name="addFullBath" id="Full" action="addBathroom.php" method="POST" class="tabcontent" style="width:50%">

            <form action="addBathroom.php" method="post">
                <table>
                    <tr>
                        <td>Sinks:</td>
                        <td><input type="number" class="count" name="fsinks" min="0" value="0" size=1>
                        </td>
                    </tr>
                    <tr>
                        <td>Commodes:</td>
                        <td><input type="number" class="count" name="fcommodes" min="0" value="0" size=1>
                        </td>
                    </tr>
                    <tr>
                        <td>Bidets:</td>
                        <td><input type="number" class="count" name="fbidets" min="0" value="0" size=1>
                        </td>
                    </tr>
                    <tr>
                        <td>Bathtubs:</td>
                        <td><input type="number" class="count" name="fbathtubs" min="0" value="0" size=1>
                        </td>
                    </tr>
                    <tr>
                        <td>Showers:</td>
                        <td><input type="number" class="count" name="fshowers" min="0" value="0" size=1>
                        </td>
                    </tr>
                    <tr>
                        <td>Tub/Showers:</td>
                        <td><input type="number" class="count" name="ftubshowers" min="0" value="0" size=1>
                        </td>
                    </tr>

                    <tr>
                        <td>This bathroom is a primary bathroom:</td>
                        <td><input type="checkbox" id="isPrimary" name="fisPrimary" value="isPrimary" /></td>
                    </tr>
                </table>
                <input class="btn btn-primary" type="submit" name="fNext" value="Next">
            </form>
        </div>

    </div>

    <script>
        function openBath(evt, bathType) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(bathType).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function disable() {
            document.getElementById("isPrimary").disabled = true;
        }

        function undisable() {
            document.getElementById("isPrimary").disabled = false;
        }
        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
        var checkstat = "<?php echo "$resultCheck" ?>";
        if (checkstat == 1) {
            disable();
        }
    </script>
</body>

</html>