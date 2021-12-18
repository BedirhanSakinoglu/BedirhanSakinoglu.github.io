<?php
if(!defined('host')) define('host', 'localhost');
if(!defined('dbname')) define('dbname', 'projetdb');
if(!defined('username')) define('username', 'root');
if(!defined('password')) define('password', 'projet123');
$mysqli = new mysqli(host, username, password, dbname);
if($mysqli->connect_errno){
    echo "Failed to connect to MySQl: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>