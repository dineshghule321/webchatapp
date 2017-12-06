<?php

/**
 * Created by PhpStorm.
 * User: dinesh
 * Date: 5/9/17
 * Time: 5:59 PM
 */
class Contact
{
    /**
     * @var DB|string
     */
    public $connection = "";

    /**
     * Contact constructor.
     */
    function __construct()
    {
        $this->connection = new DB("dbSystem", 'FALSE');
    }

    /**
     * ----------------------------------------------------------------------------------------
     * This function insert/save contact details in contact database
     * ----------------------------------------------------------------------------------------
     * @param $email
     * @param $fname
     * @param $mname
     * @param $lname
     * @param $MobileNo
     * @param $landlineNo
     * @param $notes
     * @param $photo_path
     * @param $user_id
     * @return array
     */
    function submitContactData($email, $fname, $lname, $MobileNo, $photo_path, $user_id)
    {
        $insertArray = array(
            "email_address" => $email,
            "first_name" => $fname,
            "last_name" => $lname,
            "moblie_number" => $MobileNo,
            "photo_path" => $photo_path,
            "user_id" => $user_id,
        );
        return $this->connection->insert("contacts", $insertArray);
    }

    /**
     * ----------------------------------------------------------------------------------------
     *This function used to validate land line Phone
     * ----------------------------------------------------------------------------------------
     * @param $string
     * @return bool
     */
    function validatePhone($string)
    {
        $numbersOnly = preg_replace("[^0-9]", "", $string);
        $numberOfDigits = strlen($numbersOnly);
        if ($numberOfDigits == 7) {
            return true;
        } else {
            return false;
        }
    }

    function getAllContact($user_id, $name = "")
    {
        if ($name != "") {
            $query = "SELECT * FROM contacts where first_name LIKE '%$name%' OR last_name LIKE '%$name%' AND user_id=$user_id AND email_address!='{$_SESSION['userEmail']}'";
        } else {
            $query = "SELECT * FROM contacts where user_id=$user_id AND email_address!='{$_SESSION['userEmail']}'";
        }

        return $this->connection->query($query);
    }

    function getContactDetailsByEmail($email)
    {
        $query = "SELECT * FROM contacts where email_address='{$email}'";
        return $this->connection->query($query);
    }

    /**
     * ----------------------------------------------------------------------------------------
     *This function used to delete contact from database
     * ----------------------------------------------------------------------------------------
     * @param $contact_id
     * @return array
     */
    function deleteContact($contact_id)
    {
        return $this->connection->delete("contacts", "id=$contact_id");
    }

    /**
     * ----------------------------------------------------------------------------------------
     *This function used to update contact details
     * ----------------------------------------------------------------------------------------
     * @param $contact_id
     * @param $firstname
     * @param $middle_name
     * @param $lastname
     * @param $mobileno
     * @param $landLineNo
     * @param $email
     * @param $note
     * @param $file_name
     * @return array
     */
    function updateContact($contact_id, $firstname, $lastname, $mobileno, $file_name)
    {
        $adminArr = array(
            "first_name" => $firstname,
            "last_name" => $lastname,
            "moblie_number" => $mobileno,
        );
        if ($file_name != "") {
            $adminArr["photo_path"] = $file_name;
        }
        return $this->connection->update("contacts", $adminArr, array("id" => "{$contact_id}"));
    }

    /**
     * ----------------------------------------------------------------------------------------
     *This function used to apply common server side validations on contact app
     * ----------------------------------------------------------------------------------------
     * @param $email
     * @param $fname
     * @param $lname
     * @param $moblie_number
     * @param $landline_number
     * @param $fileId
     */
    function commonValidations($email, $fname, $lname, $moblie_number, $fileId)
    {
        if ($email != "") {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $returnArr["errCode"] = "1";
                $returnArr["errMsg"] = "Please Enter Valid email Address.";
                echo json_encode($returnArr, true);
                exit;
            }
        }

        if ($fname == "") {
            $returnArr["errCode"] = "1";
            $returnArr["errMsg"] = "First Name can not be blank.";
            echo json_encode($returnArr, true);
            exit;
        }

        if ($lname == "") {
            $returnArr["errCode"] = "1";
            $returnArr["errMsg"] = "Last Name can not be blank.";
            echo json_encode($returnArr, true);
            exit;
        }

        if ($moblie_number != "") {
            $valMob = preg_match('/^[0-9]{10}+$/', $moblie_number);
            if (!$valMob) {
                $returnArr["errCode"] = "1";
                $returnArr["errMsg"] = "Please Enter Valid Mobile Number.";
                echo json_encode($returnArr, true);
                exit;
            }

        }

        global $docRoot;
        if ($_FILES["{$fileId}"]["name"] != "") {
            $file_tmp_name = $_FILES["tmp_name"];
            $file_Size = $_FILES["size"];
            $file_name = $_FILES["name"];


            $file_ext = strtolower(end(explode('.', $_FILES["{$fileId}"]['name'])));
            $file_name = strtotime(date("d-m-y h:i:s a")) . "." . $file_ext;

            $target_dir = $docRoot . "assets/images/";

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

}