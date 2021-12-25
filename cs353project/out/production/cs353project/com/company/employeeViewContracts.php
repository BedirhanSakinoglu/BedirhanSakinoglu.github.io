<?php
session_start();
require_once "config.php";


if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === FALSE){
    header("location: login.php");
} else if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}

$id = $_SESSION['user_id'];

if(isset($_POST['accept'])){
    $query = "SELECT branch_ID FROM works WHERE employee_ID = '$id'";
    $branch = $mysqli->query($query) or die('Error in query: ' . $mysqli->error);
    $branch_ID_arr = $branch->fetch_assoc();
    $branch_ID = $branch_ID_arr['branch_ID'];

    $accept_query = ("UPDATE contract SET status='accepted' WHERE branch_ID = '$branch_ID' AND company_ID = '$id' ");
    mysqli_query($mysqli, $accept_query);
}
if(isset($_POST['reject'])){
    $query = "SELECT branch_ID FROM works WHERE employee_ID = '$id'";
    $branch = $mysqli->query($query) or die('Error in query: ' . $mysqli->error);
    $branch_ID_arr = $branch->fetch_assoc();
    $branch_ID = $branch_ID_arr['branch_ID'];

    $reject_query = ("UPDATE contract SET status='rejected' WHERE branch_ID = '$branch_ID' AND company_ID = '$id' ");
    mysqli_query($mysqli, $reject_query);
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>View Contracts</title>
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

        .confirm-button-n {
            color: #ffffff;

            background: #D11B1B;
            width: 80%;
            height: 80%;
            outline: none;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s linear;
            letter-spacing: 0.05em;
        }
        .confirm-button-p {
            color: #ffffff;

            background: #1EA204;
            width: 80%;
            height: 80%;
            outline: none;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s linear;
            letter-spacing: 0.05em;
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
            font-size: 2vh;
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
            font-size: 3vh;
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
    <div class="banner-item left" onclick="location.href='employeeDashboard.php';"><h2>ProJet</h2></div>
    <div class="banner-item middle"><button class="banner-button" onclick="location.href='employeeDashboard.php';">Home</button> <button class="banner-button" onclick="location.href='employeeProfile.php';">My Profile</button></div>
    <div class="banner-item right"><button class="banner-button" onclick="location.href='logout.php';">Logout</button></div>
</div>
<div class="grid-container">
    <h1>All Contract Requests</h1>
    <div style=" margin-top:3vh; width:100%; max-height: 75vh; overflow-y: scroll;">
        <table id="packages">
            <tr>
                <th>Company Name</th>
                <th>Status</th>
                <th style="background-color: white;"></th>
            </tr>
            <form method="post">

                <?php
                $query = "SELECT * FROM branch b, works w, contract c, company_representative cp WHERE w.branch_ID = b.branch_ID AND w.employee_ID = '$id' AND c.branch_ID = b.branch_ID, c.company_ID = cp.company_ID";
                $contract_reqs = $mysqli->query($query) or die('Error in query: ' . $mysqli->error);
                if($contract_reqs->num_rows > 0)
                {
                    while($row = $contract_reqs->fetch_assoc()){
                        $comp_id = $row['company_ID'];

                        if($row['status'] == "waiting"){
                            echo sprintf("<tr> <td>%s</td> <td>%s</td>
                                    <td style='text-align: center; border-width: 0px; padding: 0px'><button class='confirm-button-p' type='submit' name='accept' value='$comp_id'>Accept</button></td><td style='text-align: center; border-width: 0px; padding: 0px'><button class='confirm-button-n' type='submit' name='reject' value='$comp_id'>Reject</button></td> </tr>", $row['company_name'], $row['status']);
                        }
                        else{
                            echo sprintf("<tr> <td>%s</td> <td>%s</td>
                                    </tr>", $row['company_name'], $row['status']);
                        }
                    }
                }
                ?>
            </form>
        </table>
    </div>
</div>

</body>
</html>
