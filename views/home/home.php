<?php
require_once "../layout/header.php";
require_once "../layout/checkSession.php";
?>
<div style="width:90%;margin: 0 auto;background-color:#f7f9fa;padding:20px">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#contactTab" id="contactDetailstab" data-toggle="tab" aria-expanded="true">Contact Data</a></li>
        <li class=""><a href="#chatTab" data-toggle="tab" aria-expanded="true">Chat Window</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="contactTab">
            <br/>
            <div id="errors" style="margin-bottom: 15px"></div>
            <form class="">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">Name:</label>
                            <input type="email" class="form-control" id="search_email" placeholder="Search by Contact Name">
                        </div>


                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pwd">Phone Number:</label>
                            <input type="text" class="form-control" id="search_phone" placeholder="Search by Phone Number">
                        </div>


                    </div>

                    <div class="col-md-4">


                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="pwd"></label>
                            <a href="#" class="btn colorMainBtn form-control" id="addContactButton" data-toggle="modal" data-target="#addNewContactModal">Add New Contact</a>
                        </div>

                    </div>
                </div>

            </form>

            <div id="detailedTable">

            </div>
        </div>
        <div class="tab-pane fade innerSpace" id="chatTab">
           <?php include('chatw.php'); ?>
        </div>
    </div>
</div>


<div class="modal fade" role="dialog" id="addNewContactModal">
    <div class="modal-dialog" style="width:55%">
        <div class="modal-content">
            <form class="form-horizontal" name="frm_add_new_contact" id="frm_add_new_contact" enctype="multipart/form-data" method="POST">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title mainColor">Add New Contact</h4>
            </div>
            <div class="modal-body">

                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name='inputEmail' id="inputEmail" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="col-lg-2 control-label">First Name</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
                            </div>
                        </div>

                    <div class="form-group">
                        <label for="last_name" class="col-lg-2 control-label">Last Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="moblie_number" class="col-lg-2 control-label">Mobile Number</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="moblie_number" id="moblie_number" placeholder="Mobile Number">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="photo_path" class="col-lg-2 control-label">Attach Photo</label>
                        <div class="col-lg-10">
                            <input type="file" class="form-control" name="photo_path" id="photo_path" >
                        </div>
                    </div>


                <div class="form-group has-error">
                    <div class="col-lg-10 pull-right">
                        <span id="err_frmSubmit_response" class="help-block"></span>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="submit_frm_add_new_contact" class="btn colorMainBtn">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="editContactModal">
    <div class="modal-dialog" style="width:55%">
        <div class="modal-content">
            <form class="form-horizontal" name="frm_edit_contact" id="frm_edit_contact" enctype="multipart/form-data" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title mainColor">Edit Contact</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name='edit_inputEmail' id="edit_inputEmail" placeholder="Email" disabled>
                            <input type="hidden" class="form-control" name='edit_id' id="edit_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="col-lg-2 control-label">First Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="edit_first_name" id="edit_first_name" placeholder="First Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="col-lg-2 control-label">Last Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="edit_last_name" id="edit_last_name" placeholder="Last Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="moblie_number" class="col-lg-2 control-label">Mobile Number</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="edit_moblie_number" id="edit_moblie_number" placeholder="Mobile Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="photo_path" class="col-lg-2 control-label">Attach Photo</label>
                        <div class="col-lg-10">
                            <input type="file" class="form-control" name="edit_photo_path" id="edit_photo_path" >
                        </div>
                    </div>

                    <div class="form-group has-error">
                        <div class="col-lg-10 pull-right">
                            <span id="err_frmSubmit_response_edit" class="help-block"></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="close_update_modal" data-dismiss="modal">Close</button>
                    <button type="button" id="submit_frm_edit_contact" class="btn colorMainBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    $(document).ready(function() {
        getContactList();
    });

    $( "#submit_frm_add_new_contact" ).click(function() {
            submitContactData();
    });

    $("#inputEmail,#first_name,#last_name,#moblie_number").keyup(function(){
        $("#err_frmSubmit_response").html("");
    });

    $("#search_email,#search_phone").keyup(function(){
        getContactList();
        $("#errors").html("");
    });


    function submitContactData()
    {
        $("#err_frmSubmit_response").html("");

        var formData = new FormData($('#frm_add_new_contact')[0]);
        formData.append('operation','submit_new_contact');

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../../controllers/user/Contact.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function (data) {

                if(data["errCode"]!="-1")
                {

                    $("#err_frmSubmit_response").html(data["errMsg"]);
                }else if(data["errCode"]=="-1")
                {
                    $("#errors").html(bsAlert("success",data["errMsg"]));
                    document.getElementById("frm_add_new_contact").reset();
                    $("#addNewContactModal").modal('hide');
                    getContactList();
                    getUserList();
                }
            },
            error: function () {
                console.log("fail");
            }
        });
    }

    function getContactList()
    {
        var limit=$("#LimitedResult").val();
        var search_email=$("#search_email").val();
        var search_phone=$("#search_phone").val();

        if(limit==undefined)
        {
            limit=5;
        }
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "../../controllers/user/getContactData.php",
            data: {
                limit:limit,search_email:search_email,search_phone:search_phone
            },
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function (data) {
                $("#detailedTable").html("");
                $("#detailedTable").html(data);
            },
            error: function () {
                console.log("fail");
            }
        });

    }
    function getPaginationContactList(search_email,search_phone,limit,pageno)
    {
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "../../controllers/user/getContactData.php",
            beforeSend: function(){
            },
            complete: function(){
            },
            data: {
                search_email:search_email,search_phone:search_phone,limit:limit,pageno:pageno
            },
            success: function (data) {
                $("#detailedTable").html("");
                $("#detailedTable").html(data);
            },
            error: function () {
                console.log("fail");
            }
        });
    }

    function deleteContact(contact_id)
    {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../../controllers/user/Contact.php",
            beforeSend: function(){
            },
            complete: function(){
            },
            data: {
                operation:"delete_contact",contact_id:contact_id
            },
            success: function (data) {

               if(data["errCode"]=="-1")
                {
                    $("#errors").html(bsAlert("success",data["errMsg"]));
                    getContactList();
                }else {
                   $("#errors").html(bsAlert("danger",data["errMsg"]));
               }
            },
            error: function () {
                console.log("fail");
            }
        });
    }

</script>
<?php
require_once "../layout/footer.php";
?>

