<?php

class chat
{
    public $connection = "";

    function __construct()
    {
        $this->connection = new DB("dbSystem", 'FALSE');
    }

    function insertMsg($from_user_id, $to_user_id, $msg)
    {
        $Arr = array(
            "from_user_id" => $from_user_id,
            "to_user_id" => $to_user_id,
            "msg" => $msg,
            "time" => NOWTime(),
            "meta" => "$from_user_id,$to_user_id"
        );
        return $this->connection->insert("message", $Arr);

    }

    function insertSharedFile($from_user_id, $to_user_id, $file, $description)
    {
        $Arr = array(
            "from_user_id" => $from_user_id,
            "to_user_id" => $to_user_id,
            "shared_file" => $file,
            "msg" => $description,
            "time" => NOWTime(),
            "meta" => "$from_user_id,$to_user_id"
        );
        return $this->connection->insert("message", $Arr);

    }

    function getAllMsg($from_user_id, $to_user_id)
    {
        $query = "SELECT * FROM message where from_user_id IN ($from_user_id,$to_user_id) AND to_user_id IN ($from_user_id,$to_user_id)";
        return $this->connection->query($query);

    }

    function getMsgById($from_user_id, $to_user_id, $lastMsgId)
    {

        if ($lastMsgId != "") {
            if ($lastMsgId == "0") {
                $query = "SELECT * FROM message where from_user_id IN ($from_user_id,$to_user_id) AND to_user_id IN ($from_user_id,$to_user_id)";
            } else {
                $query = "SELECT * FROM message where from_user_id IN ($from_user_id,$to_user_id) AND to_user_id IN ($from_user_id,$to_user_id) AND time > '{$lastMsgId}'";

            }
            return $this->connection->query($query);
        } else {
            $arr['errCode'] = 2;
            $arr['errMsg'] = "Last Msg ID required";
            return $arr;
        }

    }

    function validateImages($fileId)
    {
        global $docRoot;
        if ($_FILES["{$fileId}"]["name"] != "") {
            $file_tmp_name = $_FILES["tmp_name"];
            $file_Size = $_FILES["size"];
            $file_name = $_FILES["name"];


            $file_ext = strtolower(end(explode('.', $_FILES["{$fileId}"]['name'])));
            $file_name = strtotime(date("d-m-y h:i:s a")) . "." . $file_ext;

            $target_dir = $docRoot . "assets/sysImg/sharedFiles/";

            $target_file = $target_dir . basename($_FILES["{$fileId}"]["name"]);


            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            $target_file = $target_dir . $file_name;
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["{$fileId}"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $msg = "File is not an image.Please upload valid Image file.";
                $uploadOk = 0;
                $returnArr["errCode"] = "1";
                $returnArr["errMsg"] = $msg;
                echo json_encode($returnArr, true);
                exit;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $msg = "Sorry, file already exists.";
                $uploadOk = 0;
                $returnArr["errCode"] = "1";
                $returnArr["errMsg"] = $msg;
                echo json_encode($returnArr, true);
                exit;
            }

            // Check file size
            if ($_FILES["{$fileId}"]["size"] > 500000) {
                $msg = "Sorry, your file is too large.";
                $uploadOk = 0;
                $returnArr["errCode"] = "1";
                $returnArr["errMsg"] = $msg;
                echo json_encode($returnArr, true);
                exit;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
                $returnArr["errCode"] = "1";
                $returnArr["errMsg"] = $msg;
                echo json_encode($returnArr, true);
                exit;
            }
        }

        if ($_FILES["{$fileId}"]["name"] != "") {
            if (move_uploaded_file($_FILES["{$fileId}"]["tmp_name"], $target_file)) {
            } else {
                $msg = "Sorry, there was an error uploading your file.Please try again";
                $returnArr["errCode"] = "1";
                $returnArr["errMsg"] = $msg;
                echo json_encode($returnArr, true);
                exit;
            }
        }
    }

    function metaZeroImage($currentDateTime, $sharedFile, $msg, $newDateTime)
    {
        ?>
        <div class="p-y-10 chat-right clearfix myMsg endMsg pr10" id="<?php echo base64_encode($currentDateTime); ?>">
            <div class="p-10 arrow_box right-arrow bg-lightGray pull-right border-radius-10  wrd-wrp_brk-wrd">
                <div class="chat_msg_div" id="agent_">
                    <a data-toggle="tooltip" title="Download" href="<?= $sharedFile; ?>" download><img class="tftImage"
                                                                                                       src="<?= $sharedFile; ?>"></a>
                    <div class=""><?= $msg; ?></div>
                </div>
                <div class="text-right text-grayscale-80 chat-time">
                    <span class=""> <?= $newDateTime; ?> </span>
                </div>
            </div>
        </div>
        <?php
    }

    function metaOneImage($currentDateTime, $sharedFile, $msg, $newDateTime, $touserImagePath, $fullName)
    {
        global $rootUrl;
        ?>
        <div class="p-y-10 chat-left clearfix oppositeMsg endMsg pr10"
             id="<?php echo base64_encode($currentDateTime); ?>">
            <div class="row" style="margin-left: 21px;">
                <img class="circle imageDim" src="<?= $rootUrl . "assets/images/" . $touserImagePath; ?>"> <span
                        class="f-sz-20"><?= $fullName; ?></span>
            </div>
            <div style='margin-left: 40px'
                 class="p-10 arrow_box left-arrow bg-lightGray pull-left border-radius-10  wrd-wrp_brk-wrd">
                <div class="chat_msg_div" id="customer_>">
                    <a data-toggle="tooltip" title="Download" href="<?= $sharedFile; ?>" download><img class="tftImage"
                                                                                                       src="<?= $sharedFile; ?>"></a>
                    <div class=""><?= $msg; ?></div>
                </div>
                <div class="text-right text-grayscale-80 chat-time">
                    <span class=""> <?= $newDateTime; ?> </span>
                </div>
            </div>
        </div>
        <?php
    }

    function metaZeroText($currentDateTime, $msg, $newDateTime)
    {
        ?>
        <div class="p-y-10 chat-right clearfix myMsg endMsg pr10" id="<?php echo base64_encode($currentDateTime); ?>">
            <div class="p-10 arrow_box right-arrow bg-lightGray pull-right border-radius-10  wrd-wrp_brk-wrd">
                <div class="chat_msg_div" id="agent_">
                    <?= $msg; ?>
                </div>
                <div class="text-right text-grayscale-80 chat-time">
                    <span class=""> <?= $newDateTime; ?> </span>
                </div>
            </div>
        </div>
        <?php
    }

    function metaOneText($currentDateTime, $touserImagePath, $fullName, $msg, $newDateTime)
    {
        global $rootUrl;
        ?>
        <div class="p-y-10 chat-left clearfix oppositeMsg endMsg pr10"
             id="<?php echo base64_encode($currentDateTime); ?>">
            <div class="row" style="margin-left: 21px;">
                <img class="circle imageDim" src="<?= $rootUrl . "assets/images/" . $touserImagePath; ?>"> <span
                        class="f-sz-20"><?= $fullName; ?></span>
            </div>
            <div style='margin-left: 40px'
                 class="p-10 arrow_box left-arrow bg-lightGray pull-left border-radius-10  wrd-wrp_brk-wrd">
                <div class="chat_msg_div" id="customer_>">
                    <?= $msg; ?>
                </div>
                <div class="text-right text-grayscale-80 chat-time">
                    <span class=""> <?= $newDateTime; ?> </span>
                </div>
            </div>
        </div>
        <?php
    }

    function metaOutput($output, $from_user_id, $touserImagePath, $fullName)
    {
        global $rootUrl;
        foreach ($output as $key => $value) {
            $meta = explode(",", $value['meta']);// meta 0=from ,meta 1=to
            $currentDateTime = $value['time'];
            $from = $value['from_user_id'];
            $file = $value['shared_file'];
            $msg = $value['msg'];
            $newDateTime = uDateTime('d-m-Y h:i A', $currentDateTime);

            if ($file != "") {
                $sharedFile = $rootUrl . 'assets/sysImg/sharedFiles/' . $file;
                if ($meta[0] == $from_user_id) {
                    $this->metaZeroImage($currentDateTime, $sharedFile, $msg, $newDateTime);
                } else {
                    $this->metaOneImage($currentDateTime, $sharedFile, $msg, $newDateTime, $touserImagePath, $fullName);
                }
            } else {
                if ($meta[0] == $from_user_id) {
                    $this->metaZeroText($currentDateTime, $msg, $newDateTime);
                } else {
                    $this->metaOneText($currentDateTime, $touserImagePath, $fullName, $msg, $newDateTime);
                }
            }

        }
    }
}