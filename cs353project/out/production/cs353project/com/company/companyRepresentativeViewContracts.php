<?php
session_start();
require_once "config.php";


if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === FALSE){
    header("location: login.php");
} else if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}

$id = $_SESSION['user_id'];

function listContracts($mysqli){
    $id = $_SESSION['user_id'];

    if(isset($_POST['search'])){
        $address = $_POST['searched_address'];
        $query = "SELECT b.branch_ID, b.address, c.is_approved FROM branch b, contract c WHERE b.address LIKE '%$address%' AND b.branch_ID = c.branch_ID AND c.company_ID = '$id'";
    }
    else{
        $query = "SELECT b.branch_ID, b.address, c.is_approved FROM branch b, contract c WHERE b.branch_ID = c.branch_ID AND c.company_ID = '$id'";
    }
    $contracts = $mysqli->query($query) or die('Error in query: ' . $mysqli->error);
    if($contracts->num_rows > 0)
    {
        while($row = $contracts->fetch_assoc()){
            echo sprintf("<tr> <td>%s</td> <td>%s</td> <td>%s</td> </tr>",
                $row['branch_ID'], $row['address'], $row['is_approved']);
        }
    }
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

        .search-button{
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
    </style>

</head>
<body>
<div class="banner-container">
    <div class="banner-item left" onclick="location.href='companyRepresentativeDashboard.php';"><h2>ProJet</h2></div>
    <div class="banner-item middle"><button class="banner-button" onclick="location.href='companyRepresentativeDashboard.php';">Home</button> <button class="banner-button" onclick="location.href='companyRepresentativeProfile.php';">My Profile</button></div>
    <div class="banner-item right"><button class="banner-button" onclick="location.href='logout.php';">Logout</button></div>
</div>
<div class="grid-container">
    <h1>View Contracts</h1>
    <p style="font-size: 25px">Search by address of the branch.</p>
    <form method="post">
    <input type="text" id="dimension1"
           name="searched_address" placeholder ="Enter Address" class="m-3" style="width: 25vh">
    <button type="submit" class="search-button" name="search">Search</button>
    <div style=" margin-top:3vh; width:100%; max-height: 75vh; overflow-y: scroll;">
        <table id="packages">
            <tr>
                <th>Branch ID</th>
                <th>Branch Address</th>
                <th>Contract Status</th>
            </tr>
                <?php
                listContracts($mysqli);
                ?>

        </table>
    </div>
    </form>
</div>

</body>
</html>
