<h1> courier </h1>
<?php
session_start();
require_once "config.php";
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === FALSE){
    header("location: login.php");
} else if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}
$username = $_SESSION['username'];
$id = $_SESSION['user_id'];
?>
<body>
<div class="wrapper">
    <form action='logout.php' method='post'>
        <button id='logout' type='submit' name='logout'>Logout</button>
    </form>
</div>
</body>