<?php
require_once "../layout/header.php";
require_once "../../helpers/session.php"; //check session
?>
<div id="customError" class="centerDivErr"></div>
<div style="width:70%;margin: 0 auto;background-color:#f7f9fa;padding:20px">
    <form class="form-horizontal" name="loginFormName" id="loginFormId" action="../../controllers/user/Login.php"
          method="POST">
        <fieldset>
            <legend>Login</legend>
            <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name='user_email' id="inputEmail" placeholder="Email">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                <div class="col-lg-10">
                    <input type="password" class="form-control" name='user_password' id="inputPassword"
                           placeholder="Password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-4">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="button" id="submitLoginFrm" class="btn colorMainBtn">Login</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<script>


    $( document ).ready(function() {
        $('#customError').html('');
        var ecode="<?= isset($_SESSION['loginError']['errCode'])?$_SESSION['loginError']['errCode']:''; ?>";
        var emsg="<?= isset($_SESSION['loginError']['errMsg'])?$_SESSION['loginError']['errMsg']:''; ?>";

        if(ecode!="" && emsg!="")
        {
            if(ecode=="-1")
            {
                $('#customError').html(bsAlert('success', emsg));
            }else {
                $('#customError').html(bsAlert('danger', emsg));
            }
        }

    });
    $("#submitLoginFrm").click(function () {
        var emailHandle = $("#inputEmail").val();
        var password = $("#inputPassword").val();

        if (emailHandle != "" && password != "") {
            $("#loginFormId").submit();
        } else {
            $('#customError').html(bsAlert('danger', 'All fields are mandatory.'));
        }

    });
</script>
<?php
unset($_SESSION["loginError"]);
require_once "../layout/footer.php";
?>

