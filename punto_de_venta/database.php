<?php
class Database
{        
    private $_connection;
    private static $_instance;
    private $_host = "localhost";
    private $_username = "root";
    private $_password = "";
    private $_database = "ventas";
 
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if(!self::$_instance) // If no instance then make one
        { 
            self::$_instance = new self();
        }
        return self::$_instance;
    }
 
    // Constructor
    public function __construct()
    {
        $this->_connection = new mysqli($this->_host, $this->_username,$this->_password, $this->_database);
        // Error handling
        if(mysqli_connect_error())
        {
            trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(),E_USER_ERROR);
        }
    }
 
    // Magic method clone is empty to prevent duplication of connection
    private function __clone() { }
 
    // Get mysqli connection
    public function getConnection()
    {
        return $this->_connection;
    }
     
    public function get_data($sql)
    {
        $ret = array('STATUS'=>'ERROR','ERROR'=>'','DATA'=>array());
         
        $mysqli = $this->getConnection();
        $res = $mysqli->query($sql);
         
        if($res)
            $ret['STATUS'] = "OK";
        else
            $ret['ERROR'] = $mysqli->error;
         
        while($row = $res->fetch_array(MYSQLI_ASSOC))
        {
            $ret['DATA'][] = $row;
        }
        return $ret;
    }
     
    public function exec($sql)
    {
        $ret = array('STATUS'=>'ERROR','ERROR'=>'');
 
        $mysqli = $this->getConnection();
        $res = $mysqli->query($sql);
         
        if($res)
            $ret['STATUS'] = "OK";
        else
            $ret['ERROR'] = $mysqli->error;

        return $ret;
    }
 
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }