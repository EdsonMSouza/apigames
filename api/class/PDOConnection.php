<?php
/**
*   PDO Connection Class
*
*   PHP Doc: https://www.php.net/manual/pt_BR/pdo.setattribute.php
*
*   @author Edson Melo de Souza
*   @since 2019
*
*/

class PDOConnection
{
    # Connection instance
    protected static $db;

    # PDO config vars - configurações da conexão com o banco de dados
    private static string $db_type = 'mysql';
    private static string $db_hostname = 'localhost';
    private static string $db_name = '';
    private static string $db_user = '';
    private static string $db_password = '';

    # Constructor
    /**
     * @var null
     */
    private $conn;

    function __construct(){
        try {
            self::$db = new PDO(
                self::$db_type . ":host=" .
                self::$db_hostname . ";dbname=" .
                self::$db_name, 
                self::$db_user, 
                self::$db_password
            );
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_PERSISTENT, FALSE);
            self::$db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf-8");
            self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            self::$db->exec("SET NAMES utf8");
            
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    # Crate a new connection if not exist
    public static function connection()
    {
        if (!self::$db) {
            new PDOConnection();
        }
        # Return connection
        return self::$db;
    }

    # Close connection
    function __destruct() {
        try {
            $this->conn = null;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
