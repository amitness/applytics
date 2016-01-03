<?php

require_once(__DIR__.DIRECTORY_SEPARATOR.'config.php');

/**
 * Connect to MySQL Server
 */


 /**
  * A Database class
  * Performs CRUD operations
  *
  * @author      Deepak Adhikari <deeps.adhi@gmail.com>
  * @version     Stable 1.0.0
  */
class MySQL
{
    /**
     * Stores MySQL configuration
     *
     * @var array
     *   MySQL configuration
     */
     private $DB = array('HOST' => \Config\DB_HOST,
                         'USER' => \Config\DB_USER,
                         'PASS' => \Config\DB_PASS,
                         'NAME' => \Config\DB_NAME);

    /**
     * Stores a MySQL object
     *
     * @var object
     *   A MySQL object
     */
    private static $_db;

    /**
     * Protect from cloning
     */
    private function __clone() {}

    /**
     * Protect from wakeup
     */
    private function __wakeup() {}

    /**
     * Connects to MySQL
     */
    private function __construct(){
        $dsn = 'mysql:host='.$this->DB['HOST'].';dbname='.$this->DB['NAME'];
        try{
            @self::$_db = new PDO($dsn, $this->DB['USER'], $this->DB['PASS'],
                       array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            @self::$_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e){
            // If the DB connection fails, report error
        }
    }

    /**
     * Checks for a DB object and creates one if it's not created
     *
     * @return object $_db
     *   A MySQL object
     */
     public static function getConnection(){
        if(!self::$_db){
            new self();
        }
        return self::$_db;
    }
}
