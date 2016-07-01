<?php

class DB
{
    /**
     * @var \PDO
     */
    static private $conn;

    private function __construct() {}

    /**
     * @return \PDO
     */
    static public function getConnection() {
        if(static::$conn == null) {
            static::$conn = new \PDO("pgsql:host=localhost;dbname=scotchbox", "root", "root");
            static::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return static::$conn;
    }
}