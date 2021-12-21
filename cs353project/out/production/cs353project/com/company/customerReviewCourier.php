<?php
session_start();
require_once "config.php";


if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === FALSE){
    header("location: login.php");
} else if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}

$id = $_SESSION['user_id'];
if (isset($_POST['submit_review'])){
    $description = "";
    if (isset($_POST['submit_review'])){
        $description = $_POST['review_description'];
    }
    $rating = $_POST['rating'];

    $json_post = $_POST['COURIER'];
    $json_post_obj = json_decode($json_post, true);
    $courier_ID = $json_post_obj['courier_ID'];
    $package_ID = $json_post_obj['package_ID'];

    $query_insert_review = ("INSERT INTO courier_review(courier_ID,text,rate) VALUES('$courier_ID', '$description', '$rating') ");
    mysqli_query($mysqli, $query_insert_review) or die('Error in query: ' . $mysqli->error);

    $query_insert_review = ("INSERT INTO evaluate(customer_ID, courier_ID, package_ID) VALUES('$id', '$courier_ID', '$package_ID') ");
    mysqli_query($mysqli, $query_insert_review) or die('Error in query: ' . $mysqli->error);



    echo "<script>
            if(confirm('Review Created ' + ' $courier_ID ' + ' $package_ID ' + ' $json_post ' )){document.location.href='customerDashboard.php'};
            </script>";
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Report Pacakge</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker (unregistered version)">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>

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
        button{
            font-size: 15.4px;
        }

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
                                <th >Date Sent</th>
                                <th >Status</th>
                                <th >Courier ID</th>
                            </table>
                            <div style="height:60vh; overflow-y: scroll;">
                                <table id="packages">
                                    <?php
                                    $query = "SELECT *
                                        FROM package p, send_to st, assigns a
                                        WHERE st.taker_ID = '$id' AND p.package_ID = st.package_ID AND a.package_ID = p.package_ID AND p.status = 'delivered' AND p.package_ID NOT IN (SELECT package_ID FROM evaluate)";
                                    $packages = $mysqli->query($query) or die('Error in query: ' . $mysqli->error);
                                    if($packages->num_rows > 0)
                                    {
                                        while($row = $packages->fetch_assoc()){
                                            $package_ID = $row['package_ID'];
                                            $courier_ID = $row['courier_ID'];

                                            $json_obj = array("package_ID"=>$package_ID, "courier_ID"=>$courier_ID);
                                            $json = json_encode($json_obj);

                                            echo sprintf("<tr><td style='width:4vh; text-align: center'><input type='radio' id='$courier_ID' name='COURIER' value='$json' required></td><td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td>
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

                    <li class="list-group-item mt-4 mr-5 border border-secondary">
                        <h3 class="panel-header">Rate Your Experience with the Courier*</h3>
                        <input id="ratinginput" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5" value="2">


                    </li>
                    <li class="list-group-item mt-4 mr-5 border border-secondary">
                        <h3 class="panel-header">Please Enter Your Review</h3>
                        <textarea id="report_description" name="review_description" rows="4" cols="50"></textarea>
                    </li>
                </div>
                <form class="mr-2" style="text-align: right" action="" method="post">
                    <button type="submit" class="report-button mt-4" name="submit_review">Submit Review</button>
                </form>

            </div>
    </form>
</div>
</div>
</body>
</html>

