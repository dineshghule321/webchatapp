<?php
session_start();

//start config
require_once('../../config/config.php');
require_once("../../models/user/User.php");

global $inactive;
$email=$_SESSION['userEmail'];

$UserObject=new User();

if (isset($_SESSION["timeout"])) {
    $sessionTTL = time() - $_SESSION["timeout"];
    if ($sessionTTL > $inactive) {

        session_destroy();

        if($email!="")
        {
            $UserObject->updateLogoutTime($email);
        }
        $data="-1";

    }else
    {
        if($email!="")
        {
            $UserObject->updateLastActivityTime($_SESSION["userEmail"]);
        }
        $data= "Updated Time";
    }
}


echo $data;