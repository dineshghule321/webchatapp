<?php
if (empty($_SESSION)) {
    session_start();
}
require_once "../layout/checkSession.php";
require_once("../../models/user/User.php");
$User = new User();
$data = $User->isUSerExists($_SESSION["userEmail"]);
$imagePath = $rootUrl . "assets/sysImg/profile/" . $data['data']['result'][0]['profile_pic_path'];
$fromUserID = $_SESSION['userId'];
?>
<div class="row m-b-0">
    <div class="col-lg-1">
        <ul class="sidebar white-text primary list-group flex-column m-b-0">
            <li class="text-center p-y-3">
                <img onclick="changeProfilePic()" class="frtybyImage circle point" src="<?= $imagePath; ?>">
                <form name="form_uploadpic" id="form_uploadpic" method="POST" enctype="multipart/form-data"
                      action="javascript:;">
                    <div>
                        <input style="position:absolute;top:-500px" type="file" id="changenewprofile"
                               name="changenewprofile">
                    </div>
                </form>
            </li>
            <li class="text-center  menu active" data-id="mchatBox"><i class="fa fa-inbox"> </i></li>
            <li class="text-center menu " data-id="mailBox"><i class="fa fa-paper-plane"></i></li>
            <li class="text-center menu " data-id="editBox"><i class="fa fa-pencil-square"></i></li>
            <li class="text-center menu " data-id="deleteBox"><i class="fa fa-trash-o"></i></li>
            <li class="text-center btn-more"><i class="fa fa-ellipsis-v"></i></li>
        </ul>
    </div>

    <div id="liContainer">
        <div id="mchatBox" class="boxContainer">
            <div class="col-lg-4">
                <div id="custom-search-input">
                    <div class="input-group col-md-12">
                        <input type="text" class="  search-query form-control" name='search-query' id='search-query'
                               placeholder="Search Contact"/>
                        <span class="input-group-btn">
                                    <button class="btn colorMainBtn" type="button" onclick="getUserList()">
                                        <span class="">Search</span>
                                    </button>
                                </span>
                    </div>
                </div>


                <div id="myContactList" class="myContactListScroll">

                </div>

                <a href="#" id="addNewContacts"
                   class="btn--add circle primary  text-center white-text f-sz-20 depth-1 pull-right m-y-1">+</a>
                <div></div>
            </div>
            <div class="col-lg-7 chat-container bg-light-purple" id="userMessage">


            </div>

            <div class="modal fade" role="dialog" id="sendAttachmentModalImage">
                <div class="modal-dialog" style="width:40%">
                    <div class="modal-content">
                        <form class="form-horizontal" name="frm_add_new_file_image" id="frm_add_new_file_image"
                              enctype="multipart/form-data" method="POST">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                </button>
                                <h4 class="modal-title mainColor">Send Image File</h4>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="photo_path" class="col-lg-2 control-label">Attach File</label>
                                    <div class="col-lg-10">
                                        <input type="file" class="form-control" name="file_path" id="file_path">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="photo_path" class="col-lg-2 control-label">Description</label>
                                    <div class="col-lg-10">
                                        <textarea rows='3' cols='5' class="form-control" id="description"
                                                  name="description"></textarea>
                                    </div>
                                </div>


                                <div class="form-group has-error">
                                    <div class="col-lg-10 pull-right">
                                        <span id="err_frmSubmit_response_file_im" class="help-block"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="submit_frm_add_new_file_im" class="btn colorMainBtn">Send
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" role="dialog" id="sendAttachmentModalDoc">
                <div class="modal-dialog" style="width:40%">
                    <div class="modal-content">
                        <form class="form-horizontal" name="frm_add_new_file_doc" id="frm_add_new_file_doc"
                              enctype="multipart/form-data" method="POST">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                </button>
                                <h4 class="modal-title mainColor">Send Document</h4>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="photo_path" class="col-lg-2 control-label">Attach File</label>
                                    <div class="col-lg-10">
                                        <input type="file" class="form-control" name="file_path" id="file_path">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="photo_path" class="col-lg-2 control-label">Description</label>
                                    <div class="col-lg-10">
                                        <textarea rows='3' cols='5' class="form-control" id="description"
                                                  name="description"></textarea>
                                    </div>
                                </div>


                                <div class="form-group has-error">
                                    <div class="col-lg-10 pull-right">
                                        <span id="err_frmSubmit_response_file_doc" class="help-block"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="submit_frm_add_new_file_doc" class="btn colorMainBtn">Send
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="mailBox" class="boxContainer hide">
            <div class="text-center"><h2>Inbox Coming Soon</h2></div>
        </div>

        <div id="editBox" class="boxContainer hide">
            <div class="text-center"><h2>Edit Box Coming Soon</h2></div>
        </div>

        <div id="deleteBox" class="boxContainer hide">
            <div class="text-center"><h2>Delete Box Coming Soon</h2></div>
        </div>
    </div>
</div>

<script>

    $(".menu").click(function () {
        $(".menu").removeClass('active');
        $(this).addClass('active');
        var id = $(this).attr('data-id');
        var divIdopen = $(".boxContainer").not(".hide").prop("id");
        $("#" + divIdopen).addClass('hide');
        $("#" + id).removeClass('hide');

    });

    function changeProfilePic() {
        $("#changenewprofile").click();
    }

    $('#changenewprofile').change(function () {

        var formData = new FormData($('#form_uploadpic')[0]);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../../controllers/chat/updateProPic.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (data) {

                if (data["errCode"] != "-1") {

                } else if (data["errCode"] == "-1") {
                    var path = data['errMsg'];
                    $(".frtybyImage").attr('src', path);
                    document.getElementById("form_uploadpic").reset();
                }
            },
            error: function () {
                console.log("fail");
            }
        });

    });

    $(document).ready(function () {
        getUserList();
        showChatSpace();
    });

    function showChatSpace() {
        var html = "<div class='p-y-10 chat-right clearfix chatSpace'><h2>Chat Space</h2></div>";
        $("#userMessage").html(html);
    }

    $("#search-query").keyup(function () {
        getUserList();
    });

    $("#addNewContacts").click(function () {
        $("#contactDetailstab").trigger('click');
        $("#addContactButton").trigger('click');
    });

    function getUserList() {
        var user_name = $("#search-query").val();


        $.ajax({
            type: "POST",
            dataType: "html",
            url: "../../controllers/user/Contact.php",
            beforeSend: function () {
            },
            complete: function () {
            },
            data: {
                operation: "get_all_contact", user_name: user_name
            },
            success: function (data) {
                $("#myContactList").html(data);
            },
            error: function () {
                console.log("fail");
            }
        });


    }


    function loadChat(fromUser, toUser) {
        $("#userMessage").html('');
        $("#userMessage").load('../../controllers/chat/oneToOneChat.php?fromUser=' + fromUser + '&toUser=' + toUser);
        initialLoad(toUser);

    }


    /************************************************ chat ***********************************************************/


    // To create new comment/message on press icone to enter
    function submitChat() {
        var comments = $("#shout_message").val();
        var touserId = $("#toUserIdInput").val();
        var fromUserId = "<?= $fromUserID; ?>";
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../../controllers/chat/chatCRUD.php",
            data: {
                comments: comments,
                touserId: touserId,
                fromUserId: fromUserId,
                operation: 'submitChatMsg'
            },
            beforeSend: function () {
            },
            success: function (data) {
                if (data["errCode"] == "-1") {
                    $("#shout_message").val(" ");
                    $("#shout_message").focus();
                    updateChatWindow();
                } else {
                    console.log(data["errMsg"]);
                }

            },
            complete: function (data) {
            },
            error: function () {
                console.log("fail");
            }

        });
    }

    function updateChatWindow() {
        var lastMsgID = $.trim($("#chatComments .endMsg").last().attr("id"));

        if (typeof lastMsgID != "undefined") {
            var lastMsgID = lastMsgID;
        } else {
            var lastMsgID = 0;
        }

        var userType = "me";

        var touserId = $("#toUserIdInput").val();
        console.log("to:" + touserId);
        if (touserId != undefined) {
            var fromUserId = "<?= $fromUserID; ?>";

            $.ajax({
                type: "POST",
                dataType: "html",
                url: "../../controllers/chat/chatCRUD.php",
                data: {
                    lastMsgID: lastMsgID,
                    touserId: touserId,
                    userType: userType,
                    fromUserId: fromUserId,
                    operation: 'checkNewMessages'
                },
                beforeSend: function () {

                },
                success: function (data) {
                    if (data) {
                        /* var todayDate = todayDateData();
                         var dateId = $('#chatComments').find('#' + todayDate).length;
                         if (dateId == 1) {
                             var response = $('<div />').html(data);
                             var responseDiv = response.find('#' + todayDate);
                             $(responseDiv).remove();
                         } else {
                             var response = data;
                         }*/
                        var response = data;
                        $("#chatComments").append(response);

                        var elem = document.getElementById('chatComments');
                        elem.scrollTop = elem.scrollHeight;
                    } else {
                        console.log("error to fetch updated messages");
                    }
                },
                error: function () {
                    console.log("fail");
                }
            });
        }
    }

    setInterval(updateChatWindow, <?= $chatRefreshTime; ?>); //chek new msgs


    function initialLoad(touserId) {
        var userType = "me";
        var fromUserId = "<?= $fromUserID; ?>";

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "../../controllers/chat/chatCRUD.php",
            data: {
                touserId: touserId,
                userType: userType,
                fromUserId: fromUserId,
                operation: 'initialLoad'
            },
            beforeSend: function () {

            },
            success: function (data) {
                if (data) {
                    var response = data;
                    $("#chatComments").append(response);

                    var elem = document.getElementById('chatComments');
                    elem.scrollTop = elem.scrollHeight;
                } else {
                    console.log("error to fetch updated messages");
                }
            },
            error: function () {
                console.log("fail");
            }
        });

    }

    function sendImage() {
        var touserId = $("#toUserIdInput").val();
        var fromUserId = "<?= $fromUserID; ?>";

        $("#err_frmSubmit_response_file_im").html("");

        var formData = new FormData($('#frm_add_new_file_image')[0]);
        formData.append('touserId', touserId);
        formData.append('fromUserId', fromUserId);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../../controllers/chat/sendImage.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (data) {

                if (data["errCode"] != "-1") {

                    $("#err_frmSubmit_response_file_im").html(data["errMsg"]);
                } else if (data["errCode"] == "-1") {
                    document.getElementById("frm_add_new_file_image").reset();
                    $("#sendAttachmentModalImage").modal('hide');
                    updateChatWindow();
                }
            },
            error: function () {
                console.log("fail");
            }
        });
    }

    $("#submit_frm_add_new_file_im").click(function () {
        sendImage();
    });


    function sendDocument() {
        var touserId = $("#toUserIdInput").val();
        var fromUserId = "<?= $fromUserID; ?>";

        $("#err_frmSubmit_response_file_doc").html("");

        var formData = new FormData($('#frm_add_new_file_doc')[0]);
        formData.append('touserId', touserId);
        formData.append('fromUserId', fromUserId);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../../controllers/chat/sendDoc.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (data) {

                if (data["errCode"] != "-1") {

                    $("#err_frmSubmit_response_file_doc").html(data["errMsg"]);
                } else if (data["errCode"] == "-1") {
                    document.getElementById("frm_add_new_file_doc").reset();
                    $("#sendAttachmentModalDoc").modal('hide');
                    updateChatWindow();
                }
            },
            error: function () {
                console.log("fail");
            }
        });
    }

    $("#submit_frm_add_new_file_doc").click(function () {
        sendDocument();
    });

    /************************************************ chat ***********************************************************/
</script>