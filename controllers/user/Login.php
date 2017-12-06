<?php

/*
 *----------------------------------------------------------------------------------------------------
 * Login controller used for Login  of User  Contact Book
 * Here based on user input controller check is valid user if valid set session and redirect to main
 * page Else redirect to same page with an error.
 *----------------------------------------------------------------------------------------------------
 */
session_start();
require_once("../../config/config.php");
require_once("../../models/user/User.php");

if (!empty($_POST)) {
    $UserObject = new User();
    $postData = array_map('cleanQuery', $_POST);

    $user = strtolower($postData["user_email"]);
    $pass = $postData["user_password"];

    $pass = sha1Md5DualEncryption($pass);

    if (empty($_POST["user_email"])) {
        $returnArr["errCode"] = "1";
        $returnArr["errMsg"] = "Please Enter Email Address.";
        $_SESSION["loginError"] = $returnArr;
        header("location:{$rootUrl}views/user/login.php");
        exit;
    } else {
        if (!filter_var($user, FILTER_VALIDATE_EMAIL)) {
            $returnArr["errCode"] = "1";
            $returnArr["errMsg"] = "Please enter valid email Address.";

            $_SESSION["loginError"] = $returnArr;
            header("location:{$rootUrl}views/user/login.php");
            exit;
        }
    }

    if (empty($_POST["user_password"])) {
        $returnArr["errCode"] = "2";
        $returnArr["errMsg"] = "Please Enter Password.";

        $_SESSION["loginError"] = $returnArr;
        header("location:{$rootUrl}views/user/login.php");
        exit;
    }

    $Status = "1";
    $result = $UserObject->validateLogin($user, $pass, $Status);


    $newdata = $result["data"]["result"]["0"];
    $newemail = $newdata["email_address"];
    $userid = $newdata["user_id"];
    $newepass = $newdata["passwordHash"];
    $name = ucfirst($newdata["first_name"]) . " " . ucfirst($newdata["last_name"]);
    $profilepic = $newdata["profile_pic"];
    $Status = $newdata["status"];

    if ($Status == "") {
        $returnArr["errCode"] = "3";
        $returnArr["errMsg"] = "Invalid Username and Password.";

        $xml_data['step7']["data"] = "3. Invalid Username and Password.";
        $_SESSION["loginError"] = $returnArr;
        header("location:{$rootUrl}views/user/login.php");
        exit;
    }

    if ($Status != 1 && $Status == 0) {
        $returnArr["errCode"] = "3";
        $returnArr["errMsg"] = "Your account is not activated.";
        $_SESSION["loginError"] = $returnArr;
        header("location:{$rootUrl}views/user/login.php");
        exit;
    }
    if (($user == $newemail) && ($pass == $newepass)) {

        $_SESSION['userLogin'] = "1";
        $_SESSION['userEmail'] = $newemail;
        $_SESSION['userId'] = $userid;
        $_SESSION["timeout"] = time();
        $_SESSION["timezone"] = $Timezone;

        $UserObject->updateLoginTime($newemail);
        unset($_SESSION["loginError"]);
        header("location:{$rootUrl}views/home/home.php");

    } else {

        $returnArr["errCode"] = "3";
        $returnArr["errMsg"] = "Invalid Username and Password!!";

        $_SESSION["loginError"] = $returnArr;
        header("location:{$rootUrl}views/user/login.php");
    }


} else {
    header("location:{$rootUrl}views/user/login.php");
}