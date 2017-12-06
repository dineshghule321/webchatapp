<?php
if (!isset($_SESSION)) {
    session_start();
}
header('Content-Type: text/html; charset=utf-8');
$docrootpath = __DIR__;
$docrootpath = explode('/webchatapp', $docrootpath);
$docrootpath = $docrootpath[0] . "/webchatapp/";

require_once("{$docrootpath}config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?= $rootUrl; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $rootUrl; ?>assets/css/custom.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= $rootUrl; ?>assets/css/app.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $.ajaxSetup({ cache: false });
        function session_checking() {
            var root = "<?php echo $rootUrl; ?>";
            $.post(root + "controllers/user/checkSessionTimeout.php", function (data) {
                if (data == "-1") {
                    window.location = root + "index.php";
                }

            });
        }

        var validateSession = setInterval(session_checking, <?php echo $checkSession; ?>); // microsecond of 600 second=600000

    </script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid primary">
        <div class="navbar-header ">
            <button type="button" class="navbar-toggle collapsed " data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $rootUrl; ?>">Chat Book</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <?php
                if (isset($_SESSION["userLogin"])) {
                    echo '<li><a href="' . $rootUrl . 'controllers/user/Logout.php">Logout</a></li>';
                } else {
                    $page = basename($_SERVER['PHP_SELF']);
                    if ($page == "login.php") {
                        $place = "Signup";
                        $link = $rootUrl . 'views/user/signup.php';
                    } else {
                        $place = "Login";
                        $link = $rootUrl . 'views/user/login.php';
                    }
                    echo '<li><a href="' . $link . '">' . $place . '</a></li>';
                }
                ?>
            </ul>
        </div>

    </div>
</nav>





