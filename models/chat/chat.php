<?php

class chat
{
    public $connection = "";

    function __construct()
    {
        $this->connection = new DB("dbSystem", 'FALSE');
    }

    function insertMsg($from_user_id, $to_user_id,$msg)
    {
        $Arr = array(
            "from_user_id" => $from_user_id,
            "to_user_id" => $to_user_id,
            "msg" => $msg,
            "time"=>NOWTime(),
            "meta"=>"$from_user_id,$to_user_id"
        );
        return $this->connection->insert("message", $Arr);

    }

    function getAllMsg($from_user_id,$to_user_id)
    {
        $query="SELECT * FROM message where from_user_id IN ($from_user_id,$to_user_id) AND to_user_id IN ($from_user_id,$to_user_id)";
        return $this->connection->query($query);

    }

    function getMsgById($from_user_id,$to_user_id,$lastMsgId)
    {

        if($lastMsgId!="")
        {
            if($lastMsgId=="0")
            {
                $query="SELECT * FROM message where from_user_id IN ($from_user_id,$to_user_id) AND to_user_id IN ($from_user_id,$to_user_id)";
            }else{
                $query="SELECT * FROM message where from_user_id IN ($from_user_id,$to_user_id) AND to_user_id IN ($from_user_id,$to_user_id) AND time > '{$lastMsgId}'";

            }
            return $this->connection->query($query);
        }else{
            $arr['errCode']=2;
            $arr['errMsg']="Last Msg ID required";
            return $arr;
        }

    }
}