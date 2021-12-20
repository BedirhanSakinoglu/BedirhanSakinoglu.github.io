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
    echo "<script>if(confirm('Report Sent! We will reach you soon!')){document.location.href='customerDashboard.php'};</script>";
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
            font-size: 60px;
            text-align: center;
            background-size: 100% auto !important;
            font-family: 'Google Sans';
            color: rgb(23, 103, 161);

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

        form{
            all: unset;
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
    <div class="banner-item left"><h2>ProJet</h2></div>
    <div class="banner-item middle"><button class="banner-button" onclick="location.href='customerDashboard.php';">Home</button> <button class="banner-button" onclick="location.href='customerProfile.php';">My Profile</button></div>
    <div class="banner-item right"><button class="banner-button" onclick="location.href='logout.php';">Logout</button></div>
</div>
<div>
    <div class="row">
        <h1>Report Package</h1>
        <div class="col-8">
            <ul class="list-group list-group-flush ml-2">
                <li class="list-group-item mt-4 border border-secondary">
                    <h3 class="text-primary">Select the ID of the package which will be reported*</h3>
                    <table id="packages">
                        <tr>
                            <th>Package ID</th>
                        </tr>
                        <form method="post">
                            <?php
                            $query = "SELECT p.package_ID
                                        FROM package p, send_to st
                                        WHERE st.taker_ID = '$id' AND p.package_ID = st.package_ID";
                            $packages = $mysqli->query($query) or die('Error in query: ' . $mysqli->error);
                            if($packages->num_rows > 0)
                            {
                                while($row = $packages->fetch_assoc()){
                                    $package_id = $row['package_ID'];
                                    echo sprintf("<tr> <td>%s</td> 
                                </tr>", $row['package_ID']);
                                }
                            }
                            ?>
                        </form>
                    </table>

                </li>
                <li class="list-group-item mt-4 border border-secondary">
                    <h3 class="text-primary">Select the problem about your package*</h3>
                    <input type="radio" id="malformed"
                           name="package_problem" value="malformed" required>
                    <label for="malformed" class="mr-5">Package is Malformed</label>

                    <input type="radio" id="lost"
                           name="package_problem" value="lost">
                    <label for="lost" class="mr-5">Package is Lost</label>
                </li>
                <li class="list-group-item mt-4 border border-secondary">
                    <h3 class="text-primary">Please describe your problem.*</h3>
                    <input type="text" id="description"
                           name="description" value="description" class="mr-4" required>
                </li>

            </ul>
        </div>
        <div class="col-4 border-left border-primary d-flex flex-column">
            <div class="mt-5 ml-1 p-1">
                <div class="">
                    <p>&#9642; Please fill information about your package report needed to continue.</p>
                    <p>&#9642; Mandatory information about your report are denoted with the * sign.</p>
                    <p>&#9642; Please write your description as explanatory as possible.</p>
                    <p>&#9642; Your report will be investigated and you will be contacted soon.</p>

                </div>
            </div>
            <form action="" method="post">
                <button type="submit" class="btn btn-primary mt-auto " name='send_report'>Send Report</button>
            </form>

        </div>

    </div>
</div>

</body>
</html>
