<?php
session_start();
require_once "config.php";

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === FALSE){
    header("location: login.php");
} else if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}

$id = $_SESSION['user_id'];
if (isset($_POST['assign_package'])){
    $package_ID = $_POST['package_ID'];
    $courier_ID = $_POST['courier_ID'];

    $query_assign_package = "INSERT INTO assigns(package_ID, courier_ID, is_delivered) VALUES ('$package_ID', '$courier_ID', 'received package')";
    $mysqli->query($query_assign_package) or die('Error in query: ' . $mysqli->error);

    $query_update_package = "UPDATE package SET status = 'on delivery' WHERE package_ID = '$package_ID'"; //burası kurye hemen alınca on delivery mi olcak order received olmaz mı
    $mysqli->query($query_update_package) or die('Error in query: ' . $mysqli->error);

    echo "<script>
            if(confirm('Package Assigned' )){document.location.href='employeeDashboard.php'};
            </script>";
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Customer Dashboard</title>
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

        .grid-container{
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 1vh;
            row-gap: 1vh;
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

        #package-table{
            width: 100%;
        }

        #courier-table{
            width: 100%;
        }

        #package-table td, #package-table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #package-table tr:nth-child(even){background-color: #f2f2f2;}

        #package-table tr:hover {background-color: #ddd;}

        #package-table th {
            padding-top: 12px;
            padding-bottom: 12px;
            padding-left: 8px;
            text-align: left;
            background-color: #3aafff;
            color: white;
        }

        #courier-table td, #courier-table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #courier-table tr:nth-child(even){background-color: #f2f2f2;}

        #courier-table tr:hover {background-color: #ddd;}

        #courier-table th {
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
    <div class="banner-item left" onclick="location.href='employeeDashboard.php';"><h2>ProJet</h2></div>
    <div class="banner-item middle"><button class="banner-button" onclick="location.href='employeeDashboard.php';">Home</button> <button class="banner-button" onclick="location.href='employeeProfile.php';">My Profile</button></div>
    <div class="banner-item right"><button class="banner-button" onclick="location.href='logout.php';">Logout</button></div>
</div>
<div>
    <form action="" method="post">
        <div class="row">
            <div class="col-8 grid-container" >
                <div class="grid-item" >
                    <h3 class="panel-header">Select a Package*</h3>
                    <div style=" margin-top:3vh; width:100%; max-height: 75vh; overflow-y: scroll;">
                        <table id="package-table">
                            <?php
                            $package_query = "SELECT * FROM assign_to_employee a, package p WHERE a.employee_ID = '$id' AND a.package_ID = p.package_ID AND p.status = 'on branch'";
                            $all_packages = $mysqli->query($package_query) or die('Error in query: ' . $mysqli->error);
                            if($all_packages->num_rows > 0) {
                                while ($row = $all_packages->fetch_assoc()) {
                                    $package_ID = $row['package_ID'];
                                    $delivery_time = $row['delivery_time'];
                                    $delivery_address = $row['delivery_address'];
                                    $selected_courier_type = $row['courier_type'];
                                    echo sprintf("<tr> <td style='width:4vh; text-align: center'><input type='radio' name='package_ID' value='$package_ID' required></td>
                                            <td>%s</td>  <td>%s</td>  <td>%s</td> <td>%s</td> </tr>", $package_ID, $delivery_time, $delivery_address, $selected_courier_type);
                                }
                            }
                            else{
                                echo "<script>
                                            alert('You do not have any package to assign. Redirecting...');
                                            document.location.href='employeeDashboard.php';
                                         </script>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="grid-item">
                    <h3 class="panel-header">Select a Courier*</h3>
                    <div style=" margin-top:3vh; width:100%; max-height: 75vh; overflow-y: scroll;">
                        <table id="courier-table">
                            <?php
                            $courier_query = "SELECT c.courier_ID as cid, u.username as cname, c.courier_type as ctype FROM courier c, user u, works_at wa, works w WHERE u.user_ID = c.courier_ID AND wa.courier_ID = c.courier_ID AND w.employee_ID = '$id' AND wa.branch_ID = w.branch_ID";
                            $all_couriers = $mysqli->query($courier_query) or die('Error in query: ' . $mysqli->error);
                            if($all_couriers->num_rows > 0) {
                                while ($row = $all_couriers->fetch_assoc()) {
                                    $courier_ID_radio = $row['cid'];
                                    echo sprintf("<tr> <td style='width:4vh; text-align: center'><input type='radio' name='courier_ID' value='$courier_ID_radio' required></td>
                                        <td>%s</td> <td>%s</td> <td>%s</td> </tr>", $row['cid'], $row['cname'], $row['ctype']);
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-3 border-left mt-4 border-secondary d-flex flex-column">
                <div class="ml-2">
                    <div class="">
                        <p>&#9642; Please select a package from the package list you want to assign.</p>
                        <p>&#9642; Please select a courier from the list.</p>
                        <p>&#9642; After selecting both, click on "Assign Package" button to complete process.</p>
                    </div>.
                    <button type="submit" class="report-button mt-5" name="assign_package">Assign Package</button>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>


