<?php
require_once __DIR__ . '/connect.php';

  class Client {
    
    public $client;

    function __construct()
    {
      $this->client = 'client';
    }

    public static function insert ($NomClient, $Telephone)
    {
      global $pdo;
	  $sql = 'INSERT INTO Client(NomClient, Telephone) VALUES(?,?)';

	  $statement = $pdo->prepare($sql);
	  
	  $statement->execute([
		$NomClient, $Telephone
	  ]);

	  return $pdo->lastInsertId();
    }

    public static function update ($NomClient, $Telephone, $idClient)
    {
		global $pdo;
		$employe = [
			$NomClient, $Telephone, $idClient
		];
		
		$sql = 'UPDATE Client
				SET NomClient = ?, Telephone = ?
				WHERE idClient = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the UPDATE statment
		if ($statement->execute($employe)) {
			return true;
		}
        return false;
    }

    public static function delete ($idClient)
    {
		global $pdo;
		
		$sql = 'DELETE FROM Client
        WHERE idClient = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the DELETE statment
		if ($statement->execute([$idClient])) {
			return true;
		}
        return false;
    }

    public static function read()
    {
		global $pdo;
		$sql = 'SELECT * FROM Client ORDER BY NomClient ASC ';

		$statement = $pdo->query($sql);

		// get all publishers
		return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


  }