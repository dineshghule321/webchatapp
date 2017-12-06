<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once "../layout/header.php";
require_once "../../helpers/session.php"; //check session

if (isset($_SESSION['signupError'])) {
    $error = $_SESSION['signupError']['errMsg'];
} else {
    $error = "";
}
?>
<div id="customError" class="centerDivErr"></div>
<div class='centerDiv'>
    <form class="form-horizontal" name="signupFormName" id="signupFormId" action="../../controllers/user/signup.php"
          method="POST">
        <fieldset>
            <legend>Signup</legend>
            <div class="form-group">
                <div class=" col-lg-10 col-sm-4 col-md-4 col-lg-5 m-0">
                    <label for="emailAddress">Email Address</label>
                    <input type="email" class="form-control" id="emailAddress" name="emailAddress"
                           placeholder="Enter Email Address" formnovalidate>
                </div>
            </div>

            <div class="form-group">
                <div class=" col-lg-10 col-sm-4 col-md-4 col-lg-5 m-0">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Enter Password">
                </div>

                <div class="col-lg-10 col-sm-4 col-md-4 col-lg-5 m-0">
                    <label for="cpassword">Confirm Password</label>
                    <input type="password" class="form-control" id="cpassword" name="cpassword"
                           placeholder="Enter Confirm Password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-6">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="button" id="submitSignupFrm" class="btn colorMainBtn">Signup</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<script>

    $(document).ready(function () {
        $('#customError').html('');
        var err = "<?= $error; ?>";
        if (err != "") {
            $('#customError').html(bsAlert('danger', err));
        }

    });

    $("#submitSignupFrm").click(function () {
        var emailAddress = $("#emailAddress").val();
        var password = $("#password").val();
        var cpassword = $("#cpassword").val();

        if (emailAddress != "" && password != "" && cpassword != "") {

            if (password != cpassword) {
                $('#customError').html(bsAlert('danger', 'Password and Confirm password mismatch.'));
            } else {
                $("#signupFormId").submit();
            }

        } else {
            $('#customError').html(bsAlert('danger', 'All fields are mandatory.'));
        }

    });

    function showError(error) {
        $("#printError").html(error);
        $("#err_signup_response").show();
    }

    function hideError() {
        $("#printError").html('');
        $("#err_signup_response").hide();
    }

</script>
<?php
unset($_SESSION["signupError"]);
require_once "../layout/footer.php";
?>

