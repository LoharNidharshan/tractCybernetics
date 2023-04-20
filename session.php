<?php
session_start();
if(!isset($_SESSION['uName']))
{
    header("Location: index.php");
}


?>