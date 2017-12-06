<?php


/**
 * Class DB
 */
class DB
{
    /**
     * DB Host Array
     * @var array
     */
    private $dbHost=array(
        "db_host_primary" => "localhost",
        "db_host_secondary" => "localhost"
    );

    /**
     * System Database Array
     * @var array
     */
    private $dbSystem = array(
        "db_name" => "contact_book",
        "db_user" => "root",
        "db_password" => "",
        "db_port" => "3306"
    );


    /**
     * @var string
     */
    public $connection = "";
    /**
     * @var string
     */
    public $errorMap = "";

    /**
     * this function fetch database credential for particular database by name of case
     * @param $database
     * @return mixed
     */
    public function getDatabaseCredential($database)
    {
        $db_array["host"] = $this->dbHost["db_host_primary"];
        $db_array["db_host_secondary"] = $this->dbHost["db_host_secondary"];


        switch ($database) {
            case "dbSystem": //if request for dbSystem database connection
                $db_array["user"] = $this->dbSystem["db_user"];
                $db_array["password"] = $this->dbSystem["db_password"];
                $db_array["database"] = $this->dbSystem["db_name"];
                $db_array["port"] = $this->dbSystem["db_port"];
                return $db_array;
                break;

            default :
                $error = "Database Connection Error";
        }
    }

    /**
     * constructor initialise database connection
     * DB constructor.
     * @param string $database
     * @param string $is_persiatant
     */
    function __construct($database = "NULL", $is_persiatant = "NULL")
    {
        ini_set('display_errors', 0);
        error_reporting(0);

        $credential = $this->getDatabaseCredential($database);
        $conn = $this->getDBConnection($credential, $is_persiatant);
        $this->connection = $conn["data"];
    }

    /**
     * this magic method don't allow object cloning
     * @return bool
     */
    private function __clone()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function __wakeup()
    {
        return false;
    }

    /**
     * this function connect to database using pdo and return connection object
     * @param $credential
     * @param $is_persiatant
     * @return array
     */
    private function getDBConnection($credential, $is_persiatant)
    {
        $host = $credential["host"]; //get credential out of array
        $user = $credential["user"];
        $password = $credential["password"];
        $database = $credential["database"];
        $port = $credential["port"];
        $host_secondary = $credential["db_host_secondary"];

        if ($is_persiatant == "TRUE") {
            $persiatant = array(PDO::ATTR_PERSISTENT => TRUE);
        } else {
            $persiatant = array(PDO::ATTR_PERSISTENT => FALSE);
        }

        try {
            $db = new PDO("mysql:host={$host};port={$port};dbname={$database}", $user, $password, $persiatant);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return set_error_stack(-1,"",$db);
        } catch (PDOException $e) {
            try {
                $db = new PDO("mysql:host={$host_secondary};port={$port};dbname={$database}", $user, $password, $persiatant);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return set_error_stack(-1,"",$db);
            } catch (PDOException $e) {
                return set_error_stack(1,'Connection failed: ' . $e->getMessage());
            }
        }

    }

    /**
     * function used to run query on database object
     * @param $query
     * @param array $parameters
     * @return array
     */
    public function query($query, array $parameters = array())
    {
        $return_array = array();
        $result_array = array();
        $words = str_word_count($query, 1);
        try {
            $stmt = $this->connection->prepare($query);

            if (!empty($parameters)) {
                $result = $stmt->execute($parameters);
            } else {
                $result = $stmt->execute($parameters);
            }
        }catch(PDOException $e)
        {
            echo $errorMsg = 'Error on line '.$e->getLine().' in '.$e->getFile()
                .': <b>'.$e->getMessage();die;
            return $return_array=set_error_stack(28,$errorMsg);
        }


        if ($result == TRUE) {

            switch (strtoupper($words[0])) {
                case "INSERT" :
                    $result_array['last_insert_id'] = $this->connection->lastInsertId();
                    break;
                case "DELETE" :
                    $result_array['affected_rows'] = $stmt->rowCount();
                    break;
                case "UPDATE" :
                    $result_array['affected_rows'] = $stmt->rowCount();
                    break;
                case "SELECT" :
                    if (!empty($result)) {
                        $result_array['result'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $result_array['count'] = $stmt->rowCount();;
                    } else {
                        $result_array['count'] = 0; // empty result
                    }
                    break;
            }

            $return_array=set_error_stack(-1,"Query Executed Successfuly",$result_array);
        } else {

            $return_array=set_error_stack(2);
        }
        return $return_array;
    }

    /**
     * this function used to fetch data from database
     * @param $table_name
     * @param array $columns
     * @param string $where
     * @param string $limit
     * @param string $offset
     * @param array $orderBy
     * @param array $groupBy
     * @param string $having
     * @param string $join
     * @return array
     */
    public function select($table_name, array $columns = array(), $where = '', $limit = '', $offset = '', array $orderBy = array(), array $groupBy = array(), $having = '', $join = '')
    {
        /*$columns  array of columns name
          array("column1",'column2','column3')
        /* $orderBy input associative array two value column name and ACS,DESC
           $orderBy["column"]=array("type"=>"asc/desc");

         /* $groupBy input array
                $groupBy=array("column1","column2");
        */

        $query = "SELECT ";
        if (!empty($columns) && isset($columns)) {
            if (is_array($columns)) {
                $i = 0;
                foreach ($columns as $key => $value) {
                    $query .= " $value " . ((++$i === count($columns)) ? ("") : (" , "));
                }
            } else {
                $query .= " $columns ";
            }
        } else {
            $query .= " * ";
        }
        $query .= " FROM `$table_name` ";

        if (!empty($join)) {
            $join_query = " ";
            if (is_array($join) && isset($join[0]) && is_array($join[0])) {
                foreach ($join as $single_join) {
                    $join_query .= " " . $single_join['type'] . " JOIN " . $single_join['table'] . " ON " . $single_join['relation'];
                }
            } else {
                $join_query = " " . $join . " ";
            }
            $query .= $join_query;
        }
        if (!empty($where) && isset($where)) {
            if (is_array($where)) {
                $i = 0;
                $query .= " WHERE ";
                $parameters[] = $this->get_type_for_bind_param($where);
                foreach ($where as $key => $where_column) {
                    $parameters[] = &$where[$key];
                    $query .= " `$key` =  ?" . ((++$i === count($where)) ? ("") : (" AND "));
                }

                unset($parameters[0]);
                $parameters = array_values($parameters);

            } else {
                $query .= " WHERE " . $where;
            }
        }

        if (!empty($groupBy)) {
            $query .= " GROUP BY";

            foreach ($groupBy as $column) {
                $query .= " {$column},";
            }
            $query = rtrim($query, ',');
        }

        if (!empty($orderBy)) {
            $query .= " ORDER BY";

            foreach ($orderBy as $columnKey => $Data) {
                $query .= " {$columnKey} {$Data['type']} ,";
            }
            $query = rtrim($query, ',');
        }


        if (is_numeric($limit)) {
            $query .= " LIMIT " . $limit . " " . (is_numeric($offset) ? "," . $offset : "");
        }

        if (!empty($parameters)) {
            return $this->query($query, $parameters);
        } else {
            return $this->query($query);
        }


    }


    /**
     * this function used to insert data in database
     * @param $table_name
     * @param array $values
     * @return array
     */
    function insert($table_name, array $values)
    {
        if (isset($values) && !empty($values) && is_array($values)) {
            $query = " INSERT INTO `$table_name` ( ";
            $value_string = "";
            $i = 0;
            $j = 0;
            $parameters[] = $this->get_type_for_bind_param($values);
            foreach ($values as $key => $value) {
                $query .= " `$key` " . ((++$i === count($values)) ? (" ) VALUES ( ") : (", "));
                $parameters[] = &$values[$key];
                $value_string .= " ? " . ((++$j === count($values)) ? (" ) ") : (" , "));
            }
            $query = $query . $value_string;

            unset($parameters[0]);
            $parameters = array_values($parameters);

            return $this->query($query, $parameters);
        } else {
            return set_error_stack(2);
        }
    }

    /**
     * this function used to update data in database
     * @param $table_name
     * @param array $values
     * @param $where
     * @return array
     */
    function update($table_name, array $values, $where)
    {
        if (!empty($values) && isset($values) && is_array($values) && !empty($where) && isset($where)) {
            $query = " UPDATE `$table_name` SET ";
            $i = 0;
            $parameters1[] = $this->get_type_for_bind_param($values);

            foreach ($values as $key => $value) {
                $parameters1[] = &$values[$key];
                $query .= " `$key` = ? " . (++$i === count($values) ? ("") : (", "));
            }

            unset($parameters1[0]);
            $parameters1 = array_values($parameters1);

            $parameters2=array();

            $query .= " WHERE ";
            if (is_array($where)) {
                $i = 0;
                $parameters2[] = $this->get_type_for_bind_param($where);
                foreach ($where as $key => $where_value) {
                    $parameters2[] = &$where[$key];
                    $query .= " `$key` = ? " . ((++$i === count($where)) ? ("") : (" AND "));
                }

                unset($parameters2[0]);
                $parameters2 = array_values($parameters2);

            } else {
                $query .= "" . $where;
            }


            $parameters=array_merge($parameters1,$parameters2);

            return $this->query($query, $parameters);

        } else {
            return set_error_stack(2);
        }
    }


    /**
     * this function used to delete data in database
     * @param $table_name
     * @param $where
     * @return array
     */
    function delete($table_name, $where)
    {
        if (!empty($where) && isset($where)) {
            $query = " DELETE FROM `$table_name` WHERE ";
            if (is_array($where)) {
                $i = 0;
                $parameters[] = $this->get_type_for_bind_param($where);
                foreach ($where as $key => $where_value) {
                    $parameters[] = &$where[$key];
                    $query .= " `$key` = ? " . ((++$i === count($where)) ? ("") : (" AND "));
                }

                unset($parameters[0]);
                $parameters = array_values($parameters);

            } else {
                $query .= " " . $where;
            }

            if (!empty($parameters)) {
                return $this->query($query, $parameters);
            } else {
                return $this->query($query);
            }

        } else {
            return set_error_stack(2);
        }
    }

    /**
     * this function used to bind query parameters
     * @param $values
     * @return bool|string
     */
    function get_type_for_bind_param($values)
    {
        $type_string = "";
        foreach ($values as $element) {
            if (is_array($element)) {
                return false;
            } else if (is_string($element)) {
                $type_string .= "s";
            } else if (is_int($element)) {
                $type_string .= "i";
            } else if (is_double($element)) {
                $type_string .= "d";
            } else if (is_object($element)) {
                return false;
            }
        }
        return $type_string;
    }

    /**
     * start transaction
     * @return mixed
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * commit transaction
     * @return mixed
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * rollback transaction
     * @return mixed
     */
    public function rollback()
    {
        return $this->connection->rollback();
    }

    /**
     * destroy the connection object
     */
    public function __destruct()
    {
        $this->connection = "";
    }

}

?>