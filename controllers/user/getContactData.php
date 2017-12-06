<?php

session_start();

//start config
require_once('../../config/config.php');
require_once("{$docRoot}models/pagination/Pagination.php");

$Pagination = new Pagination();
$tableName = "contacts";
$orderBy = "id";
$filtersArr = array();
$resultsData = array();


$search_email = cleanQuery($_POST["search_email"]);
$filtersArr["user_id"] = $_SESSION['userId'];
if ($search_email != "") {
    $filtersArr["first_name"] = array("LIKE", "%$search_email%");
    $filtersArr["last_name"] = array("LIKE", "%$search_email%");
}


$search_phone = cleanQuery($_POST["search_phone"]);
if ($search_phone != "") {
    $filtersArr["moblie_number"] = array("LIKE", "%$search_phone%");
}


$limit = cleanQuery($_POST["limit"]);

$resultsData = $Pagination->getPaginationDataForTable($limit, $tableName, $filtersArr, $orderBy);
$results = $resultsData["result"];
$lastpage = $resultsData["lastpage"];
$page_number = $resultsData["page_number"];
$get_total_rows = $resultsData["get_total_rows"];
$item_per_page = $resultsData["item_per_page"];

$bugStatus = $filtersArr["bug_status"];
?>

<table class="table table-bordered table-hover ">
    <thead>
    <tr>
        <th style="background-color: lightblue;width:10%">Photo</th>
        <th style="background-color: lightblue;width:20%">Name</th>
        <th style="background-color: lightblue;width:20%">Email</th>
        <th style="background-color: lightblue;width:20%">Contact</th>
        <th style="background-color: lightblue;width:10%" class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $count = ($page_number - 1) * $item_per_page;
    if ($get_total_rows == 0) { ?>
        <tr>
            <td style="text-align: center" colspan="5">No Data Found</td>
        </tr>
    <?php } else {
        foreach ($results as $value) { ?>
            <tr>
                <td>
                    <img class='circle' src="<?= $rootUrlImages . $value['photo_path'] ?>" alt="Contact Photo"
                         height="100" width="100">
                </td>
                <td>
                    <?= $value['first_name'] . " " . $value['last_name'] ?>
                </td>
                <td class="col-355  wrd-wrp_brk-wrd">
                    <?php echo $value['email_address'] ?>
                </td>
                <td>
                    <?php echo $value['moblie_number']; ?>
                </td>

                <td class="text-center">
                    <a href="#" class="btn colorMainBtn btn-xs" data-toggle="modal" data-target="#editContactModal"
                       onclick="updateContact('<?= $value['id']; ?>','<?= $value['first_name']; ?>','<?= $value['last_name']; ?>','<?= $value['moblie_number']; ?>','<?= $value['email_address']; ?>')">Edit</a>
                    <a href="#" class="btn colorMainBtn btn-xs"
                       onclick="deleteContact('<?= $value['id']; ?>')">Delete</a>
                </td>

            </tr>
        <?php }
    } ?>
    </tbody>
</table>


<?php

$filtersArrJ["search_email"] = cleanQuery($_POST["search_email"]);
$filtersArrJ["search_phone"] = cleanQuery($_POST["search_phone"]);
$Pagination->getPaginationDataJs($lastpage, $page_number, $limit, $filtersArrJ, "getPaginationContactList");
?>
<script>
    $("#LimitedResult").change(function () {
        getContactList();
    });

    function updateContact(id, f_name, l_name, moblie_number, email_address) {
        $("#err_frmSubmit_response_edit").html("");
        $("#edit_id").val(id);
        $("#edit_first_name").val(f_name);
        $("#edit_last_name").val(l_name);
        $("#edit_moblie_number").val(moblie_number);
        $("#edit_inputEmail").val(email_address);
    }

    $("#submit_frm_edit_contact").click(function () {
        updateContactData();
    });

    function updateContactData() {
        $("#err_frmSubmit_response_edit").html("");

        var formData = new FormData($('#frm_edit_contact')[0]);
        formData.append('operation', 'update_contact');

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../../controllers/user/Contact.php",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (data) {

                if (data["errCode"] != "-1") {

                    $("#err_frmSubmit_response_edit").html(data["errMsg"]);
                } else if (data["errCode"] == "-1") {

                    document.getElementById("frm_edit_contact").reset();
                    $("#errors").html(bsAlert("success", data["errMsg"]));
                    getContactList();
                    $("#editContactModal").modal('hide');
                }
            },
            error: function () {
                console.log("fail");
            }
        });
    }
</script>



