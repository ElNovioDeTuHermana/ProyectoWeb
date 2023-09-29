<?php

class Database{
    private $host;
    private $db;
    private $user;
    private $password;

    public function __construct()
    {
        $this->host = constant('HOST');
        $this->db = constant('DB');
        $this->user = constant('USER');
        $this->password = constant('PASSWORD');

        
    }

    function connect()
    {
        try{
            $conexion = new PDO("sqlsrv:server={$this->host};database={$this->db}", "{$this->user}", "{$this->password}");

            return $conexion;
        }
        catch(PDOException  $e){
            echo "Error: {$e->getMessage()}";
        }
    }
}

?>