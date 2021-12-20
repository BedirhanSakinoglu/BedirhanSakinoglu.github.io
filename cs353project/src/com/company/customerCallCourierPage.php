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
    $_SESSION['package_type'] = $_POST['package_type_1'];
    $_SESSION['weight'] = $_POST['$weight_1'];
    $_SESSION['dimension1'] = $_POST['$dimension1_1'];
    $_SESSION['dimension2'] = $_POST['dimension2_1'];
    $_SESSION['dimension3'] = $_POST['dimension3_1'];
    $_SESSION['courier_type'] = $_POST['courier_type_1'];
    $_SESSION['delivery_time'] = $_POST['delivery_time_1'];
    $_SESSION['delivery_type'] = $_POST['delivery_type_1'];

    //check delivery_type
    /*
    if() {

    }
    */

    /*
    $package_type = $_SESSION['package_type'];
    $sql="INSERT INTO package(weight, status, send_time, package_type, dimension, delivery_address, delivery_time, courier_type) 
            VALUES(35.5, 'Not delivered', DATE '2015-12-17' ,'$package_type','30x30x43','hamamönü', DATE '2015-12-31',0)";
    $mysqli->query($sql) or die('Error in query: ' . $mysqli->error);
    */
}
if (isset($_POST['get_info'])){
    set_session_info($mysqli);
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Customer Dashboard</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker (unregistered version)">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="customerCallCourierPageJS.js"></script>
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

        .grid-container{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: 35vh 35vh;
            column-gap: 5vh;
            row-gap: 5vh;
            margin-right: 3vh;
            margin-left: 3vh;
            margin-top: 7vh;
        }

        .grid-item {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            font-size: 30px;
            text-align: center;
            box-shadow: 0 5px 20px hsla(205, 75%, 36%, 0.31);
        }

        p {
            font-family: 'Dubai Light';
            margin-bottom: 5vh;
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
        /* End body rules */

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

        .send-button{
            display: inline-block;
            color: #fff;

            width: 25vh;
            height: 15vh;

            background: #4e8bb4;
            border-radius: 5px;

            outline: none;
            border: none;

            cursor: pointer;
            text-align: center;
            font-size: 2vh;
            transition: all 0.2s linear;
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
        <div class="row" id="zaxd">
            <div class="col-8">
                <ul class="list-group list-group-flush ml-2">
                    <li class="list-group-item mt-4 border border-secondary">
                        <h3 class="text-primary">Choose a Package Type*</h3>
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
                        <h3 class="text-primary">Enter the Necessary Properties About The Package*</h3>
                        <label for="weight" class="ml-1">Weight(kg):</label>
                        <input type="text" id="weight"
                               name="weight" value="weight" class="mr-4" required>

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
                        <h3 class="text-primary">Choose Courier Type*</h3>
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
                        <h3 class="text-primary">Select Delivery Time</h3>
                        <input type="checkbox" class="" id="default_time">
                        <label for="default_time" class="mr-5">Send in default time</label>
                        <br>
                        <label for="date" class="ml-1">Choose Date (DD/MM/YY):</label>
                        <input type="text" id="date_day"
                               name="date_day" value="" class="m-2" style="width: 5vh" required>

                        <span>/</span>
                        <input type="text" id="date_month"
                               name="date_month" value="" class="m-2" style="width: 5vh" required>

                        <span>/</span>
                        <input type="text" id="date_year"
                               name="date_year" value="" class="m-2" style="width: 5vh" required>
                    </li>
                    <li class="list-group-item mt-4 border border-secondary">
                        <h3 class="text-primary">Choose a Delivery Type*</h3>
                        <input type="radio" id="deliver_person"
                               name="deliver_person" value="deliver_person" required>
                        <label for="deliver_person" class="mr-5">Deliver to a Person</label>

                        <input type="radio" id="deliver_pickup_location"
                               name="deliver_pickup_location" value="deliver_pickup_location">
                        <label for="deliver_pickup_location" class="mr-5">Deliver to a Pick-up Location</label>

                        <input type="radio" id="deliver_address"
                               name="deliver_address" value="deliver_address">
                        <label for="deliver_address" class="mr-5">Deliver to an Address</label>
                    </li>
                </ul>
            </div>
            <div class="col-4 border-left border-primary d-flex flex-column">
                <h3 class="text-primary mt-4">Step 1/2</h3>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                    </div>
                </div>
                <div class="mt-5 ml-1 p-1">
                    <div class="">
                        <p>&#9642; Please fill information about your package needed to continue.</p>
                        <p>&#9642; Information about delivery address will be asked in the next step.</p>
                        <p>&#9642; Mandatory information about the package are denoted with the * sign.</p>
                    </div>
                </div>
                <form action="" method="post">
                    <div class="">
                        <input type="hidden" id="package_type_1" name="package_type_1" value="null">
                        <input type="hidden" id="weight_1" name="weight_1" value="null">
                        <input type="hidden" id="dimension1_1" name="dimension1_1" value="null">
                        <input type="hidden" id="dimension2_1" name="dimension2_1" value="null">
                        <input type="hidden" id="dimension3_1" name="dimension3_1" value="null">
                        <input type="hidden" id="courier_type_1" name="courier_type_1" value="null">
                        <input type="hidden" id="delivery_time_1" name="delivery_time_1" value="null">
                        <input type="hidden" id="delivery_type_1" name="delivery_type_1" value="null">
                        <button type="submit" class="btn btn-primary mt-auto" onclick="testForPHP();" name="get_info">Continue to next step</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
