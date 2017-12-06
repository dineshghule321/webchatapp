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

    $emailAddress = strtolower($postData["emailAddress"]);
    $password = $postData["password"];

    if (empty($_POST["emailAddress"])) {
        $returnArr["errCode"] = "1";
        $returnArr["errMsg"] = "Please Enter Email Address.";
        $_SESSION["signupError"] = $returnArr;
        header("location:{$rootUrl}views/user/signup.php");
        exit;
    } else {
        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            $returnArr["errCode"] = "1";
            $returnArr["errMsg"] = "Please enter valid email Address.";

            $_SESSION["signupError"] = $returnArr;
            header("location:{$rootUrl}views/user/signup.php");
            exit;
        }
    }

    if(strlen($password)<6)
    {
        $returnArr["errCode"] = "1";
        $returnArr["errMsg"] = "Please should be greater than six character.";

        $_SESSION["signupError"] = $returnArr;
        header("location:{$rootUrl}views/user/signup.php");
        exit;
    }

    $exist = $UserObject->isUSerExists($emailAddress)['data']['result']['0']['email_address'];
    if ($exist == $emailAddress) {
        $returnArr["errCode"] = "1";
        $returnArr["errMsg"] = "That email address is already registered try with another email address.";
        $_SESSION["signupError"] = $returnArr;
        header("location:{$rootUrl}views/user/signup.php");
        exit;
    }


    $status = "1";
    $result = $UserObject->addUser($emailAddress, $password, $status);
    if (noError($result)) {
        $returnArr["errCode"] = "-1";
        $returnArr["errMsg"] = "Signup Success login now";
        $_SESSION["loginError"] = $returnArr;
        header("location:{$rootUrl}views/user/login.php");
    } else {
        $returnArr["errCode"] = "1";
        $returnArr["errMsg"] = "Signup process failed please try again";
        $_SESSION["signupError"] = $returnArr;
        header("location:{$rootUrl}views/user/signup.php");
    }


}
