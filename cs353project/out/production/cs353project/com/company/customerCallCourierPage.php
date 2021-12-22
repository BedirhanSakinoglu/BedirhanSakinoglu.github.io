<?php
session_start();
require_once "config.php";

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === FALSE){
    header("location: login.php");
} else if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}
$id = $_SESSION['user_id'];


function set_session_info($mysqli){
    $_SESSION['package_type'] = $_POST['package_type'];
    $_SESSION['weight'] = $_POST['weight'];
    $_SESSION['dimension1'] = $_POST['dimension1'];
    $_SESSION['dimension2'] = $_POST['dimension2'];
    $_SESSION['dimension3'] = $_POST['dimension3'];
    $_SESSION['courier_type'] = $_POST['courier_type'];
    $_SESSION['delivery_type'] = $_POST['delivery_type'];

    if(isset($_POST['delivery_time_default'])) {
        $dt2 = new DateTime("+1 month");
        $date = $dt2->format("Y-m-d");
        $_SESSION['delivery_time'] = $date;
    }
    else {
        $_SESSION['delivery_time'] = date("Y-m-d", strtotime($_POST['date_day']."-".$_POST['date_month']."-".$_POST['date_year']));
    }

    if($_SESSION['delivery_type'] == "deliver_person") {
        header("location: courierToPersonPage.php");
    }
    else if($_SESSION['delivery_type'] == "deliver_pickup_location") {
        header("location: courierToPickupLocationPage.php");
    }
    else if($_SESSION['delivery_type'] == "deliver_address") {
        header("location: courierToAddressPage.php");
    }
}
if (isset($_POST['get_info'])){
    set_session_info($mysqli);
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Customer Call Courier</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker (unregistered version)">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script>
        function myFunction() {
            var delivery_time_default = document.getElementById("default_time");
            var date_part = document.getElementById("date_div");
            if (delivery_time_default.checked == true){
                document.getElementById("date_day").required = false;
                document.getElementById("date_month").required = false;
                document.getElementById("date_year").required = false;
                date_part.style.display = "none";
            } else {
                date_part.style.display = "block";
            }
        }
    </script>

    <style>
        /* Fonts Form Google Font ::- https://fonts.google.com/  -:: */
        @import url('https://fonts.googleapis.com/css?family=Abel|Abril+Fatface|Alegreya|Arima+Madurai|Dancing+Script|Dosis|Merriweather|Oleo+Script|Overlock|PT+Serif|Pacifico|Playball|Playfair+Display|Share|Unica+One|Vibur');
        @import url('https://fonts.googleapis.com/css?family=Google+Sans:100,300,400,500,700,900,100i,300i,400i,500i,700i,900i');
        /* End Fonts */
        /* Start Global rules */
        /* End Global rules */
        * {
            padding: 0;
            margin: 0;

        }
        h1 {
            font-size: 75px;
            text-align: center;
            background-size: 100% auto !important;
            font-family: 'Google Sans';
            color: #3e403f;
        }
        /* Start body rules */
        body {
            background-image: linear-gradient(-225deg, #ffffff 0%, #EFF9FF 100%);
            background-image: linear-gradient(to top, #ffffff 0%,#EFF9FF 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-family: 'Dubai Light';

            /* background-image: linear-gradient(to top, #d9afd9 0%, #97d9e1 100%); */
        }

        .banner-container{
            display: grid;
            background-color: #3aafff;
            height: 8vh;
            grid-template-columns: 1fr 1fr 1fr;
            column-gap: 5vh;
        }

        .banner-item{

        }

        .left{
            text-align: left;
        }

        .left:hover{
            cursor: pointer;
        }

        .middle{
            text-align: center;
        }

        .right{
            text-align: right;
            margin-right: 3vh;
        }

        #packages {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        #packages td, #packages th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #packages tr:nth-child(even){background-color: #f2f2f2;}

        #packages tr:hover {background-color: #ddd;}

        #packages th {
            padding-top: 12px;
            padding-bottom: 12px;
            padding-left: 8px;
            text-align: left;
            background-color: #3aafff;
            color: white;
        }

        p {
            font-family: 'Dubai Light';
            margin-top: 5vh;
            font-size: 2.5vh;
        }

        h2 {
            font-family: 'Google Sans';
            font-size: 5vh;
            color: white;
            margin-left: 3vh;
            padding-top: 1vh;
        }

        h3{
            font-family: 'Google Sans';
            font-size: 4vh;
            color: rgb(23, 103, 161);
        }

        h4{
            background-color: #1767a1;
            text-align: center;
            color: white;
            font-family: 'Google Sans';
            font-size: 2vh;
            padding-top: 1vh;
            width: 15vh;
            height: 5vh;
            margin: 0px;
        }

        /* End body rules */

        .panel-header{
            font-family: 'Google Sans';
            font-size: 3vh;
            color: rgb(23, 103, 161);
        }

        /* buttons  */
        .banner-button {
            display: inline-block;
            color: #fff;

            width: 30vh;
            height: 5vh;

            background: #377095;
            border-radius: 5px;

            outline: none;
            border: none;
            margin-top: 1vh;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s linear;


            letter-spacing: 0.05em;
        }

        .report-button{
            display: inline-block;
            color: #fff;

            width: 20vh;
            height: 5vh;

            background: #1767a1;
            border-radius: 5px;

            outline: none;
            border: none;
            margin-top: 1vh;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s linear;
            margin-right: 14px;
            letter-spacing: 0.05em;
        }

        /* buttons hover */
        button:hover {
            background: #29436c;
            box-shadow: none;
        }
        .row {
            margin: 0px !important;
        }
    </style>

</head>
<body>
<div class="banner-container">
    <div class="banner-item left" onclick="location.href='customerDashboard.php';"><h2>ProJet</h2></div>
    <div class="banner-item middle"><button class="banner-button" onclick="location.href='customerDashboard.php';">Home</button> <button class="banner-button" onclick="location.href='customerProfile.php';">My Profile</button></div>
    <div class="banner-item right"><button class="banner-button" onclick="location.href='logout.php';">Logout</button></div>
</div>
<div>
    <form action="" method="post">
        <div class="row">
            <div class="col-7">
                <ul class="list-group list-group-flush ml-2">
                    <li class="list-group-item mt-4 border border-secondary">
                        <h3 class="panel-header">Choose a Package Type*</h3>
                        <input type="radio" id="default_package"
                               name="package_type" value="default_package" required>
                        <label for="default_package" class="mr-5">Default Package</label>

                        <input type="radio" id="fragile_package"
                               name="package_type" value="fragile_package">
                        <label for="fragile_package" class="mr-5">Fragile Package</label>

                        <input type="radio" id="spoilable_package"
                               name="package_type" value="spoilable_package">
                        <label for="spoilable_package" class="mr-5">Spoilable Package</label>
                    </li>
                    <li class="list-group-item mt-4 border border-secondary">
                        <h3 class="panel-header">Enter the Necessary Properties About The Package*</h3>
                        <label for="weight" class="ml-1">Weight(kg):</label>
                        <input type="text" id="weight"
                               name="weight" value="" style="width:6vh" class="mr-4" required>

                        <label for="dimension" class="ml-1">Dimensions(cm x cm x cm):</label>
                        <input type="text" id="dimension1"
                               name="dimension1" value="" class="m-3" style="width: 5vh" required>

                        <span>X</span>
                        <input type="text" id="dimension2"
                               name="dimension2" value="" class="m-3" style="width: 5vh" required>

                        <span>X</span>
                        <input type="text" id="dimension3"
                               name="dimension3" value="" class="m-3" style="width: 5vh" required>
                    </li>
                    <li class="list-group-item mt-4 border border-secondary">
                        <h3 class="panel-header">Choose Courier Type*</h3>
                        <input type="radio" id="default_courier"
                               name="courier_type" value="default_courier" required>
                        <label for="default_courier" class="mr-5">Default Courier</label>

                        <input type="radio" id="fast_courier"
                               name="courier_type" value="fast_courier">
                        <label for="fast_courier" class="mr-5">Fast Courier</label>

                        <input type="radio" id="heavy_courier"
                               name="courier_type" value="heavy_courier">
                        <label for="heavy_courier" class="mr-5">Heavy Courier</label>
                    </li>
                    <li class="list-group-item mt-4 border border-secondary">
                        <h3 class="panel-header">Select Delivery Time</h3>
                        <input type="checkbox" name="delivery_time_default" id="default_time" onclick="myFunction();">
                        <label for="default_time" class="mr-5">Send in default time</label>
                        <br>
                        <div id="date_div">
                            <label for="date" class="ml-1">Choose Date (DD/MM/YYYY):</label>
                            <input type="text" id="date_day"
                                   name="date_day" value="" class="m-2" style="width: 5vh" required>

                            <span>/</span>
                            <input type="text" id="date_month"
                                   name="date_month" value="" class="m-2" style="width: 5vh" required>

                            <span>/</span>
                            <input type="text" id="date_year"
                                   name="date_year" value="" class="m-2" style="width: 5vh" required>
                        </div>

                    </li>
                    <li class="list-group-item mt-4 border border-secondary">
                        <h3 class="panel-header">Choose a Delivery Type*</h3>
                        <input type="radio" id="deliver_person"
                               name="delivery_type" value="deliver_person" required>
                        <label for="deliver_person" class="mr-5">Deliver to a Person</label>

                        <input type="radio" id="deliver_pickup_location"
                               name="delivery_type" value="deliver_pickup_location">
                        <label for="deliver_pickup_location" class="mr-5">Deliver to a Pick-up Location</label>

                        <input type="radio" id="deliver_address"
                               name="delivery_type" value="deliver_address">
                        <label for="deliver_address" class="mr-5">Deliver to an Address</label>
                    </li>
                </ul>
            </div>
            <div class="col-5 border-left mt-4 border-secondary d-flex flex-column">
                <div class="ml-2">
                    <h3 class="panel-header">Step 1/2</h3>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                        </div>
                    </div>
                </div>
                <div class="ml-2">
                    <div class="">
                        <p>&#9642; Please fill information about your package needed to continue.</p>
                        <p>&#9642; Information about delivery address will be asked in the next step.</p>
                        <p>&#9642; Mandatory information about the package are denoted with the * sign.</p>
                    </div>
                </div>
                <button type="submit" class="report-button" name="get_info">Continue to next step</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>

