<?php

session_start();
require_once("../../config/config.php");
require_once("../../models/contact/Contact.php");
require_once("../../models/user/User.php");

/*
 *----------------------------------------------------------------------------------------------------
 * Contact controller used for CRUD operation of Contact Book
 * here are 3 cases
 * 1]submit_new_contact
 * 2]delete_contact
 * 3]update_contact
 * according to user input controller do operation and gives response back to user
 *----------------------------------------------------------------------------------------------------
 */
$returnArr = array();
if ($_SESSION["userEmail"] != "") {
    if (!empty($_POST)) {

        //printArr($_FILES);die;
        $Contact = new Contact();
        $User = new User();
        $operation = cleanQuery($_POST["operation"]);
        $user_id = $_SESSION['userId'];

        switch ($operation) {
            case "submit_new_contact":

                $email = cleanQuery($_POST["inputEmail"]);
                $fname = cleanQuery($_POST["first_name"]);
                $lname = cleanQuery($_POST["last_name"]);
                $moblie_number = cleanQuery($_POST["moblie_number"]);

                $exist = $User->isUSerExists($email)['data']['result'];
                if (count($exist) <= 0) {
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "This contact is not registered with us.";
                    echo json_encode($returnArr, true);
                    exit;
                }

                $exist = $User->isContactUSerExists($email, $user_id)['data']['result']['0']['email_address'];
                if ($exist == $email) {
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "This contact already added in your list.";
                    echo json_encode($returnArr, true);
                    exit;
                }

                if ($_FILES["photo_path"]["name"] != "") {
                    $file_ext = strtolower(end(explode('.', $_FILES["photo_path"]['name'])));
                    $file_name = strtotime(date("d-m-y h:i:s a")) . "." . $file_ext;
                } else {
                    $file_name = "";
                    $file_name = strtotime(date("d-m-y h:i:s a")) . ".png";
                    $srcfile = "{$docRoot}assets/sysImg/user-dummy-pic.png";
                    $dstfile = "{$docRoot}assets/images/{$file_name}";
                    copy($srcfile, $dstfile);
                }

                $Contact->commonValidations($email, $fname, $lname, $moblie_number, "photo_path");

                $result = $Contact->submitContactData($email, $fname, $lname, $moblie_number, $file_name, $user_id);

                if (noError($result)) {
                    $returnArr["errCode"] = "-1";
                    $returnArr["errMsg"] = "Contact Data Saved Successfully.";
                } else {
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "Oop's there is error while adding contact, please try again.";
                }
                echo json_encode($returnArr, true);
                break;

            case "delete_contact":
                $contact_id = cleanQuery($_POST["contact_id"]);
                $result = $Contact->deleteContact($contact_id);
                if (noError($result)) {
                    $returnArr["errCode"] = "-1";
                    $returnArr["errMsg"] = "Contact Data Saved Successfully.";
                } else {
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "Oop's there is error while adding contact, please try again.";
                }
                echo json_encode($returnArr, true);
                break;

            case "update_contact":
                $contact_id = cleanQuery($_POST["edit_id"]);

                $email = cleanQuery($_POST["edit_inputEmail"]);
                $fname = cleanQuery($_POST["edit_first_name"]);
                $lname = cleanQuery($_POST["edit_last_name"]);
                $moblie_number = cleanQuery($_POST["edit_moblie_number"]);

                /*   $exist=$User->isContactUSerExists($email,$user_id)['data']['result']['0']['email_address'];
                   if ($exist==$email) {
                       $returnArr["errCode"] = "1";
                       $returnArr["errMsg"] = "This contact already added in your list.";
                       echo json_encode($returnArr, true);
                       exit;
                   }*/

                if ($_FILES["edit_photo_path"]["name"] != "") {
                    $file_ext = strtolower(end(explode('.', $_FILES["edit_photo_path"]['name'])));
                    $file_name = strtotime(date("d-m-y h:i:s a")) . "." . $file_ext;
                } else {
                    $file_name = "";
                }

                $Contact->commonValidations($email, $fname, $lname, $moblie_number, "edit_photo_path");

                $result = $Contact->updateContact($contact_id, $fname, $lname, $moblie_number, $file_name);
                if (noError($result)) {
                    $returnArr["errCode"] = "-1";
                    $returnArr["errMsg"] = "Contact Data Updated Successfully.";
                } else {
                    $returnArr["errCode"] = "1";
                    $returnArr["errMsg"] = "Oop's there is error while Updating contact, please try again.";
                }
                echo json_encode($returnArr, true);
                break;

            case "get_all_contact":
                $name = cleanQuery($_POST["user_name"]);
                $result = $Contact->getAllContact($user_id, $name);
                if (noError($result)) {
                    $result = $result['data']['result'];

                    if (count($result) > 0) {
                        foreach ($result as $val) {
                            $result = $User->getUserId($val['email_address'])['data']['result']['0'];
                            $toUserID = $result['user_id'];
                            $data = $User->getLastMsg($user_id, $toUserID)['data']['result']['0'];
                            $msg = $data['msg'];
                            $timeago = $User->time_ago($data['time'], $full = false);
                            ?>
                            <div class="cardCheck point card p-1 f-sz-10 m-t-1"
                                 onclick="loadChat('<?= $user_id; ?>','<?= $toUserID; ?>')">
                                <div class="row m-b-0p">
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">
                                        <img class="circle imageDim"
                                             src="<?= $rootUrl . "assets/images/" . $val['photo_path']; ?>">
                                    </div>
                                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-7 p-l-0">
                                        <div class="name"><?= $val['first_name'] . " " . $val['last_name']; ?></div>
                                        <div class="subject"></div>
                                    </div>
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-3 text-right">
                                        <time class="gray-text">
                                            <?= $timeago; ?>
                                        </time>
                                    </div>
                                </div>
                                <div class="row m-b-0p">
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">
                                        <i class="fa fa-star f-sz-20 p-t-1 star--active"></i>
                                    </div>
                                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 p-l-0">
                                        <div class="short_msg gray-text">
                                            <?= $msg; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(".cardCheck").click(function () {
                                    $(".cardCheck").removeClass('card--active');
                                    $(this).addClass('card--active');
                                });
                            </script>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="card p-1 f-sz-10 m-t-1">
                            Your searched contact not found OR You have not added any contact.
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="card p-1 f-sz-10 m-t-1">
                        Something went wrong please try again.
                    </div>
                    <?php
                }
                break;
        }

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