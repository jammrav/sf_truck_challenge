<?php 
Class Database
{
    private static $user ;
    private static $host;
    private static $pass ;
    private static $db;

    public function __construct()
    {
        
    }
    public static function connect()
    {
        try {
            self::$user = "root";
            self::$host = "localhost";
            self::$pass = "";
            self::$db = "foodtruck"; 
            $conn = new mysqli(self::$host, self::$user, self::$pass, self::$db);
            mysqli_set_charset($conn,"utf8");
            return $conn;
        } catch (Exception $e) {
            return false;
        }
         
    }
}
?>