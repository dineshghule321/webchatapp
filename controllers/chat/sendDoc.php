<?php
/**
 * Created by PhpStorm.
 * User: dinesh
 * Date: 16/9/17
 * Time: 10:26 AM
 */

session_start();
require_once("../../config/config.php");
require_once("../../models/chat/chat.php");
require_once("../../models/user/User.php");

$returnArr = array();
if ($_SESSION["userEmail"] != "") {
    if (!empty($_POST)) {

        $chat = new chat();
        $User = new User();
        $user_id = $_SESSION['userId'];


                $touserId = cleanQuery($_POST["touserId"]);
                $description = cleanQuery($_POST["description"]);

                if ($_FILES["file_path"]["name"]!="") {
                    $file_ext = strtolower(end(explode('.', $_FILES["file_path"]['name'])));
                    $file_name = strtotime(date("d-m-y h:i:s a")) . "." . $file_ext;
                }else{
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "Please select Document.";
                    echo json_encode($returnArr, true);
                    exit;
                }

                if($description=="")
                {
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "Document Description is mandatory.";
                    echo json_encode($returnArr, true);
                    exit;
                }

                $chat->validateDoc("file_path");

                $result = $chat->insertSharedFile($user_id, $touserId,$file_name,$description);

                if (noError($result)) {
                    $returnArr["errCode"] = "-1";
                    $returnArr["errMsg"] = "Document Shared Successfully.";
                } else {
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "Oop's there is error while shearing Document, please try again.";
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