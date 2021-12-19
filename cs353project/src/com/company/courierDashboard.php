<h1> courier </h1>

<?php
session_start();
require_once "config.php";

$id = $_SESSION['user_id'];
echo sprintf("%s", $id);
?>
<body>
<div class="wrapper">
    <form action='logout.php' method='post'>
        <button id='logout' type='submit' name='logout'>Logout</button>
    </form>
</div>
</body>