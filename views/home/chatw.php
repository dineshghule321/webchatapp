<?php
if(empty($_SESSION))
{
    session_start();
}
require_once "../layout/checkSession.php";

$fromUserID=$_SESSION['userId'];
?>
<div class="row m-b-0">
    <div class="col-lg-1">
        <ul class="sidebar white-text primary list-group flex-column m-b-0">
            <li class="text-center p-y-3">
                <img class="circle" src="http://via.placeholder.com/40X40">
            </li>
            <li class="text-center  menu active"> <i class="fa fa-inbox">    </i></li>
            <li class="text-center menu "> <i class="fa fa-paper-plane"></i></li>
            <li class="text-center menu "> <i class="fa fa-pencil-square"></i></li>
            <li class="text-center menu "> <i class="fa fa-trash-o"></i></li>
            <li class="text-center btn-more"> <i class="fa fa-ellipsis-v"></i> </li>
        </ul>
    </div>
    <div class="col-lg-4">
        <div id="custom-search-input">
            <div class="input-group col-md-12">
                <input type="text" class="  search-query form-control" name='search-query' id='search-query' placeholder="Search" />
                <span class="input-group-btn">
                                    <button class="btn colorMainBtn" type="button" onclick="getUserList()">
                                        <span class="">Search</span>
                                    </button>
                                </span>
            </div>
        </div>



        <div id="myContactList" class="myContactListScroll">

        </div>

        <a href="#" id="addNewContacts" class="btn--add circle primary  text-center white-text f-sz-20 depth-1 pull-right m-y-1">+</a>
        <div></div>
    </div>
    <div class="col-lg-7 chat-container bg-light-purple" id="userMessage">


    </div>
</div>

<script>
    $(document).ready(function() {
        getUserList();
        showChatSpace();
    });

    function showChatSpace()
    {
    var html="<div class='p-y-10 chat-right clearfix chatSpace'><h2>Chat Space</h2></div>";
        $("#userMessage").html(html);
    }

    $("#search-query").keyup(function(){
        getUserList();
    });

    $("#addNewContacts").click(function () {
        $("#contactDetailstab").trigger('click');
        $("#addContactButton").trigger('click');
    });

    function getUserList()
    {
        var user_name=$("#search-query").val();


                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url: "../../controllers/user/Contact.php",
                    beforeSend: function(){
                    },
                    complete: function(){
                    },
                    data: {
                        operation:"get_all_contact",user_name:user_name
                    },
                    success: function (data) {
                        $("#myContactList").html(data);
                    },
                    error: function () {
                        console.log("fail");
                    }
                });


    }


    function loadChat(fromUser,toUser)
    {
        $("#userMessage").load('../../controllers/chat/oneToOneChat.php?fromUser='+fromUser+'&toUser='+toUser);
        initialLoad(toUser);

    }


    /************************************************ chat ***********************************************************/


    // To create new comment/message on press icone to enter
    function submitChat()
    {
     var comments=$("#shout_message").val();
     var touserId=$("#toUserIdInput").val();
     var fromUserId="<?= $fromUserID; ?>";
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
                beforeSend: function() {},
                success: function(data) {
                    if (data["errCode"] == "-1") {
                        $("#shout_message").val(" ");
                        $("#shout_message").focus();
                        updateChatWindow();
                    } else {
                        console.log(data["errMsg"]);
                    }

                },
                complete: function(data) {},
                error: function() {
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

        var touserId=$("#toUserIdInput").val();
        var fromUserId="<?= $fromUserID; ?>";

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
                beforeSend: function() {

                },
                success: function(data) {
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
                error: function() {
                    console.log("fail");
                }
            });
    }
    setInterval(updateChatWindow, <?= $chatRefreshTime; ?>); //chek new msgs


    function initialLoad(touserId) {
        var userType = "me";
        var fromUserId="<?= $fromUserID; ?>";

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
            beforeSend: function() {

            },
            success: function(data) {
                if (data) {
                    var response = data;
                    $("#chatComments").append(response);

                    var elem = document.getElementById('chatComments');
                    elem.scrollTop = elem.scrollHeight;
                } else {
                    console.log("error to fetch updated messages");
                }
            },
            error: function() {
                console.log("fail");
            }
        });

    }

    /************************************************ chat ***********************************************************/
</script>