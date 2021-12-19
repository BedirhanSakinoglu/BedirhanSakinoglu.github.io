<?php
session_start();
require_once "config.php";
$msg = '';


function logIn($mysqli)
{
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $query = "SELECT * FROM user WHERE username='$user' AND password='$pass'";
    $result = $mysqli->query($query) or die('Error in query: ' . $mysqli->error);
    $userType = "none";
    if($result){
        if($result->num_rows==1) {
            if (isset($_POST['usertype'])){
                $userType = $_POST['usertype'];
            }
            $_SESSION['username'] = $user;
            $_SESSION['password'] = $pass;
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = -1;
            if($userType == "customer"){
                $query_cust = "SELECT * FROM user u, customer c WHERE u.username='$user' AND c.customer_ID = u.user_ID";
                $result_cust = $mysqli->query($query_cust) or die('Error in query: ' . $mysqli->error);
                if($result_cust->num_rows==1) {
                    header("location: customerDashboard.php");
                    //lets find the user id belonging to this username
                    $query_find_cust_id = "SELECT customer_ID FROM user u, customer c WHERE u.username = '$user' AND c.customer_ID = u.user_ID";
                    $result_find_cust_id = $mysqli->query($query_find_cust_id) or die('Error in query: ' . $mysqli->error);
                    if($result_find_cust_id->num_rows==1){
                        $row=$result_find_cust_id->fetch_assoc();
                        $id = (int) $row['customer_ID'];
                        $_SESSION['user_id'] = $id;
                    }
                }
                else{
                    echo '<script type="text/javascript">
                        alert("Incorrect Usertype");
                        </script>';
                }
            }
            else if($userType == "employee"){
                $query_emp = "SELECT * FROM user u, employee e WHERE u.username='$user' AND e.employee_ID = u.user_ID";
                $result_emp = $mysqli->query($query_emp) or die('Error in query: ' . $mysqli->error);
                if($result_emp->num_rows==1) {
                    header("location: employeeDashboard.php");
                    //lets find the user id belonging to this username
                    $query_find_emp_id = "SELECT employee_ID FROM user u, employee e WHERE u.username = '$user' AND e.employee_ID = u.user_ID";
                    $result_find_emp_id = $mysqli->query($query_find_emp_id) or die('Error in query: ' . $mysqli->error);
                    if($result_find_emp_id->num_rows==1){
                        $row=$result_find_emp_id->fetch_assoc();
                        $id = (int) $row['employee_ID'];
                        $_SESSION['user_id'] = $id;
                    }
                }
                else{
                    echo '<script type="text/javascript">
                        alert("Incorrect Usertype");
                        </script>';
                }
            }
            else if($userType == "companyrepresentative"){
                $query_comp = "SELECT * FROM user u, company_representative cr WHERE u.username='$user' AND cr.company_ID = u.user_ID";
                $result_comp = $mysqli->query($query_comp) or die('Error in query: ' . $mysqli->error);
                if($result_comp->num_rows==1) {
                    header("location: companyRepresentativeDashboard.php");
                    //lets find the user id belonging to this username
                    $query_find_comp_rep_id = "SELECT employee_ID FROM user u, company_representative c WHERE u.username = '$user' AND c.company_ID = u.user_ID";
                    $result_find_comp_rep_id = $mysqli->query($query_find_comp_rep_id) or die('Error in query: ' . $mysqli->error);
                    if($result_find_comp_rep_id->num_rows==1){
                        $row=$result_find_comp_rep_id->fetch_assoc();
                        $id = (int) $row['company_ID'];
                        $_SESSION['user_id'] = $id;
                    }
                }
                else{
                    echo '<script type="text/javascript">
                        alert("Incorrect Usertype");
                        </script>';
                }
            }
            else if($userType == "courier"){
                $query_cour = "SELECT * FROM user u, courier c WHERE u.username='$user' AND c.courier_ID = u.user_ID";
                $result_cour = $mysqli->query($query_cour) or die('Error in query: ' . $mysqli->error);
                if($result_cour->num_rows==1) {
                    header("location: courierDashboard.php");
                    //lets find the user id belonging to this username
                    $query_find_cor_id = "SELECT courier_ID FROM user u, courier c WHERE u.username = '$user' AND c.courier_ID = u.user_ID";
                    $result_find_cor_id = $mysqli->query($query_find_cor_id) or die('Error in query: ' . $mysqli->error);
                    if($result_find_cor_id->num_rows==1){
                        $row=$result_find_cor_id->fetch_assoc();
                        $id = (int) $row['company_ID'];
                        $_SESSION['user_id'] = $id;
                    }
                }
                else{
                    echo '<script type="text/javascript">
                        alert("Incorrect Usertype");
                        </script>';
                }


            }
        }
    }
    else{
        echo '<script type="text/javascript">
            alert("Incorrect Username or Password");
            </script>';
    }
}

function register_customer($mysqli){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $sql="INSERT INTO user (username, email, password, phone) 
                            VALUES ('$username', '$email', '$password', '$phone')";
    $mysqli->query($sql) or die('Error in query: ' . $mysqli->error);;
    //mysqli_query($mysqli,$sql);
    $id = mysqli_insert_id($mysqli);
    $sql2="INSERT INTO customer (customer_ID, address) VALUES ($id, '$address')";
    //mysqli_query($mysqli,$sql2);
    $mysqli->query($sql2) or die('Error in query: ' . $mysqli->error);
    header("location: customerDashboard.php");
    $_SESSION['user_id'] = $id;
}

function register_courier($mysqli){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $salary = $_POST['salary'];
    $price = $_POST['price'];
    $couriertype = $_POST['couriertype'];

    $sql="INSERT INTO user (username, email, password, phone) 
                            VALUES ('$username', '$email', '$password', '$phone')";
    $mysqli->query($sql) or die('Error in query: ' . $mysqli->error);;
    //mysqli_query($mysqli,$sql);
    $id = mysqli_insert_id($mysqli);
    $sql2="INSERT INTO courier (courier_ID, salary, price, courier_type) VALUES ($id, '$salary', '$price', '$couriertype')";
    //mysqli_query($mysqli,$sql2);
    $mysqli->query($sql2) or die('Error in query: ' . $mysqli->error);;
    header("location: courierDashboard.php");
    $_SESSION['user_id'] = $id;
}

function register_employee($mysqli){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $salary = $_POST['salary'];
    $sql="INSERT INTO user (username, email, password, phone) 
                            VALUES ('$username', '$email', '$password', '$phone')";
    $mysqli->query($sql) or die('Error in query: ' . $mysqli->error);;
    $id = mysqli_insert_id($mysqli);
    $sql2="INSERT INTO employee (employee_ID, salary) VALUES ($id, '$salary')";
    $mysqli->query($sql2) or die('Error in query: ' . $mysqli->error);;
    header("location: employeeDashboard.php");
    $_SESSION['user_id'] = $id;
}

function register_companyrepresentative($mysqli){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $company_name = $_POST['companyname'];
    $sql="INSERT INTO user (username, email, password, phone) 
                            VALUES ('$username', '$email', '$password', '$phone')";
    $mysqli->query($sql) or die('Error in query: ' . $mysqli->error);;
    $id = mysqli_insert_id($mysqli);
    $sql2="INSERT INTO company_representative(company_ID, company_name) VALUES ($id, '$company_name')";
    $mysqli->query($sql2) or die('Error in query: ' . $mysqli->error);;
    header("location: companyRepresentativeDashboard.php");
    $_SESSION['user_id'] = $id;
}

if (isset($_POST['login'])){
    logIn($mysqli);
}

if (isset($_POST['register_customer'])){
    register_customer($mysqli);
}

if (isset($_POST['register_courier'])){
    register_courier($mysqli);
}

if (isset($_POST['register_employee'])){
    register_employee($mysqli);
}

if (isset($_POST['register_companyrepresentative'])){
    register_companyrepresentative($mysqli);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Projet</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker (unregistered version)">
    <script type="text/javascript" src="login.js"></script>
    <style>
        /* Fonts Form Google Font ::- https://fonts.google.com/  -:: */
        @import url('https://fonts.googleapis.com/css?family=Abel|Abril+Fatface|Alegreya|Arima+Madurai|Dancing+Script|Dosis|Merriweather|Oleo+Script|Overlock|PT+Serif|Pacifico|Playball|Playfair+Display|Share|Unica+One|Vibur');
        @import url('https://fonts.googleapis.com/css?family=Google+Sans:100,300,400,500,700,900,100i,300i,400i,500i,700i,900i');
        /* End Fonts */
        /* Start Global rules */
        * {
            padding: 0;
            margin: 0;

        }
        /* End Global rules */

        h1 {
            font-size: 75px;
            text-align: center;
            background-size: 100% auto !important;
            font-family: 'Google Sans';
            color: #3e403f;
            margin-top: 3vh;
            margin-bottom: 10vh;
        }
        /* Start body rules */
        body {
            background-image: linear-gradient(-225deg, #A0DEFF 0%, #EFF9FF 100%);
            background-image: linear-gradient(to top, #c7edff 0%,#EFF9FF 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;

            font-family: 'Vibur', cursive;
            /*   the main font */
            font-family: 'Abel', sans-serif;
            opacity: .95;
            margin-right: 3vh;
            /* background-image: linear-gradient(to top, #d9afd9 0%, #97d9e1 100%); */
        }

        .split{
            height: 100%;
            position: fixed;
            z-index: 1;
            margin-top: 2vh;
            margin-right: 2vh;
        }

        .left {
            left: 0;
        }

        /* Control the right side */
        .right {
            right: 0;
            margin-right: 2vh;
        }

        /* End body rules */

        /* Start form  attributes */
        form {
            width: 45vh;
            min-height: 500px;
            height: 93vh;
            border-radius: 5px;
            box-shadow: 0 9px 50px hsla(20, 67%, 75%, 0.31);
            padding: 2%;
            background-image: linear-gradient(-225deg, #B9E4FC 50%, #EFF9FF 50%);
            float: right;

        }
        /* form Container */
        form .con {
            display: -webkit-flex;
            display: flex;

            -webkit-justify-content: space-around;
            justify-content: space-around;

            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;

            margin: 0 auto;
        }

        /* the header form form */
        header {
            margin: 2% auto 10% auto;
            text-align: center;
        }
        /* Login title form form */
        header h2 {
            font-size: 60px;
            font-family: 'Google Sans';
            color: #3e403f;
            margin-bottom: 35px;
            margin-top: 3vh;
        }
        /*  A welcome message or an explanation of the login form */
        header p {letter-spacing: 0.05em;}

        .input-item {
            background: #fff;
            color: #333;
            /*padding: 14.5px 0px 15px 9px;*/
            border-radius: 5px 0px 0px 5px;
        }

        /* inputs form  */
        input[class="form-input"]{
            width: 30vh;
            height: 50px;

            margin-top: 2%;
            padding: 15px;

            font-size: 16px;
            font-family: 'Abel', sans-serif;
            color: #5E6472;

            outline: none;
            border: none;

            border-radius: 0px 5px 5px 0px;
            transition: 0.2s linear;

        }
        input[id="txt-input"] {width: 30vh;}
        /* focus  */
        input:focus {
            transform: translateX(-2px);
            border-radius: 5px;
        }

        /* input[type="text"] {min-width: 250px;} */
        /* buttons  */
        button {
            display: inline-block;
            color: #fff;

            width: 33vh;
            height: 5vh;

            padding: 0 20px;
            background: #377095;
            border-radius: 5px;

            outline: none;
            border: none;

            cursor: pointer;
            text-align: center;
            transition: all 0.2s linear;

            margin: 7% auto;
            letter-spacing: 0.05em;
        }
        /* Submits */
        .submits {
            width: 100%;
            display: inline-block;
            float: left;
            margin-left: 2%;
        }

        /*     Sign Up button  */
        .sign-up {
            color: white;
            background: #377095;
        }

        /* buttons hover */
        button:hover {
            transform: translatey(3px);
            background: #29436c;
            box-shadow: none;
        }

        /* buttons hover Animation */
        button:hover {
            animation: ani9 0.4s ease-in-out infinite alternate;
        }
        @keyframes ani9 {
            0% {
                transform: translateY(3px);
            }
            100% {
                transform: translateY(5px);
            }
        }

    </style>

</head>
<body>
<div class="overlay">
    <div class="split left">
        <h1>PROJET</h1>
        <img src="logincrp.png" style="width:100%;height:70%">
    </div>

    <div class="split right">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!--   con = Container  for items in the form-->
            <?php
            if(isset($_POST['signup'])){
                echo sprintf("<div class=\"con\">
                        <!--     Start  header Content  -->
                        <header class=\"head-form\">
                            <h2>Sign Up</h2>
                            <!--     A welcome message or an explanation of the login form -->
                            <p>Please select your user type:</p>
                            <div id=\"test\">
                                <input type=\"radio\" id=\"customer\"
                                       name=\"registertype\" value=\"customer\" onclick=\"checkButton()\" required>
                                <label for=\"customer\">Customer</label>
        
                                <input type=\"radio\" id=\"courier\"
                                       name=\"registertype\" value=\"courier\" onclick=\"checkButton()\">
                                <label for=\"courier1\">Courier</label>
        
                                <input type=\"radio\" id=\"employee\"
                                       name=\"registertype\" value=\"employee\" onclick=\"checkButton()\">
                                <label for=\"employee\">Employe</label>
                                <br/>
                                <input type=\"radio\" id=\"companyrepresentative\"
                                       name=\"registertype\" value=\"companyrepresentative\" onclick=\"checkButton()\">
                                <label for=\"companyrepresentative\">Company Representative</label>   
                            </div>
                    </div>");

            }
            else{
                echo sprintf("<div class=\"con\">
                <!--     Start  header Content  -->
                <header class=\"head-form\">
                    <h2>Log In</h2>
                    <!--     A welcome message or an explanation of the login form -->
                    <p>Please select your user type:</p>
                    <div>
                        <input type=\"radio\" id=\"customer\"
                               name=\"usertype\" value=\"customer\" required>
                        <label for=\"customer\">Customer</label>

                        <input type=\"radio\" id=\"courier\"
                               name=\"usertype\" value=\"courier\">
                        <label for=\"courier\">Courier</label>

                        <input type=\"radio\" id=\"employee\"
                               name=\"usertype\" value=\"employee\">
                        <label for=\"employee\">Employee</label>
                        <br/>
                        <input type=\"radio\" id=\"companyrepresentative\"
                               name=\"usertype\" value=\"companyrepresentative\">
                        <label for=\"companyrepresentative\">Company Representative</label>                        
                    </div>

                </header>
                <!--     End  header Content  -->
                <br>
                <div class=\"field-set\">
                        <span class=\"input-item\">

                    </span>
                    <!--   user name Input-->
                    <input class=\"form-input\" id=\"txt-input\" type=\"text\" placeholder=\"Username\" name = \"username\" required>
                    <br>

                    <!--   Password -->

                    <span class=\"input-item\">

                    </span>
                    <!--   Password Input-->
                    <input class=\"form-input\" type=\"password\" placeholder=\"Password\" id=\"pwd\"  name=\"password\" required>

                    <!--      Show/hide password  -->
                    <span>

                    </span>
                    <br>
                    <!--        buttons -->
                    <!--      button LogIn -->
                    <button class=\"log-in\" type = \"submit\" name = \"logIn\"> Log In </button>
                </div>

                <!--   other buttons -->
                <div class=\"other\">
                    <!--      Forgot Password button-->
                    <p>Don't have an account ?</p>
                    <!--     Sign Up button -->
                    <button class=\"btn submits sign-up\" name=\"signup\" formnovalidate>Sign Up
                        <!--         Sign Up font icon -->
                        <i class=\"fa fa-user-plus\" aria-hidden=\"true\"></i>
                    </button>
                    <!--      End Other the Division -->
                </div>

                <!--   End Conrainer  -->
            </div>");
            }
            ?>

            <!-- End Form -->
        </form>
    </div>
</div>

</body>
</html>

