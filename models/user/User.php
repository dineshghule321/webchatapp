<?php

class User
{
    public $connection = "";

    function __construct()
    {
        $this->connection = new DB("dbSystem", 'FALSE');
    }


    function addUser($email, $password, $status)
    {
        $authToken = generateRandomString();
        $password = sha1Md5DualEncryption($password);
        $adminArr = array(
            "email_address" => $email,
            "passwordHash" => $password,
            "auth_token" => $authToken,
            "status" => $status,
            "creation_date" => NOWTime()
        );
        return $this->connection->insert("users", $adminArr);

    }

    function updateLoginTime($email)
    {
        return $this->connection->update("users", array("last_login_time" => NOWTime()), array("email_address" => "{$email}"));

    }

    function updateLastActivityTime($email)
    {
        return $this->connection->update("users", array("last_activity_time" => NOWTime()), array("email_address" => "{$email}"));
    }

    function updateLogoutTime($email)
    {
        return $this->connection->update("users", array("last_logout_time" => NOWTime()), array("email_address" => "{$email}"));

    }

    /**
     * ----------------------------------------------------------------------------------------
     * function used to validate user login
     * ----------------------------------------------------------------------------------------
     * @param $email
     * @param $hash
     * @return array
     */
    function validateLogin($email, $hash, $status)
    {
        return $this->connection->select("users", array(), array("email_address" => "{$email}", "passwordHash" => "{$hash}", "status" => $status));
    }

    /**
     *----------------------------------------------------------------------------------------
     * check user exists
     * ----------------------------------------------------------------------------------------
     * @param $email
     * @return array
     */
    function isUSerExists($email)
    {
        return $this->connection->select("users", array(), array("email_address" => "{$email}", "status" => 1));
    }

    function isContactUSerExists($email, $userid)
    {
        return $this->connection->select("contacts", array(), array("email_address" => "{$email}", "user_id" => $userid));
    }

    function getLastMsg($from, $userid)
    {
        $query = "SELECT msg,time FROM message where from_user_id IN ($from) AND to_user_id IN ($userid) ORDER BY id DESC LIMIT 1";
        return $this->connection->query($query);
    }

    /**
     * ----------------------------------------------------------------------------------------
     *change user password
     * ----------------------------------------------------------------------------------------
     * @param $email
     * @param $newp
     * @return array
     */
    function changePassword($email, $newp)
    {
        return $this->connection->update("users", array("passwordHash" => $newp), array("email_address" => "{$email}"));
    }

    /**
     * ----------------------------------------------------------------------------------------
     *Update user auth token
     * ----------------------------------------------------------------------------------------
     * @param $email
     * @param $token
     * @return array
     */
    function updateToken($email, $token)
    {
        return $this->connection->update("users", array("auth_token" => $token), array("email_address" => "{$email}"));
    }

    /**
     * ----------------------------------------------------------------------------------------
     * activate User
     * ----------------------------------------------------------------------------------------
     * @param $email
     * @param $hash
     * @return array
     */
    function activateUser($email, $hash)
    {
        $hash = sha1Md5DualEncryption($hash);

        return $this->connection->update("users", array("passwordHash" => $hash, "status" => 1), array("email_address" => "{$email}"));
    }

    /**
     * ----------------------------------------------------------------------------------------
     * change user profile picture
     * ----------------------------------------------------------------------------------------
     * @param $email
     * @param $imageName
     * @return array
     */
    function changeUserProfilePic($email, $imageName)
    {
        global $docRoot;
        $result = $this->connection->update("users", array("profile_pic_path" => $imageName), array("email_address" => "{$email}"));

        if (noError($result)) {

            $RootURLProPicNew = "{$docRoot}assets/uploads/profilePics/";
            $RootURLProPictOld = $RootURLProPicNew . $_SESSION["profile_pic"];
            if ($_SESSION["profile_pic"] != "admin.jpg") {
                unlink($RootURLProPictOld);
            }

            if ($_SESSION["profile_pic"] != "admin.jpg") {
                unset($_SESSION["profile_pic"]);
            }
            $_SESSION["profile_pic"] = $imageName;
            $errMsg = "Profile Picture Updated Successfully.";
            return set_error_stack(-1, $errMsg);
        } else {
            return set_error_stack(4);

        }

    }

    /**
     * ----------------------------------------------------------------------------------------
     * update User details
     * ----------------------------------------------------------------------------------------
     * @param $email
     * @param $fname
     * @param $lname
     * @param $address
     * @return array
     */
    function updateUser($email, $fname, $lname, $address)
    {
        return $this->connection->update("users", array("first_name" => $fname, "last_name" => $lname, "address" => $address), array("email_address" => "{$email}"));
    }

    function getUserId($email)
    {
        return $this->connection->select("users", array(), array("email_address" => "{$email}", "status" => 1));
    }

    function getContactDetails($id)
    {
        $result = $this->getUserDataByID($id);
        if (noError($result)) {
            $email = $result['data']['result']['0']['email_address'];
            return $this->connection->select("contacts", array(), array("email_address" => "{$email}"));
        }
    }

    function getUserDataByID($id)
    {
        return $this->connection->select("users", array(), array("user_id" => "{$id}", "status" => 1));
    }

    function lastSeen($time)
    {
        if ($time != "") {
            $seconds_ago = (time() - strtotime($time));

            if ($seconds_ago >= 31536000) {
                $seen = "Last Seen " . intval($seconds_ago / 31536000) . " years ago";
            } elseif ($seconds_ago >= 2419200) {
                $seen = "Last Seen " . intval($seconds_ago / 2419200) . " months ago";
            } elseif ($seconds_ago >= 86400) {
                $seen = "Last Seen " . intval($seconds_ago / 86400) . " days ago";
            } elseif ($seconds_ago >= 3600) {
                $seen = "Last Seen " . intval($seconds_ago / 3600) . " hours ago";
            } elseif ($seconds_ago >= 60) {
                $seen = "Last Seen " . intval($seconds_ago / 60) . " minutes ago";
            } else {
                $seen = "Last Seen less than a minute ago";
            }
            return $seen;
        } else {
            $seen = "";
            return $seen;
        }
    }

    function time_ago($datetime, $full = false)
    {

        if ($datetime != "") {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        } else {
            $string = "";
            return $string;

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

            $target_dir = $docRoot . "assets/sysImg/profile/";

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

    function updateProfilePic($file_name, $email)
    {
        return $this->connection->update("users", array("profile_pic_path" => $file_name), array("email_address" => "{$email}"));

    }
}