<?php
session_start();
include "../config/config.php";

if($_SESSION["email_handle"]!="" || $_SESSION["email"]!="")
{
    $urlLogin=$rootUrl."views/user/index.php";
    header("Location:{$urlLogin}");
}else
{
    $urlLogin=$rootUrl."views/user/login.php";
    header("Location:{$urlLogin}");
}


?>