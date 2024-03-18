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

        $this->__construct1();
    }

    public function __construct1()
    {
        // Set DSN  
        //$dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname . ";charset=UTF8";
        $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname;

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create a new PDO instanace  
        try
        {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        
        // Catch any errors  
        catch (PDOException $e)
        {
            $this->error = $e->getMessage();
        }
    }

    public function query($query)
    {
      // return $this->dbh->prepare($query);
      // Store the PDOStatement object in $this->stmt
      $this->stmt = $this->dbh->prepare($query);
      // return $this->stmt;
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

    public function lastInsertId()
    {
        return $this->stmt->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->stmt->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->stmt->commit();
    }

    public function cancelTransaction()
    {
        return $this->stmt->rollBack();
    }


}



?>