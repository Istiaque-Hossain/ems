<?php
class Database
{
    private $connection;

    public function __construct($config)
    {
        $this->connection = mysqli_connect(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['database']
        );
        if (!$this->connection)
        {
            die('Connection failed: ' . mysqli_connect_error());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function close()
    {
        mysqli_close($this->connection);
    }
}
