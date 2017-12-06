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

                foreach ($output as $key => $value) {
                    $meta = explode(",",$value['meta']);// meta 0=from ,meta 1=to
                    $currentDateTime = $value['time'];
                    $from = $value['from_user_id'];
                    $newDateTime = uDateTime('d-m-Y h:i A', $currentDateTime);

                    if ($meta[0] == $from_user_id) {
                        ?>
                        <div class="p-y-10 chat-right clearfix myMsg endMsg pr10" id="<?php echo base64_encode($currentDateTime); ?>">
                            <div class="p-10 arrow_box right-arrow bg-lightGray pull-right border-radius-10  wrd-wrp_brk-wrd">
                                <div class="chat_msg_div" id="agent_">
                                    <?= $value['msg']; ?>
                                </div>
                                <div class="text-right text-grayscale-80 chat-time">
                                    <span class=""> <?= $newDateTime; ?> </span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="p-y-10 chat-left clearfix oppositeMsg endMsg pr10" id="<?php echo base64_encode($currentDateTime); ?>">
                            <div class="row" style="margin-left: 21px;">
                                <img class="circle imageDim" src="<?= $rootUrl."assets/images/".$touserImagePath; ?>"> <span class="f-sz-20"><?= $fullName; ?></span>
                            </div>
                            <div style='margin-left: 40px'
                                 class="p-10 arrow_box left-arrow bg-lightGray pull-left border-radius-10  wrd-wrp_brk-wrd">
                                <div class="chat_msg_div" id="customer_>">
                                    <?= $value['msg']; ?>
                                </div>
                                <div class="text-right text-grayscale-80 chat-time">
                                    <span class=""> <?= $newDateTime; ?> </span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                break;

            case "initialLoad":
                $userType = $_POST['userType'];
                $result = $chat->getAllMsg($from_user_id,$to_user_id);
                $output=$result["data"]['result'];

                foreach ($output as $key => $value) {
                    $meta = explode(",",$value['meta']);// meta 0=from ,meta 1=to
                    $currentDateTime = $value['time'];
                    $from = $value['from_user_id'];
                    $newDateTime = uDateTime('d-m-Y h:i A', $currentDateTime);

                    if ($meta[0] == $from_user_id) {

                        ?>
                        <div class="p-y-10 chat-right clearfix myMsg endMsg pr10" id="<?php echo base64_encode($currentDateTime); ?>">
                            <div class="p-10 arrow_box right-arrow bg-lightGray pull-right border-radius-10  wrd-wrp_brk-wrd">
                                <div class="chat_msg_div" id="agent_">
                                    <?= $value['msg']; ?>
                                </div>
                                <div class="text-right text-grayscale-80 chat-time">
                                    <span class=""> <?= $newDateTime; ?> </span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="p-y-10 chat-left clearfix oppositeMsg endMsg pr10" id="<?php echo base64_encode($currentDateTime); ?>">

                                <div class="row" style="margin-left: 21px;">
                                    <img class="circle imageDim" src="<?= $rootUrl."assets/images/".$touserImagePath; ?>"> <span class="f-sz-20"><?= $fullName; ?></span>
                                </div>

                            <div style='margin-left: 40px'
                                 class="p-10 arrow_box left-arrow bg-lightGray pull-left border-radius-10  wrd-wrp_brk-wrd">
                                <div class="chat_msg_div" id="customer_>">
                                    <?= $value['msg']; ?>
                                </div>
                                <div class="text-right text-grayscale-80 chat-time">
                                    <span class=""> <?= $newDateTime; ?> </span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
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