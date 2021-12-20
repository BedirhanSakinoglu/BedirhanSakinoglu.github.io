<?php
session_start();
require_once "config.php";


if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === FALSE){
    header("location: login.php");
} else if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}

$id = $_SESSION['user_id'];
if (isset($_POST['send_report'])){
    $package_id = $_POST['PACKAGE'];
    $package_problem = $_POST['package_problem'];
    $description = $_POST['report_description'];

    $query_insert_report = ("INSERT INTO report(customer_ID,content,report_type,is_accepted) VALUES('$id', '$description', '$package_problem', 'FALSE') ");
    mysqli_query($mysqli, $query_insert_report) or die('Error in query: ' . $mysqli->error);

    $query_insert_has_relation = ("INSERT INTO has(package_ID,report_ID) VALUES('$package_id', LAST_INSERT_ID()) ");
    mysqli_query($mysqli, $query_insert_has_relation) or die('Error in query: ' . $mysqli->error);
    echo "<script>
            if(confirm('Report Created' )){document.location.href='customerDashboard.php'};
            </script>";
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Report Pacakge</title>
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
            margin-bottom: 5vh;
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
    <form method="post">
        <div class="row">
            <div class="col-7">
                <h2 style="margin-left: 1.5vh; margin-bottom: 0px; margin-top: 1vh; color:#1767a1; font-size: 4vh">Review Courier</h2>
                <ul class="list-group list-group-flush ml-3">
                    <li class="list-group-item mt-4 mr-5 border border-secondary">
                        <h3 class="panel-header">All of your packages and corresponding couriers are below:</h3>
                        <table>
                            <table style="width: 98.3%" id="packages">
                                <th style="width:4vh;"></th>
                                <th>Package ID</th>
                                <th>Date Sent</th>
                                <th>Status</th>
                                <th>Courier ID</th>
                            </table>
                            <div style="height:30vh; overflow-y: scroll;">
                                <table id="packages">
                                    <?php
                                    $query = "SELECT *
                                        FROM package p, send_to st, assigns a
                                        WHERE (st.taker_ID = '$id' OR st.sender_ID = '$id') AND p.package_ID = st.package_ID AND a.package_ID = p.package_ID AND p.status = 'delivered'";
                                    $packages = $mysqli->query($query) or die('Error in query: ' . $mysqli->error);
                                    if($packages->num_rows > 0)
                                    {
                                        while($row = $packages->fetch_assoc()){
                                            $package_id = $row['package_ID'];
                                            echo sprintf("<tr><td style='width:4vh; text-align: center'><input type='radio' id='$package_id' name='PACKAGE' value='$package_id' required></td><td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td>
                                </tr>", $row['package_ID'], $row['send_time'], $row['status'], $row['courier_ID']);
                                        }
                                    }
                                    ?>

                                </table>
                            </div>
                        </table>
                    </li>

                </ul>
            </div>
            <div class="col-5 border-left mt-5 border-secondary d-flex flex-column">
                <div class="ml-5">
                    <div class="">
                        <p>&#9642; Please fill information about your report needed to continue.</p>
                        <p>&#9642; Mandatory information about your report are denoted with the * sign.</p>
                        <p>&#9642; Please write your description as explanatory as possible.</p>
                        <p>&#9642; Your report will be investigated and you will be contacted soon.</p>
                    </div>
                </div>
                <form class="mr-2" style="text-align: right" action="" method="post">
                    <button type="submit" class="report-button mt-4" name="send_report">Send Report</button>
                </form>

            </div>
    </form>
</div>
</div>
</body>
</html>

