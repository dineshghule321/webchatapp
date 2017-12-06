<?php
/**
 * Created by PhpStorm.
 * User: dinesh
 * Date: 16/9/17
 * Time: 10:26 AM
 */

session_start();
require_once("../../config/config.php");
require_once("../../models/user/User.php");

$returnArr = array();
if ($_SESSION["userEmail"] != "") {
    if (!empty($_FILES)) {

        $User = new User();

        if ($_FILES["changenewprofile"]["name"] != "") {
            $file_ext = strtolower(end(explode('.', $_FILES["changenewprofile"]['name'])));
            $file_name = strtotime(date("d-m-y h:i:s a")) . "." . $file_ext;
        } else {
            $returnArr["errCode"] = "1";
            $returnArr["errMsg"] = "Please select image.";
            echo json_encode($returnArr, true);
            exit;
        }

        $User->validateImages("changenewprofile");

        $result = $User->updateProfilePic($file_name, $_SESSION["userEmail"]);

        if (noError($result)) {
            $data = $User->isUSerExists($_SESSION["userEmail"]);
            $imagePath = $rootUrl . "assets/sysImg/profile/" . $data['data']['result'][0]['profile_pic_path'];
            $returnArr["errCode"] = "-1";
            $returnArr["errMsg"] = $imagePath;
        } else {
            $returnArr["errCode"] = "1";
            $returnArr["errMsg"] = "Oop's there is error while updating profile picture, please try again.";
        }
        echo json_encode($returnArr, true);

    } else {
        $returnArr["errCode"] = "1";
        $returnArr["errMsg"] = "Invalid Details please enter proper inputs.";
        echo json_encode($returnArr, true);
    }
} else {
    $returnArr["errCode"] = "1";
    $returnArr["errMsg"] = "Unauthorised .";
    echo json_encode($returnArr, true);
}

?>