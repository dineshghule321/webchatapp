<?php
// Check Session
$errorCode = 0;
$errorMsg = "";
if (isset($_SESSION["loginError"])) {
    $errorMsg = $_SESSION["loginError"]["errMsg"];
    $errorCode = $_SESSION["loginError"]["errCode"];
}
if (!empty($_SESSION)) {
    if (isset($_SESSION["userLogin"])) {
        if ($_SESSION["userLogin"] == 1) {
            $rootViews = $rootView . "home/home.php";
            print("<script>window.location='" . $rootViews . "'</script>");
        }
    }

}

?>