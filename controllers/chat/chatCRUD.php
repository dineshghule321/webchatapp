<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once("../../config/config.php");
require_once("../../models/user/User.php");
require_once("../../models/chat/chat.php");


$returnArr = array();
if (!empty($_SESSION) && $_SESSION['userLogin']=="1") {
    if (!empty($_POST)) {

        $UserObject=new User();
        $chat=new chat();

        $postData=array_map('cleanQuery',$_POST);

        $email=$_SESSION['userEmail'];
        $from_user_id=$_SESSION['userId'];
        $to_user_id=$postData['touserId'];
        $toUserDetails=$UserObject->getContactDetails($to_user_id)['data']['result']['0'];
        $fullName=$toUserDetails['first_name']." ".$toUserDetails['last_name'];
        $touserImagePath=$toUserDetails['photo_path'];

        $operation = $postData['operation'];
        switch ($operation) {
            case "submitChatMsg":

                $message = $postData['comments'];
                if ($message != "") {
                    $result = $chat->insertMsg($from_user_id,$to_user_id, $message);
                    if (noError($result)) {
                        $returnArr["errCode"] = $result["errCode"];
                        $returnArr['errMsg'] = "Message content Updated Successfully.";
                    } else {
                        $returnArr["errCode"] = $result["errCode"];
                        $returnArr['errMsg'] = "Error in updating message content please try again";
                    }
                } else {
                    $returnArr["errCode"] = 1;
                    $returnArr['errMsg'] = "Message can not be empty";
                }
                echo json_encode($returnArr);

                break;

            case "checkNewMessages":
                $lastMsgID = cleanQuery(base64_decode($_POST['lastMsgID']));
                if($lastMsgID=="")
                {
                    $lastMsgID="0";
                }
                $userType = $_POST['userType'];
                $result = $chat->getMsgById($from_user_id,$to_user_id,$lastMsgID);
                $output=$result["data"]['result'];

                $chat->metaOutput($output, $from_user_id, $touserImagePath, $fullName);
                break;

            case "initialLoad":
                $userType = $_POST['userType'];
                $result = $chat->getAllMsg($from_user_id,$to_user_id);
                $output=$result["data"]['result'];

                $chat->metaOutput($output, $from_user_id, $touserImagePath, $fullName);
                break;
        }
    } else {
        $returnArr['errCode'] = 403;
        $returnArr['errMsg'] = "Unauthorised.";
        echo json_encode($returnArr);
    }
}else{
    $returnArr['errCode'] = 403;
    $returnArr['errMsg'] = "Unauthorised.";
    echo json_encode($returnArr);
}

?>