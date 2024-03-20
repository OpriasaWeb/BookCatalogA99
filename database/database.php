<?php

class Database{
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $port;
    private $dbh;
    private $stmt;
    private $error;

    public function __construct($host, $dbname, $port, $user, $pass)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;

        // Create a new PDO instanace  
        try{
            $this->dbh = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname, $this->user, $this->pass);
        }
        
        // Catch any errors  
        catch (PDOException $e){
            $this->error = $e->getMessage();
        }
    }

    public function query($query)
    {
      $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type))
        {
            switch (true)
            {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }

    public function startTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->dbh->commit();
    }

    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }


}



?>