<?php

session_start();
//start config
require_once("../../config/config.php");
require_once("../../models/user/User.php");

$rootViews = $rootView . "user/login.php";
$email = $_SESSION['userEmail'];
session_destroy();
$UserObject = new User();
if ($email != "") {
    $UserObject->updateLogoutTime($email);
}
print("<script>window.location='" . $rootViews . "'</script>");
exit;

?>