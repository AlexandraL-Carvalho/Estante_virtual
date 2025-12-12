<?php

class Database {
    private $driver;
    private $host;
    private $dbname;
    private $username;    
    private $password;

    private $con;

    function __construct(){

        $this->driver="mysql";
        $this->host="localhost";
        $this->dbname="estante_virtual";
        $this->username="alexandra";
        $this->password="1254";
    }

    function getConexao() {
        try {
            $this->con = new PDO(
                "$this->driver: host=$this->host; dbname=$this->dbname",
                $this->username,
                $this->password
            );

            $this-> con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            return $this->con;


        } catch (Exception $e) {
            echo $e ->getMessage();
        }
    }
}