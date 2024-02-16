<?php
namespace Db;

class Database
{
	private $dbHost = "localhost";
	private $dbName = "ticketing_app";
	private $dbUser = "root";
	private $dbPassword = "";
	// private $dbConn = "";

	// public function __construct($dbConn)
	// {
	// 	$this->dbConn = $dbConn;
	// }

	public function connection()
	{
		try {
			$dbConn = new \PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPassword);
			return $dbConn;
		} catch(Exception $e) {
			echo "Connection failed" . $e->getMessage();  
		}
	}

	public function runQuery($query, $params = null)
	// public function runQuery()
	{
        // $stmt = $this->connection->query($query);
        $stmt = $this->connection()->query($query);
        // $stmt->execute($params);
    	return $stmt;
    }
}
