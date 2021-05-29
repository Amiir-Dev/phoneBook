<?php
class DBConnection extends PDO
{
    private static $host = '127.0.0.1';
    private static $dbName = 'phoneBook';
    private static $username = 'root';
    private static $pass = '';

    public static function connect()
    {
        return new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbName, self::$username, self::$pass);
    }
}
