<?php
session_start();
require_once "config.php";
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === FALSE){
    header("location: login.php");
} else if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}

$id = $_SESSION['user_id'];

function send_package($mysqli) {

    //Local variables
    $id = $_SESSION['user_id'];
    $package_type = $_SESSION['package_type'];
    $weight = $_SESSION['weight'];
    $dimension1 = $_SESSION['dimension1'];
    $dimension2 = $_SESSION['dimension2'];
    $dimension3 = $_SESSION['dimension3'];
    $dimension_total = $dimension1.'x'.$dimension2.'x'.$dimension3;
    $courier_type = $_SESSION['courier_type'];
    $delivery_type = $_SESSION['delivery_type'];
    $send_time = date('Y/m/d');
    $delivery_time = $_SESSION['delivery_time'];

    $customer_ID = $_POST['customer_person'];
    $branch_ID = $_POST['branch_ID'];
    $customer_address = $_POST['address_description'];

    //insert into package and submit_pack and send_to relation
    $query_insert_package = "INSERT INTO package(weight, dimension, delivery_address, status, send_time, delivery_time, package_type, courier_type) 
                                VALUES ('$weight','$dimension_total','$customer_address','order received','$send_time','$delivery_time','$package_type','$courier_type')";
    $mysqli->query($query_insert_package) or die('Error in query: ' . $mysqli->error);

    $query_insert_submit_pack = "INSERT INTO submit_pack VALUES(LAST_INSERT_ID(), '$branch_ID')";
    $mysqli->query($query_insert_submit_pack) or die('Error in query: ' . $mysqli->error);

    $query_insert_send_to = "INSERT INTO send_to VALUES('$id','$customer_ID',LAST_INSERT_ID())";
    $mysqli->query($query_insert_send_to) or die('Error in query: ' . $mysqli->error);

    #assignging to courier -----------------
    $query_optimal_courier = "SELECT e1.courier_ID as e FROM courier e1, works_at w1 WHERE e1.courier_type = '$courier_type' AND w1.branch_ID = '$branch_ID' AND e1.courier_ID = w1.courier_ID AND w1.courier_ID NOT IN(SELECT a1.courier_ID FROM assigns a1)";
    $result = $mysqli->query($query_optimal_courier) or die('Error in query: ' . $mysqli->error);

    if($result->num_rows == 0){
        $query_optimal_courier = "SELECT a1.courier_ID as e FROM courier c, assigns a1, works_at w1 WHERE c.courier_type = '$courier_type' AND c.courier_ID = a1.courier_ID AND a1.courier_ID = w1.courier_ID AND w1.branch_ID = '$branch_ID' GROUP BY a1.courier_ID HAVING COUNT(a1.package_ID) <= ALL(SELECT COUNT(a2.package_ID) as package_count FROM assigns a2, works_at w2 WHERE a2.courier_ID = w2.courier_ID AND w2.branch_ID = '$branch_ID' GROUP BY a2.courier_ID)";
        $result = $mysqli->query($query_optimal_courier) or die('Error in query: ' . $mysqli->error);
    }

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $courier_ID = $row['e'];
        $query_insert_assign_to_courier = "INSERT INTO assigns(package_ID, courier_ID, is_delivered) VALUES(LAST_INSERT_ID(),'$courier_ID','waiting')";
        $mysqli->query($query_insert_assign_to_courier) or die('Error in query: ' . $mysqli->error);
    }
    else{
        $query_optimal_courier = "SELECT a1.courier_ID as e FROM courier c, works_at a1 WHERE c.courier_type = '$courier_type' AND c.courier_ID = a1.courier_ID AND a1.branch_ID = '$branch_ID' AND a1.courier_ID <= ALL(SELECT a2.courier_ID FROM works_at a2 WHERE a2.branch_ID = '$branch_ID')";
        $result = $mysqli->query($query_optimal_courier) or die('Error in query: ' . $mysqli->error);
        $row = $result->fetch_assoc();
        $courier_ID = $row['e'];
        $query_insert_assign_to_courier = "INSERT INTO assigns(package_ID, courier_ID, is_delivered) VALUES(package_ID, courier_ID, is_delivered)  (LAST_INSERT_ID(),'$courier_ID','waiting')";
        $mysqli->query($query_insert_assign_to_courier) or die('Error in query: ' . $mysqli->error);
    }
    #-----------------------------------

    echo "<script>
            if(confirm('Package Created' )){document.location.href='customerDashboard.php'};
            </script>";

}

if(isset($_POST['send_package'])) {
    send_package($mysqli);
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Customer Call Courier</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker (unregistered version)">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

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

        .grid-container{
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 1vh;
            row-gap: 3vh;
            margin-right: 3vh;
            margin-left: 3vh;
            margin-top: 3vh;
        }

        .grid-item {
            padding: 2vh;
            font-size: 30px;
            text-align: left;
            border:1px solid #959595;
        }

        .item1{
            grid-row: 1;
            grid-column: 1 / 3;
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

        li{
            display:inline-block !important;
            width: 50vh;
        }

        #person-table{
            width: 100%;
        }

        #branch-table{
            width: 100%;
        }

        #person-table td, #person-table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #person-table tr:nth-child(even){background-color: #f2f2f2;}

        #person-table tr:hover {background-color: #ddd;}

        #person-table th {
            padding-top: 12px;
            padding-bottom: 12px;
            padding-left: 8px;
            text-align: left;
            background-color: #3aafff;
            color: white;
        }

        #branch-table td, #branch-table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #branch-table tr:nth-child(even){background-color: #f2f2f2;}

        #branch-table tr:hover {background-color: #ddd;}

        #branch-table th {
            padding-top: 12px;
            padding-bottom: 12px;
            padding-left: 8px;
            text-align: left;
            background-color: #3aafff;
            color: white;
        }

        .row{
            flex-wrap: unset;
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
            <div class="col-7 grid-container" >
                <div class="grid-item item1 " >
                    <h3 class="panel-header">Enter a delivery address*</h3>
                    <div>
                        <textarea id="address-description" name="address_description" rows="4" cols="80" style="margin-top:2vh;resize:none" required></textarea>
                    </div>
                </div>
                <div class="grid-item" >
                    <h3 class="panel-header">Select a Person From the List*</h3>
                    <div style=" margin-top:3vh; width:100%; max-height: 40vh; overflow-y: scroll;">
                        <table id="person-table">
                            <?php
                            $customer_query = "SELECT * FROM customer c, user u WHERE c.customer_ID = u.user_ID AND u.user_ID != '$id'";
                            $all_customers = $mysqli->query($customer_query) or die('Error in query: ' . $mysqli->error);
                            if($all_customers->num_rows > 0) {
                                while ($row = $all_customers->fetch_assoc()) {
                                    $customer_ID = $row['customer_ID'];
                                    $customer_address = $row['address'];
                                    $customer_name = $row['username'];
                                    echo sprintf("<tr> <td style='width:4vh; text-align: center'><input type='radio' name='customer_person' value='$customer_ID' required></td>
                                        <td>%s</td> </tr>", $customer_name);
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="grid-item">
                    <h3 class="panel-header">Select a Branch From the List*</h3>
                    <div style=" margin-top:3vh; width:100%; max-height: 40vh; overflow-y: scroll;">
                        <table id="branch-table">
                            <?php
                            $branch_query = "SELECT * FROM branch";
                            $all_branches = $mysqli->query($branch_query) or die('Error in query: ' . $mysqli->error);
                            if($all_branches->num_rows > 0) {
                                while ($row = $all_branches->fetch_assoc()) {
                                    $branch_ID_radio = $row['branch_ID'];
                                    echo sprintf("<tr> <td style='width:4vh; text-align: center'><input type='radio' name='branch_ID' value='$branch_ID_radio' required></td>
                                        <td>%s</td> </tr>", $row['address']);
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4 border-left mt-4 border-secondary d-flex flex-column">
                <div class="ml-2">
                    <h3 class="panel-header">Step 2/2</h3>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        </div>
                    </div>
                </div>
                <div class="ml-2">
                    <div class="">
                        <p>&#9642; Enter the address you want to send package.</p>
                        <p>&#9642; Please select a user from the list you want to send package to</p>
                        <p>&#9642; Please select a branch that you want to send your package by</p>
                        <p>&#9642; After selecting all, click on "Send Package" button to complete process</p>
                    </div>
                    <button type="submit" class="report-button mt-5" name="send_package">Send Package</button>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>


