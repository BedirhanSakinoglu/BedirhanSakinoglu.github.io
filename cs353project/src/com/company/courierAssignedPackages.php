<?php
session_start();
require_once "config.php";


if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === FALSE){
    header("location: login.php");
} else if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}

$id = $_SESSION['user_id'];

if(isset($_POST['hand_over_btn'])){
    $status_package_ID = $_POST['hand_over_btn'];
    $status_change_query = "UPDATE package SET status='on branch' WHERE package_ID = '$status_package_ID' ";
    mysqli_query($mysqli, $status_change_query);

    $courier_branch_query = "SELECT w.branch_ID as bid FROM works_at w WHERE w.courier_ID = '$id'";
    $result = $mysqli->query($courier_branch_query) or die('Error in query: ' . $mysqli->error);
    $row = $result->fetch_assoc();
    $branch_ID = $row['bid'];

    #assignging to employee
    $query_optimal_employee = "SELECT e1.employee_ID as e FROM employee e1, works w1 WHERE w1.branch_ID = '$branch_ID' AND e1.employee_ID = w1.employee_ID AND w1.employee_ID NOT IN(SELECT a1.employee_ID FROM assign_to_employee a1)";
    $result = $mysqli->query($query_optimal_employee) or die('Error in query: ' . $mysqli->error);

    if($result->num_rows == 0){
        $query_optimal_employee = "SELECT a1.employee_ID as e FROM assign_to_employee a1, works w1 WHERE a1.employee_ID = w1.employee_ID AND w1.branch_ID = '$branch_ID' GROUP BY a1.employee_ID HAVING COUNT(a1.package_ID) <= ALL(SELECT COUNT(a2.package_ID) as package_count FROM assign_to_employee a2, works w2 WHERE a2.employee_ID = w2.employee_ID AND w2.branch_ID = '$branch_ID' GROUP BY a2.employee_ID)";
        $result = $mysqli->query($query_optimal_employee) or die('Error in query: ' . $mysqli->error);
    }

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $employee_ID = $row['e'];
        $query_insert_assign_to_employee = "INSERT INTO assign_to_employee VALUES('$status_package_ID','$employee_ID','waiting')";
        $mysqli->query($query_insert_assign_to_employee) or die('Error in query: ' . $mysqli->error);
    }
    else{
        $query_optimal_employee = "SELECT a1.employee_ID as e FROM works a1 WHERE a1.branch_ID = '$branch_ID' AND a1.employee_ID <= ALL(SELECT a2.employee_ID FROM works a2 WHERE a2.branch_ID = '$branch_ID')";
        $result = $mysqli->query($query_optimal_employee) or die('Error in query: ' . $mysqli->error);
        $row = $result->fetch_assoc();
        $employee_ID = $row['e'];
        $query_insert_assign_to_employee = "INSERT INTO assign_to_employee VALUES ('$status_package_ID','$employee_ID','waiting')";
        $mysqli->query($query_insert_assign_to_employee) or die('Error in query: ' . $mysqli->error);
    }

    $update_is_delivered_query = "UPDATE assigns SET is_delivered= 'received package' WHERE package_ID = '$status_package_ID'";
    mysqli_query($mysqli, $update_is_delivered_query);
}

if(isset($_POST['deliver_customer_btn'])) {
    $status_package_ID = $_POST['deliver_customer_btn'];
    $status_change_query = "UPDATE package SET status='delivered' WHERE package_ID = '$status_package_ID' ";
    mysqli_query($mysqli, $status_change_query);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Courier Assigned Packages</title>
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
            text-align: left;
            background-size: 100% auto !important;
            font-family: 'Google Sans';
            color: #1c4894;
            padding-bottom: 3vh;
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

        .confirm-button {
            color: #fff;

            background: #377095;
            width: 100%;
            height: 5vh;
            outline: none;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s linear;
            letter-spacing: 0.05em;
        }

        #packages {
            border-collapse: collapse;
            width: 100%;
        }

        #packages td, #customers th {
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
            grid-template-columns: 1fr;
            grid-template-rows: 8vh 4vh 4vh 4vh 4vh;
            row-gap: 5vh;
            margin-right: 3vh;
            margin-left: 3vh;
            margin-top: 7vh;
        }

        .grid-item {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.8);
            padding: 20px;
            font-size: 30px;
            text-align: center;
            box-shadow: 0 5px 20px hsla(205, 75%, 36%, 0.31);
        }

        p {
            font-family: 'Google Sans';
            margin-bottom: 5vh;
            font-size: 4vh;
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
            font-size: 5vh;
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
    </style>

</head>
<body>
<div class="banner-container">
    <div class="banner-item left" onclick="location.href='courierDashboard.php';"><h2>ProJet</h2></div>
    <div class="banner-item middle"><button class="banner-button" onclick="location.href='courierDashboard.php';">Home</button> <button class="banner-button" onclick="location.href='courierProfile.php';">My Profile</button></div>
    <div class="banner-item right"><button class="banner-button" onclick="location.href='logout.php';">Logout</button></div>
</div>
<div class="grid-container">
    <h1>Assigned Packages</h1>
    <table id="packages">
        <tr>
            <th>Package ID</th>
            <th>Date Sent</th>
            <th>Pickup Address</th>
            <th>Delivery Address</th>
            <th>Delivery Date</th>
            <th>Package Status</th>
            <th style="background-color: white;"></th>
        </tr>
        <form method="post">
        <?php
        //to get package_id, send_time, delivery_time, status, delivery_address
        $query1 = "SELECT DISTINCT p.package_ID, p.status, p.delivery_address, p.send_time, p.delivery_time
                        FROM package p, assigns a
                        WHERE a.courier_ID = '$id' AND p.package_ID = a.package_ID";

        $packages1 = $mysqli->query($query1) or die('Error in query: ' . $mysqli->error);
        if($packages1->num_rows > 0)
        {
            while($row = $packages1->fetch_assoc())
            {
                if($row['status'] == "order received" or  $row['status'] == "on delivery"){
                    $assigned_package_ID = $row['package_ID'];
                    $pickup_query = "SELECT c.address FROM send_to st, customer c WHERE st.sender_ID = c.customer_ID AND st.package_ID = '$assigned_package_ID'";
                    $pickup = $mysqli->query($pickup_query) or die('Error in query: ' . $mysqli->error);
                    $pickup_address = $pickup->fetch_assoc();

                    $delivery_query = "SELECT b.address FROM works_at wa, branch b WHERE b.branch_ID = wa.branch_ID AND wa.courier_ID = '$id'";
                    $delivery = $mysqli->query($delivery_query) or die('Error in query: ' . $mysqli->error);
                    $delivery_address = $delivery->fetch_assoc();

                    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    //kurye branche götürürken, branche teslim ettim demesi için
                    //eğer kuryeye customer tarafından package verildiyse, onu branche koycam diye buton olcak

                    if($row['status'] == "order received") {
                        echo sprintf("<tr> <td>%s</td> <td>%s</td> <td>%s</td>  <td>%s</td> <td>%s</td> <td>%s</td> <td style='padding: 0px'><button class='confirm-button' type='submit' name='hand_over_btn' value='$assigned_package_ID'>Deliver to Branch</button></td> </tr>",
                            $row['package_ID'], $row['send_time'], $pickup_address['address'], $delivery_address['address'],$row['delivery_time'], $row['status']);
                    }
                    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    //kurye customera götürürken, teslim ettim demesi için
                    //eğer kurye branchten aldı (employee tarafından assign edildi) ve customer a dağıtıma çıktıysa, onu customera verdim diye buton olcak

                    else if($row['status'] == "on delivery") {
                        echo sprintf("<tr> <td>%s</td> <td>%s</td> <td>%s</td>  <td>%s</td> <td>%s</td> <td>%s</td> <td style='padding: 0px'><button class='confirm-button' type='submit' name='deliver_customer_btn' value='$assigned_package_ID'>Deliver to Customer</button></td> </tr>",
                            $row['package_ID'], $row['send_time'], $delivery_address['address'], $row['delivery_address'], $row['delivery_time'], $row['status']);
                    }
                }
    
                else if($row['status'] == "on branch" or $row['status'] == "delivered" or $row['status'] == "received" or $row['status'] == "lost"){
                    $pickup_query = "SELECT b.address FROM works_at wa, branch b WHERE b.branch_ID = wa.branch_ID AND wa.courier_ID = '$id'";
                    $pickup = $mysqli->query($pickup_query) or die('Error in query: ' . $mysqli->error);
                    $pickup_address = $pickup->fetch_assoc();

                    echo sprintf("<tr> <td>%s</td> <td>%s</td> <td>%s</td>  <td>%s</td> <td>%s</td> <td>%s</td> </tr>",
                        $row['package_ID'], $row['send_time'], $pickup_address['address'], $row['delivery_address'],$row['delivery_time'], $row['status']);
                }
            }
        }
        ?>
        </form>
    </table>
</div>

</body>
</html>
