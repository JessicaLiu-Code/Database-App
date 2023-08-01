<?php
opcache_reset();
session_start();
if (!isset($_SESSION["Email"])) {
    header("Location: get_email_address.php");
}
?>
<?php
require 'lib/db_config.php';
if (isset($_POST['submit'])) {
    if (!isset($_POST['area_code'])) {
        //If no phone entry, to next
        //echo "<script>alert('Prefer not to enter phone number!')</script>";
        $_SESSION["has_phone"] = "No";
        header("Location:household_info.php");
    } else {
        $area_code = $_POST['area_code'];
        //$area_code = preg_replace("/[\s()-]/", "", $area_code);
        $phone_number = $_POST['phone_number'];
        //$phone_number = preg_replace("/[\s()-]/", "", $phone_number);
        $query = "SELECT COUNT(Email) AS total
                            FROM phone 
                            WHERE Area_code='$area_code' 
                            AND Pnumber='$phone_number'";
        $result = mysqli_query($conn, $query);
        if (!is_bool($result) && (mysqli_fetch_array($result)['total'] > 0)) {
            //Found phone number in the dataset
            echo "<script>alert('The phone number\"$area_code - $phone_number\" exist!');</script>";
        } else {
            //Judge Email exist or not.
            //session
            $_SESSION["Area_code"] = $area_code;
            $_SESSION["Pnumber"] = $phone_number;
            $_SESSION["Phone_type"] = $_POST['phone_type'];
            $_SESSION["has_phone"] = "Yes";
            //goto next form/page
            header("Location: household_info.php");
        }
    }
}


?>

<html>

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
    <title>Enter phone number</title>
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


    <h1 style="text-align:center">Enter household info<br /></h1>

    <div class="container-fluid" id="phone_entry" style="text-align:left; padding-left:29%; padding-right:15%;">
        <table id="table1">
            Would you like to enter a phone number?
            <input type="radio" name="has_phone" onclick="handleclick()" value="Yes" checked>Yes
            <input type="radio" name="has_phone" onclick="handleclick()" value="No">No<br>
        </table>
        <form id="phone_form" class="center" action="" method="POST">
            Please enter your phone number:<br>
            <table class="center">
                <tr>
                    <td>Area code:</td>
                    <td><input name="area_code" type="text" pattern="^[0-9]{1,9}$" minlength="3" maxlength="3"
                            placeholder="000"></td>
                </tr>
                <tr>
                    <td>Number:</td>
                    <td><input name="phone_number" type="text" pattern="^[0-9]{1,9}$" minlength="7" maxlength="7"
                            placeholder="0000000"></td>
                </tr>
                <tr>
                    <td>Choose a phone type:</td>
                    <td>
                        <select name="phone_type" id="phone_type">
                            <option value="home">Home</option>
                            <option value="mobile">Mobile</option>
                            <option value="work">Work</option>
                            <option value="other">Other</option>
                        </select>
                    </td>
                </tr>
            </table>
            <br>
            <input class="btn btn-primary" type="submit" name="submit" value="Next" style="float:right;">

        </form>
    </div>

    <script>
    var phone_pre = "Yes";
    //home, mobile, work, or other
    var phone_entry = `Please enter your phone number:<br>
                 <table class="center">
                     <tr>
                      <td>Area code:</td>
                      <td><input name="area_code" type="text" pattern="^[0-9]{1,9}$"  minlength="3"
                      maxlength="3"  placeholder="000"></td>
                    </tr>
                    <tr>
                     <td>Number:</td>
                     <td><input name="phone_number" type="text" pattern="^[0-9]{1,9}$"  minlength="7"
                     maxlength="7" placeholder="0000000"></td>
                     </tr>
                     <tr>
                      <td>Choose a phone type:</td><td>
                       <select name="phone_type" id="phone_type"> 
                        <option  value="home">Home</option> 
                        <option  value="mobile">Mobile</option> 
                        <option  value="work">Work</option>
                        <option  value="other">Other</option> </select>
                     </td>
                    </tr>
                    </table>`;
    var nbutton = '<input class="btn btn-primary" type="submit" name="submit" value="Next" style="float:right;">';

    function handleclick() {
        //alert("handleclick");
        //update phone_form information based on radio clicks
        const has_phone = document.querySelector('input[name=has_phone]:checked').value;


        if (has_phone == "Yes") {
            document.getElementById("phone_form").innerHTML = phone_entry + "<br/>" + nbutton;
        } else {
            document.getElementById("phone_form").innerHTML = nbutton;
        }
        phone_pre = has_phone;
        //alert("phone choose changed to " + has_phone);

        //return false;

    }
    </script>


</html>