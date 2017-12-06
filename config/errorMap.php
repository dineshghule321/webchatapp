<?php

/**
 * @param $error_code can be any code mentioned in $error_code_array declared above
 * @param string $message is string that needs to be sent with response of this function
 * if message is not defined then it will refer error_code_array and if it contains a string then
 * it will be appended to existing string associated with the code
 * @param array $data is an array that needs to be sent with response
 * @return array
 * this function returns an array containing error_code, message and data array
 * this function is returned as response to every api request
 */
function set_error_stack($error_code, $message = "", $data = [])
{

    $error_code_array = array(
        -2 => "nonce error",
        -1 => "",
        1 => "Error in creating database connection.",
        2 => "Error in query execution."
    );

    if ($error_code == -1) {
        if ($message == "") {
            $message = "Success";
        }
    }

    $response = array(
        'errCode' => $error_code,
        'errMsg' => (isset($error_code_array[$error_code]) ? $error_code_array[$error_code] : $error_code_array[0]) . ($message != "" ? " " . $message : "")
    );

    if (!empty($data) || $data == 0) {
        $response['data'] = $data;
    }

    return $response;
}

function noError($resArray)
{
    $noError = false;
    if ($resArray["code"] == -1 || $resArray["errCode"] == -1) {
        $noError = true;
    }
    return $noError;
}

?>

