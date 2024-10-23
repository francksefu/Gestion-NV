<?php
require_once __DIR__ . '/connect.php';

  class Change {
    
    public $client;

    function __construct()
    {
      $this->client = 'client';
    }

    public static function insert ($Dallar, $Chilling, $Rwandais, $CDF)
    {
      global $pdo;
	  $sql = 'INSERT INTO Change(Dallar, Chilling, Rwandais, CDF) VALUES(?,?,?,?)';

	  $statement = $pdo->prepare($sql);
	  
	  $statement->execute([
		$Dallar, $Chilling, $Rwandais, $CDF
	  ]);

	  return $pdo->lastInsertId();
    }

    public static function update ($Dallar, $Chilling, $Rwandais, $CDF, $idChange)
    {
		global $pdo;
		$employe = [
			$Dallar, $Chilling, $Rwandais, $CDF, $idChange
		];
		
		$sql = 'UPDATE Change
				SET Dallar = ?, Chilling = ?, Rwandais = ?, CDF = ?
				WHERE idChange = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the UPDATE statment
		if ($statement->execute($employe)) {
			return true;
		}
        return false;
    }

    public static function delete ($id)
    {
		global $pdo;
		
		$sql = 'DELETE FROM Change
        WHERE idChange = ?';
		
		$statement = $pdo->prepare($sql);

		// execute the DELETE statment
		if ($statement->execute([$id])) {
			return true;
		}
        return false;
    }

    public static function read()
    {
		global $pdo;
		$sql = 'SELECT * FROM `Change` ORDER BY idChange DESC';

		$statement = $pdo->query($sql);

		// get all publishers
		return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


  }