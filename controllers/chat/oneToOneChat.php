<?php
session_start();
require_once("../../config/config.php");
require_once("../../models/user/User.php");
require_once("../../models/contact/Contact.php");

if(!empty($_GET) && $_SESSION['userLogin']=="1")
{
    $fromUserID=urldecode($_GET['fromUser']);

    $toUserEmail=urldecode($_GET['toUser']);
    $User=new User();
    $Contact=new Contact();
    //$result=$User->getUserId($toUserEmail)['data']['result']['0'];
    $result=$User->getUserDataByID($toUserEmail)['data']['result']['0'];
    $toUserEmail=$result['email_address'];
    $lastLogin=$result['last_login_time'];
    $lastLogOut=$result['last_logout_time'];
    $lastActivity=$result['last_activity_time'];
    $toUserID=$result['user_id'];

    $result=$Contact->getContactDetailsByEmail($toUserEmail)['data']['result']['0'];
    $fullName=ucwords(strtolower($result['first_name']." ".$result['last_name']));
    $proPic=$result['photo_path'];

    $last_logout_time = strtotime($lastLogOut);

    $lastActiveTime = strtotime($lastActivity);
    $nowtime= time();

    if($last_logout_time>$lastActiveTime)
    {
        $onlineClass="userOffline";
        $online="Offline";
    }else
    {
        // if (($nowtime-$lastActiveTime ) < (15 * 60))
        $diffrence=(int)round(abs($nowtime - $lastActiveTime) / 60,2);
        if($diffrence<20)
        {
            $onlineClass="userOnline";
            $online="Online";
        }elseif($diffrence>20){
            $onlineClass="userOffline";
            $online="Offline";
        }
    }


    $lastSeen=$User->lastSeen($lastActivity);

    if($fromUserID!="" && $toUserID!="") {
        ?>
<input type="hidden" id="toUserIdInput" value="<?= $toUserID; ?>">
        <div class="row chatHead">
            <div class="col-lg-12">
                <div class="col-lg-9">
                    <div><span class="f-sz-20"><?= $fullName; ?> </span><span style=' margin-left: 25px;' class="fa fa-circle <?= $onlineClass; ?>">&nbsp;<span><?= $online; ?></span></span>
                    </div>
                    <p class="lastSeen"><?= $lastSeen; ?></p>
                </div>
                <div class="col-lg-3 pull-right interaction">
                    <h4>
                        <span class="point fa fa-phone listMenuColor listMenuChat"></span>
                        <span class="point fa fa-video-camera listMenuColor listMenuChat"></span>
                        <span class="point fa fa-ellipsis-h listMenuColor"></span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="p-10 chatScroll " id="chatComments">




        </div>
        <div class="chat-input position-relative">
            <textarea name="shout_message" id="shout_message" class="autoExpand"
                      placeholder="Type your message here"></textarea>
            <i class="fa fa-paper-plane-o chatSubmit" onclick="submitChat()" id="submitForChat" aria-hidden="true" ajax_call="true"></i>
        </div>
        <div class="row chatFooter">
            <div class="col-lg-12">
                <h4>
                    <span class="point fa fa-paperclip listMenuColor listMenuChat" data-toggle="modal" data-target="#sendAttachmentModalDoc"></span>
                    <span class="point fa fa-picture-o listMenuColor listMenuChat" data-toggle="modal" data-target="#sendAttachmentModalImage"></span>
                    <span class="point fa fa-microphone listMenuColor listMenuChat"></span>
                    <span class="point fa fa-ellipsis-h listMenuColor"></span>
                </h4>
            </div>
        </div>
        <script>
            $("#shout_message").keypress(function(e) {
                if (e.keyCode == 13 && !e.shiftKey) {
                    submitChat();
                }
            });
        </script>
        <?php
    }else{
        ?>
        <div class='p-y-10 chat-right clearfix chatSpace'><h2>Chat Space</h2></div>

<?php
    }
}else{
    header("location:{$rootUrl}views/user/login.php");
}
?>