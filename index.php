<?php
session_start();
include "config/config.php";
    // $url=$rootUrl."html/index.php";
    $url=$rootUrl."views/index.php";
    header("Location:{$url}");

?>